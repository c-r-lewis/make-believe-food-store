<?php
namespace App\Magasin\Modele\HTTP;

use App\Magasin\Modele\DataObject\Produit;
use Exception;

class Session
{
    private static ?Session $instance = null;

    private function __construct()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        register_shutdown_function([$this, 'detruire']);
    }

    public static function getInstance(): Session
    {
        if (is_null(Session::$instance)) {
            Session::$instance = new Session();
            Session::$instance->verifierDerniereActivite();
        }
        return Session::$instance;
    }

    public function contient($nom): bool
    {
        return isset($_SESSION[$nom]);
    }

    public function enregistrer(string $nom, $valeur): void
    {
        $_SESSION[$nom] = $valeur;
    }

    public function lire(string $nom)
    {
        return $_SESSION[$nom] ?? null;
    }

    public function supprimer($nom): void
    {
        unset($_SESSION[$nom]);
    }

    public function verifierDerniereActivite()
    {
        if (isset($_SESSION['derniereActivite']) && (time() - $_SESSION['derniereActivite'] > ConfigurationSite::DUREE_EXPIRATION_SESSION)) {
            $this->detruire();
        }
        $_SESSION['derniereActivite'] = time();
    }

    public function ajouterAuPanier(Produit $produit, $quantite = 1)
    {
        if (!$this->contient('panier')) {
            $_SESSION['panier'] = [];
        }

        $produitId = $produit->getIdProduit();
        if (isset($_SESSION['panier'][$produitId])) {
            $_SESSION['panier'][$produitId] += $quantite;
        } else {
            $_SESSION['panier'][$produitId] = $quantite;
        }
    }

    public function supprimerDuPanier(Produit $produit)
    {
        $produitId = $produit->getIdProduit();
        if ($this->contient('panier') && isset($_SESSION['panier'][$produitId])) {
            unset($_SESSION['panier'][$produitId]);
        }
    }

    public function recupererPanier()
    {
        return $this->lire('panier');
    }

    public function viderPanier()
    {
        $this->supprimer('panier');
    }

    public function modifierQuantiteDansPanier(Produit $produit, $nouvelleQuantite)
    {
        if ($this->contient('panier')) {
            $produitId = $produit->getIdProduit();
            if (isset($_SESSION['panier'][$produitId])) {
                $_SESSION['panier'][$produitId] = $nouvelleQuantite;
            }
        }
    }

    public function detruire()
    {
        session_unset();
        session_destroy();
        session_write_close();
        $instance = null;
    }
}
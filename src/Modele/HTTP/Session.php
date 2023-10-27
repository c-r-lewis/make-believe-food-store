<?php
namespace App\Covoiturage\Modele\HTTP;

use Exception;

class Session
{
    private static ?Session $instance = null;

    private function __construct()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
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

    public function detruire(): void
    {
        session_unset();
        session_destroy();
        session_write_close();
        Cookie::supprimer(session_name());
        $instance = null;
    }

    public function verifierDerniereActivite()
    {
        if (isset($_SESSION['derniereActivite']) && (time() - $_SESSION['derniereActivite'] > ConfigurationSite::DUREE_EXPIRATION_SESSION)) {
            // La session a expiré, donc nous la détruisons
            $this->detruire();
        }
        $_SESSION['derniereActivite'] = time();
    }

    public function ajouterAuPanier($produitId, $quantite = 1)
    {
        if (!$this->contient('panier')) {
            $_SESSION['panier'] = [];
        }

        if (isset($_SESSION['panier'][$produitId])) {
            $_SESSION['panier'][$produitId] += $quantite;
        } else {
            $_SESSION['panier'][$produitId] = $quantite;
        }
    }

    public function supprimerDuPanier($produitId)
    {
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



}
<?php

namespace App\Magasin\Controleurs;

use App\Magasin\Lib\ConnexionUtilisateur;
use App\Magasin\Modeles\DataObject\PanierConnecte;
use App\Magasin\Modeles\DataObject\Utilisateur;
use App\Magasin\Modeles\HTTP\Cookie;
use App\Magasin\Modeles\Repository\PanierRepository;
use App\Magasin\Modeles\Repository\ProduitPanierRepository;
use App\Magasin\Modeles\Repository\ProduitRepository;
use App\Magasin\Modeles\Repository\UtilisateurRepository;

class ControleurUtilisateurGenerique extends ControleurGenerique
{

    public static function afficherPanier(): void
    {
        $produits = [];
        $panier = [];
        if (ConnexionUtilisateur::estConnecte()) {
            $recupererPanier = ((new PanierRepository())->recupererParClePrimaire([ConnexionUtilisateur::getLoginUtilisateurConnecte()])[0])->formatTableau();
            foreach ((new ProduitRepository())->recuperer() as $produit) {
                if ((new ProduitPanierRepository())->clePrimaireExiste([$recupererPanier["idPanierTag"], ($produit->formatTableau())["idProduitTag"]])) {
                    $panier[] = (new ProduitPanierRepository())->recupererParClePrimaire([$recupererPanier["idPanierTag"], ($produit->formatTableau())["idProduitTag"]]);
                }
            }
            foreach ($panier as $produitsPanier) {
                foreach ($produitsPanier as $produitPanier) {
                    $ajoutPanier = $produitPanier->formatTableau();
                    $produits[] = [
                        "produit" => (new ProduitRepository())->recupererParClePrimaire([$ajoutPanier["idProduitTag"]])[0],
                        "quantite" => $ajoutPanier["quantiteTag"]
                    ];
                }
            }

        } else {
            if (Cookie::contient("panier")) {
                $panier = Cookie::lire("panier");
            }
            foreach ($panier as $idProduit => $quantite) {
                $produits[] = ["produit" => (new ProduitRepository())->recupererParClePrimaire([$idProduit])[0],
                    "quantite" => $quantite];
            }
        }
        self::afficherVue("vueGenerale.php", ["cheminVueBody" => "utilisateur/client/panier.php", "produits" => $produits]);
    }

    public static function afficherHistorique(): void
    {

    }


    public static function afficherConnexion(): void
    {
        self::afficherVue("vueGenerale.php", ["cheminVueBody" => "utilisateur/connexion.php"]);
    }

    public static function afficherParametres(): void
    {
        if (ConnexionUtilisateur::estConnecte()) {
            self::afficherVue(
                "vueGenerale.php",
                [
                    "cheminVueBody" => "utilisateur/parametres.php",
                    "login" => ConnexionUtilisateur::getLoginUtilisateurConnecte()
                ]
            );
        }

    }

    public static function afficherInscription(): void
    {
        self::afficherVue("vueGenerale.php", ["cheminVueBody" => "utilisateur/inscription.php"]);
    }

    public static function afficherComptes(): void
    {
        self::afficherVue("vueGenerale.php", ["cheminVueBody" => "utilisateur/admin/comptes.php"]);
    }


    public static function inscription(): void
    {
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            if ((new UtilisateurRepository())->clePrimaireExiste([$_GET["email"]])) {
                // le compte est déjà enregistré
            } else if ($_GET["mdp"] != $_GET["mdp2"]) {
                // les mots de passe ne correspondent pas
            } else {
                $utilisateur = Utilisateur::construireDepuisFormulaire($_GET);
                (new UtilisateurRepository())->sauvegarder($utilisateur);

                $panierConnecte = new PanierConnecte($_GET["email"], count((new PanierRepository())->recuperer()));
                $panierRepository = new PanierRepository();
                $panierRepository->sauvegarder($panierConnecte);

                self::connexion();
            }
        }
    }

    public static function connexion(): void
    {
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            if (
                (new UtilisateurRepository())->clePrimaireExiste([$_GET["email"]])
            ) {
                ConnexionUtilisateur::connecter($_GET["email"], $_GET["mdp"]);
                ControleurProduit::afficherCatalogue();
            } else {
                // Gérer l'erreur
            }
        }
    }

    public static function deconnexion(): void
    {
        ConnexionUtilisateur::deconnecter();
        ControleurProduit::afficherCatalogue();
    }


}
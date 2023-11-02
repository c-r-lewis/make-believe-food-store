<?php

namespace App\Magasin\Controleurs;

use App\Magasin\Lib\ConnexionUtilisateur;
use App\Magasin\Modeles\DataObject\Utilisateur;
use App\Magasin\Modeles\HTTP\Cookie;
use App\Magasin\Modeles\Repository\ProduitRepository;
use App\Magasin\Modeles\Repository\UtilisateurRepository;

class ControleurUtilisateurGenerique extends ControleurGenerique {

    public static function afficherPanier() : void {
        $produits = [];
        if (ConnexionUtilisateur::estConnecte()) {
            //TODO: récupérer les produits à partir de la base de données
        }
        else {
            if (Cookie::contient("panier")) {
                $panier = Cookie::lire("panier");

                foreach ($panier as $idProduit => $quantite) {
                    $produits[] = ["produit"=>(new ProduitRepository())->recupererParClePrimaire($idProduit),
                        "quantite"=>$quantite];
                }
            }
        }
        self::afficherVue("vueGenerale.php", ["cheminVueBody"=>"utilisateur/client/panier.php", "produits"=>$produits]);
    }

    public static function afficherHistorique(): void {

    }


    public static function afficherConnexion(): void {
        self::afficherVue("vueGenerale.php", ["cheminVueBody"=>"utilisateur/connexion.php"]);
    }

    public static function afficherParametres() : void {
        self::afficherVue("vueGenerale.php", ["cheminVueBody"=>"utilisateur/parametres.php"]);

    }

    public static function afficherInscription() : void {
        self::afficherVue("vueGenerale.php", ["cheminVueBody"=>"utilisateur/inscription.php"]);
    }

    public static function afficherComptes(): void {
        self::afficherVue("vueGenerale.php", ["cheminVueBody"=>"utilisateur/admin/comptes.php"]);
    }


    public static function  inscription() : void {
        if ($_SERVER["REQUEST_METHOD"]=="GET") {
            if (!(new UtilisateurRepository())->clePrimaireExiste($_GET["email"])) {
                $utilisateur = new Utilisateur($_GET["email"], $_GET["nom"], $_GET["prenom"], $_GET["mdp"]);
                (new UtilisateurRepository())->sauvegarder($utilisateur);
                self::connexion();
            }
            else {
                //Gérer l'erreur
            }

        }
    }

    public static function connexion() : void {
        if ($_SERVER["REQUEST_METHOD"]=="GET") {
            if ((new UtilisateurRepository())->clePrimaireExiste($_GET["email"])){
                ConnexionUtilisateur::connecter($_GET["email"]);
                ControleurProduit::afficherCatalogue();
            }
            else {
                // Gérer l'erreur
            }
        }
    }

    public static function deconnexion() : void {
        ConnexionUtilisateur::deconnecter();
        ControleurProduit::afficherCatalogue();
    }



}
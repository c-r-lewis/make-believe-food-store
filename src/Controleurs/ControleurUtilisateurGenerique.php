<?php

namespace App\Magasin\Controleurs;

use App\Magasin\Lib\ConnexionUtilisateur;
use App\Magasin\Modeles\DataObject\Utilisateur;
use App\Magasin\Modeles\Repository\UtilisateurRepository;

class ControleurUtilisateurGenerique extends ControleurGenerique {

    public static function afficherPanier() : void {
        $onglets = self::recupererOnglets();
        self::afficherVue("vueGenerale.php", ["cheminVueBody"=>"utilisateur/client/panier.php", "onglets"=>$onglets]);
    }

    public static function afficherHistorique(): void {

    }


    public static function afficherConnexion(): void {
        self::afficherVue("vueGenerale.php", ["cheminVueBody"=>"utilisateur/connexion.php","onglets"=>self::recupererOnglets()]);
    }

    public static function afficherParametres() : void {
        self::afficherVue("vueGenerale.php", ["cheminVueBody"=>"utilisateur/parametres.php", "onglets"=>self::recupererOnglets()]);

    }

    public static function afficherInscription() : void {
        self::afficherVue("vueGenerale.php", ["cheminVueBody"=>"utilisateur/inscription.php", "onglets"=>self::recupererOnglets()]);
    }

    public static function afficherComptes(): void {
        self::afficherVue("vueGenerale.php", ["cheminVueBody"=>"utilisateur/admin/comptes.php", "onglets"=>self::recupererOnglets()]);
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
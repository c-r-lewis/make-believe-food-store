<?php

namespace App\Magasin\Controleurs;

use App\Magasin\Lib\ConnexionUtilisateur;
use App\Magasin\Modeles\DataObject\Utilisateur;
use App\Magasin\Modeles\Repository\UtilisateurRepository;


class ControleurUtilisateurGenerique {

    private static function afficherVue(string $cheminVue, array $parametres = []): void
    {
        extract($parametres); // Crée des variables à partir du tableau $parametres
        require __DIR__ ."/../vues/$cheminVue"; // Charge la vue
    }

    private static function recupererOnglets() : array {
        if (!ConnexionUtilisateur::estConnecte()) {
            $onglets = array("Catalogue" => "controleurFrontal.php?action=afficherCatalogue",
                "Panier" => "controleurFrontal.php?action=afficherPanier");
        }
        else {
            $login = ConnexionUtilisateur::getLoginUtilisateurConnecte();
            $utilisateur = (new UtilisateurRepository())->recupererParClePrimaire($login);
            if ($utilisateur->estAdmin()) {
                $onglets = array("Catalogue"=> "controleurFrontal.php?action=afficherCatalogue",
                    "Paramètres"=>"controleurFrontal.php?action=afficherParametresAdmin");
            }
            else {
                $onglets = array("Catalogue"=> "controleurFrontal.php?action=afficherCatalogue",
                    "Panier" => "controleurFrontal.php?action=afficherPanier",
                    "Historique" => "controleurFrontal.php?action=afficherHistorique",
                    "Paramètres" => "controleurFrontal.php?action=afficherParametresClient");
            }
        }

        return $onglets;
    }

    public static function afficherCatalogue() : void {
        $onglets = self::recupererOnglets();
        self::afficherVue("vueGenerale.php", ["cheminVueBody"=>"catalogue.php", "onglets"=>$onglets]);
    }

    public static function afficherPanier() : void {
        $onglets = self::recupererOnglets();
        self::afficherVue("vueGenerale.php", ["cheminVueBody"=>"client/panier.php", "onglets"=>$onglets]);
    }

    public static function afficherHistorique(): void {

    }


    public static function afficherConnexion(): void {
        self::afficherVue("vueGenerale.php", ["cheminVueBody"=>"connexion.php","onglets"=>self::recupererOnglets()]);
    }

    public static function afficherParametresClient() : void {
        self::afficherVue("vueGenerale.php", ["cheminVueBody"=>"client/parametres.php", "onglets"=>self::recupererOnglets()]);

    }

    public static function afficherParametresAdmin() : void {

    }

    public static function afficherInscription() : void {
        self::afficherVue("vueGenerale.php", ["cheminVueBody"=>"inscription.php", "onglets"=>self::recupererOnglets()]);
    }

    public static function afficherComptes(): void {
        self::afficherVue("vueGenerale.php", ["cheminVueBody"=>"admin/comptes.php", "onglets"=>self::recupererOnglets()]);
    }


    public static function  inscription() : void {
        if ($_SERVER["REQUEST_METHOD"]=="GET") {
            if (!(new UtilisateurRepository())->emailExiste($_GET["email"])) {
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
            if ((new UtilisateurRepository())->emailExiste($_GET["email"])){
                ConnexionUtilisateur::connecter($_GET["email"]);
                self::afficherVue("vueGenerale.php", ["cheminVueBody"=>"catalogue.php", "onglets"=>self::recupererOnglets()]);
            }
            else {
                // Gérer l'erreur
            }
        }
    }



}
<?php

namespace App\Magasin\Controleurs;

use App\Magasin\Lib\ConnexionUtilisateur;
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
                $onglets = array("Catalogue"=> "controleurFrontal.php?action=afficherCatalogue");
            }
            else {
                $onglets = array("Catalogue"=> "controleurFrontal.php?action=afficherCatalogue",
                    "Panier" => "controleurFrontal.php?action=afficherPanier",
                    "Historique" => "controleurFrontal.php?action=afficherHistorique");
            }
        }

        return $onglets;
    }

    public static function afficherCatalogue() : void {
        $onglets = self::recupererOnglets();
        self::afficherVue("vueGenerale.php", ["cheminVueBody"=>"catalogue.php", "onglets"=>$onglets]);
    }

    public static function afficherPanier() : void {

    }

    public static function afficherHistorique(): void {

    }


    public static function afficherConnexion(): void {
        self::afficherVue("vueGenerale.php", ["cheminVueBody"=>"connexion.php","onglets"=>self::recupererOnglets()]);
    }

}
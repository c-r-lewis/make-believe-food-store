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
            $onglets = array("Catalogue", "Panier");
        }
        else {
            $login = ConnexionUtilisateur::getLoginUtilisateurConnecte();
            $utilisateur = (new UtilisateurRepository())->recupererParClePrimaire($login);
            if ($utilisateur->estAdmin()) {
                $onglets = array("Catalogue");
            }
            else {
                $onglets = array("Catalogue", "Panier", "Historique");
            }
        }

        return $onglets;
    }

    public static function loadPage() : void{
        $onglets = self::recupererOnglets();
        self::afficherVue("vueGenerale.php", ["cheminVueBody"=>"exempleDeCatalogue.php", "onglets"=>$onglets]);
    }


    public static function afficherConnexion(): void {
        self::afficherVue("vueGenerale.php", ["cheminVueBody"=>"connexion.php","onglets"=>array("Catalogue", "Panier") ]);
    }

}
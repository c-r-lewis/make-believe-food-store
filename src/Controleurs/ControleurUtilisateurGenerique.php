<?php

namespace App\Magasin\Controleurs;

use App\Magasin\Lib\ConnexionUtilisateur;

class ControleurUtilisateurGenerique {

    private static function afficherVue(string $cheminVue, array $parametres = []): void
    {
        extract($parametres); // Crée des variables à partir du tableau $parametres
        require __DIR__ ."/../vues/$cheminVue"; // Charge la vue
    }

    public static function loadPage() : void{
        $login = ConnexionUtilisateur::getLoginUtilisateurConnecte();

        self::afficherVue("vueGenerale.php", []);
    }

}
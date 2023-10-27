<?php

namespace App\Magasin\Controleurs;

class ControleurUtilisateurGenerique {

    private static function afficherVue(string $cheminVue, array $parametres = []): void
    {
        extract($parametres); // Crée des variables à partir du tableau $parametres
        require __DIR__ ."/../vues/$cheminVue"; // Charge la vue
    }

    public static function loadPage() : void{

        self::afficherVue("vueGenerale.php", []);
    }

}
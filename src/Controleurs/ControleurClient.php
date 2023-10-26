<?php

namespace App\Magasin\Controleurs;
use App\Magasin\Modele\Repository\ClientRepository as ClientRepository;

class ControleurClient {

    private static function afficherVue(string $cheminVue, array $parametres = []): void
    {
        extract($parametres); // Crée des variables à partir du tableau $parametres
        require __DIR__ ."/../vues/$cheminVue"; // Charge la vue
    }

    public static function loadMenu() : void {
        ControleurClient::afficherVue('../vue/vueGenerale.php', ["cheminVue" => 'menu.php', "onglets" => (new ClientRepository())->getOngletsMenus()]);
    }




}
<?php

namespace App\Covoiturage\Controleurs;
use App\Covoiturage\Modele\Repository\ClientRepository as ClientRepository;

class ControleurClient {

    private static function afficherVue(string $cheminVue, array $parametres = []): void
    {
        extract($parametres); // Crée des variables à partir du tableau $parametres
        require __DIR__ ."/../vue/$cheminVue"; // Charge la vue
    }

    public static function loadMenu() {
        ControleurClient::afficherVue('../vue/vueGenerale.php', ["cheminVue" => 'menu.php', "onglets" => (new ClientRepository())->getOngletsMenus()]);
    }



}
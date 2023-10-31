<?php

namespace App\Magasin\Controleurs;


class ControleurProduit extends ControleurGenerique
{
    public static function afficherCatalogue() : void {
        $onglets = self::recupererOnglets();
        self::afficherVue("vueGenerale.php", ["cheminVueBody"=>"utilisateur/catalogue.php", "onglets"=>$onglets]);
    }

}
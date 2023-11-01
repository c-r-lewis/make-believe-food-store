<?php

namespace App\Magasin\Controleurs;


use App\Magasin\Modeles\Repository\ProduitRepository as ProduitRepository;

class ControleurProduit extends ControleurGenerique
{
    public static function afficherCatalogue() : void {
        $onglets = self::recupererOnglets();

        $produits = (new ProduitRepository())->recuperer();
        self::afficherVue("vueGenerale.php", ["cheminVueBody"=>"utilisateur/catalogue.php",
            "onglets"=>$onglets,
            "produits"=>$produits]);
    }

    public static function afficherCreationProduit() : void {
        self::afficherVue("vueGenerale.php", ["cheminVueBody"=>"utilisateur/admin/formulaireCreerProduit.php", "onglets"=>self::recupererOnglets()]);
    }

}
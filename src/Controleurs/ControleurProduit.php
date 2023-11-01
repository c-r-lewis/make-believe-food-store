<?php

namespace App\Magasin\Controleurs;


use App\Magasin\Modeles\DataObject\Produit;
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

    public static function creerProduit() : void {
        if ($_SERVER["REQUEST_METHOD"]=="GET") {
            (new ProduitRepository())->sauvegarder(new Produit($_GET["nomProduit"], $_GET["descriptionProduit"], $_GET["prixProduit"]));
        }
        self::afficherCatalogue();
    }

}
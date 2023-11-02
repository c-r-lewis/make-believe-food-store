<?php

namespace App\Magasin\Controleurs;


use App\Magasin\Modeles\DataObject\Produit;
use App\Magasin\Modeles\Repository\ProduitRepository as ProduitRepository;

class ControleurProduit extends ControleurGenerique
{
    public static function afficherCatalogue() : void {
        $produits = (new ProduitRepository())->recuperer();
        self::afficherVue("vueGenerale.php", ["cheminVueBody"=>"produit/catalogue.php",
            "produits"=>$produits]);
    }

    public static function afficherCreationProduit() : void {
        self::afficherVue("vueGenerale.php", ["cheminVueBody"=>"utilisateur/admin/formulaireCreerProduit.php"]);
    }

    public static function creerProduit() : void {
        if ($_SERVER["REQUEST_METHOD"]=="GET") {
            (new ProduitRepository())->sauvegarder(new Produit($_GET["nomProduit"], $_GET["descriptionProduit"], $_GET["prixProduit"]));
            self::afficherCatalogue();
        }

    }

    public static function afficherDetailProduit() : void {
        $produit = (new ProduitRepository())->recupererParClePrimaire($_GET["idProduit"]);
        self::afficherVue("vueGenerale.php", ["cheminVueBody"=>"produit/detail.php", "produit"=>$produit]);
    }

}
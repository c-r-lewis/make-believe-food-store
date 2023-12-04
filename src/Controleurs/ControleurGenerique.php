<?php

namespace App\Magasin\Controleurs;

use App\Magasin\Lib\ConnexionUtilisateur;

class ControleurGenerique
{
    protected static function afficherVue(string $cheminVue, array $parametres = []): void
    {
        extract($parametres);
        $onglets = self::recupererOnglets();
        $messagesFlash = isset($_REQUEST["messagesFlash"]) ? $_REQUEST["messagesFlash"] : [];

        require __DIR__ . "/../vues/$cheminVue";
    }


    protected static function recupererOnglets() : array {
        if (!ConnexionUtilisateur::estConnecte()) {
            $onglets = array("Catalogue"=> array("action" => "afficherCatalogue", "controleur"=>"produit"),
                "Panier" => array("action"=>"afficherPanier", "controleur"=>"utilisateurGenerique"));
            $images = array("Catalogue"=>"catalogue.png",
                "Panier" => "panier.png");
        }
        else {
            if (ConnexionUtilisateur::estAdmin()) {
                $onglets = array("Catalogue"=> array("action" => "afficherCatalogue", "controleur"=>"produit"),
                    "Nouveau produit"=> array("action" => "afficherCreationProduit", "controleur"=>"produit"),
                    "Comptes"=>array("action"=>"afficherComptes", "controleur"=>"utilisateurGenerique"));
                $images = array("Catalogue"=>"catalogue.png",
                    "Nouveau produit" => "logo-modifier.png",
                    "Comptes"=> "logo-utilisateur.png");
            }
            else {
                $onglets = array("Catalogue"=> array("action" => "afficherCatalogue", "controleur"=>"produit"),
                    "Panier" => array("action"=>"afficherPanier", "controleur"=>"utilisateurGenerique"),
                    "Historique" => array("action"=>"afficherHistorique", "controleur"=>"produit"));
                $images = array("Catalogue"=>"catalogue.png",
                    "Panier" => "panier.png",
                    "Historique" => "historique.png");
            }
        }
        return array($onglets, $images);
    }

    public static function erreur(string $message): void
    {
        self::afficherVue("vueGenerale.php", ["cheminVueBody"=>"erreur.php", "messageErreur"=>$message]);
    }

}
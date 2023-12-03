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
            $onglets = array("Catalogue" => "controleurFrontal.php?action=afficherCatalogue",
                "Panier" => "controleurFrontal.php?action=afficherPanier&controleur=utilisateurGenerique");
            $images = array("Catalogue"=>"catalogue.png",
                "Panier" => "panier.png");
        }
        else {
            if (ConnexionUtilisateur::estAdmin()) {
                $onglets = array("Catalogue"=> "controleurFrontal.php?action=afficherCatalogue",
                    "Nouveau produit"=>"controleurFrontal.php?action=afficherCreationProduit",
                    "Comptes"=>"controleurFrontal.php?action=afficherComptes&controleur=utilisateurGenerique");
                $images = array("Catalogue"=>"catalogue.png",
                    "Nouveau produit" => "logo-modifier.png",
                    "Comptes"=> "logo-utilisateur.png");
            }
            else {
                $onglets = array("Catalogue"=> "controleurFrontal.php?action=afficherCatalogue",
                    "Panier" => "controleurFrontal.php?action=afficherPanier&controleur=utilisateurGenerique",
                    "Historique" => "controleurFrontal.php?action=afficherHistorique");
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
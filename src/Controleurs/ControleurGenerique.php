<?php

namespace App\Magasin\Controleurs;

use App\Magasin\Lib\ConnexionUtilisateur;
use App\Magasin\Modeles\Repository\UtilisateurRepository;

class ControleurGenerique
{
    protected static function afficherVue(string $cheminVue, array $parametres = []): void
    {
        extract($parametres); // Crée des variables à partir du tableau $parametres
        $onglets = self::recupererOnglets();
        require __DIR__ ."/../vues/$cheminVue"; // Charge la vue
    }

    protected static function recupererOnglets() : array {
        if (!ConnexionUtilisateur::estConnecte()) {
            $onglets = array("Catalogue" => "controleurFrontal.php?action=afficherCatalogue",
                "Panier" => "controleurFrontal.php?action=afficherPanier&controleur=utilisateurGenerique");
        }
        else {
            if (ConnexionUtilisateur::estAdmin()) {
                $onglets = array("Catalogue"=> "controleurFrontal.php?action=afficherCatalogue",
                    "Nouveau produit"=>"controleurFrontal.php?action=afficherCreationProduit");
            }
            else {
                $onglets = array("Catalogue"=> "controleurFrontal.php?action=afficherCatalogue",
                    "Panier" => "controleurFrontal.php?action=afficherPanier&controleur=utilisateurGenerique",
                    "Historique" => "controleurFrontal.php?action=afficherHistorique");
            }
        }

        return $onglets;
    }

}
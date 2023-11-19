<?php

namespace App\Magasin\Controleurs;

use App\Magasin\Lib\MessageFlash;
use App\Magasin\Modeles\DataObject\Produit;
use App\Magasin\Modeles\Repository\ProduitRepository as ProduitRepository;
use App\Magasin\Modeles\DataObject\Panier as Panier;
use Exception;

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

    public static function afficherModificationProduit() : void {
        self::afficherVue("vueGenerale.php", ["cheminVueBody"=>"utilisateur/admin/formulaireMettreAJourProduit.php"]);
    }

    public static function creerProduit() : void {
        try {
            if ($_SERVER["REQUEST_METHOD"] == "GET") {
                $nomProduit = $_GET["nomProduit"];
                $descriptionProduit = $_GET["descriptionProduit"];
                $prixProduit = $_GET["prixProduit"];

                if (empty($nomProduit) || empty($descriptionProduit) || empty($prixProduit)) {
                    (new MessageFlash())->ajouter("warning","Veuillez remplir tous les champs");
                    self::afficherCreationProduit();
                    return;
                }
                if (!filter_var($prixProduit, FILTER_VALIDATE_INT)) {
                    (new MessageFlash())->ajouter("warning","Le prix doit être un entier");
                    self::afficherCreationProduit();
                    return;
                }

                $produit = new Produit($nomProduit, $descriptionProduit, $prixProduit);
                (new ProduitRepository())->sauvegarder($produit);
                self::afficherCatalogue();
            }
        } catch (Exception $e) {
            self::erreur($e->getMessage());
        }
    }

    public static function afficherDetailProduit() : void {
        try {
            if (empty($_GET["idProduit"])) {
                self::erreur("L'identifiant du produit est manquant.");
            }

            $idProduit = $_GET["idProduit"];
            if (!(new ProduitRepository())->clePrimaireExiste([$idProduit])) {
                self::erreur("Ce produit n'existe pas.");
            }

            $produit = (new ProduitRepository())->recupererParClePrimaire([$idProduit])[0];
            self::afficherVue("vueGenerale.php", ["cheminVueBody" => "produit/detail.php", "produit" => $produit]);
        } catch (\Exception $e) {
            self::erreur($e->getMessage());
        }
    }

    public static function ajouterProduitAuPanier() : void {
        if (!(new ProduitRepository())->clePrimaireExiste($_GET["idProduit"])) {
            self::erreur("Ajoutez un produit qui existe dans votre panier");
        } else if (!filter_var($_GET["idProduit"], FILTER_VALIDATE_INT)) {
            self::erreur("La quantité doit être un entier");
        } else {
            Panier::ajouterItem($_GET["idProduit"], $_GET["quantite"]);
            self::afficherDetailProduit();
        }
    }

    public static function supprimerProduitDuPanier() : void {
        if (!(new ProduitRepository())->clePrimaireExiste($_GET["idProduit"])) {
            self::erreur("Vous ne pouvez pas supprimer un produit qui n'existe pas");
        } else {
            Panier::supprimerItem((int)$_GET["idProduit"]);
            echo '<meta http-equiv="refresh" content="0;url=controleurFrontal.php?action=afficherPanier&controleur=utilisateurGenerique">';
        }
    }

    public static function modifierQuantitePanier() : void {
        if (!(new ProduitRepository())->clePrimaireExiste($_GET["idProduit"])) {
            self::erreur("Modifiez la quantité d'un produit qui est dans votre panier");
        } else if (!filter_var($_GET["idProduit"], FILTER_VALIDATE_INT)) {
            self::erreur("La quantité doit être un entier");
        } else {
            Panier::modifierQuantite($_GET["idProduit"], $_GET["quantite"]);
            echo '<meta http-equiv="refresh" content="0;url=controleurFrontal.php?action=afficherPanier&controleur=utilisateurGenerique">';
        }
    }

}
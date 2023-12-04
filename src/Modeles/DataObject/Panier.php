<?php

namespace App\Magasin\Modeles\DataObject;
use App\Magasin\Controleurs\ControleurProduit;
use App\Magasin\Lib\ConnexionUtilisateur as ConnexionUtilisateur;
use App\Magasin\Lib\MessageFlash;
use App\Magasin\Modeles\HTTP\Cookie as Cookie;
use App\Magasin\Modeles\Repository\PanierRepository;
use App\Magasin\Modeles\Repository\ProduitPanierRepository;

class Panier extends AbstractDataObject {

    public static function ajouterItem(int $idProduit, int $quantite) : void {
        if (!ConnexionUtilisateur::estConnecte()) {
            self::enregistrerDansPanierEnTantQueCookie($idProduit, $quantite);
        } else {
            $recupererPanier = ((new PanierRepository())->recupererParClePrimaire([ConnexionUtilisateur::getLoginUtilisateurConnecte()])[0])->formatTableau();
            if ((new ProduitPanierRepository())->clePrimaireExiste([$recupererPanier["idPanierTag"], $idProduit])) {
                (new MessageFlash())->ajouter("warning", "Ce produit est déja dans votre panier !");
                return;
            }
            $nouvelleQuantite = new ProduitPanier($recupererPanier["idPanierTag"], $idProduit, $quantite);
            (new ProduitPanierRepository())->sauvegarder($nouvelleQuantite);
        }
    }

    public static function diminuerQuantite(int $idProduit) : void{
        if (!ConnexionUtilisateur::estConnecte()) {
            self::enregistrerDansPanierEnTantQueCookie($idProduit, -1);
        } else {
            $recupererPanier = (new PanierRepository())->recupererParClePrimaire([ConnexionUtilisateur::getLoginUtilisateurConnecte()])[0];
            $contenuPanier = (new ProduitPanierRepository())->recupererParClePrimaire([$idProduit]);
            $i = 0;
            while (($contenuPanier[$i]->formatTableau())["idProduitTag"] != $idProduit) {
                $i++;
            }
            $contenuPanier = ($contenuPanier[$i])->formatTableau();
            $nouvelleQuantite = new ProduitPanier($contenuPanier["idPanierTag"], $contenuPanier["idProduitTag"], $contenuPanier["quantiteTag"]-1);
            (new ProduitPanierRepository())->mettreAJour($nouvelleQuantite);
        }
    }

    public static function modifierQuantite(int $idProduit, int $nvlleQuantite) : void {
        if (!ConnexionUtilisateur::estConnecte()) {
            if (Cookie::contient("panier")) {
                $panier = Cookie::lire("panier");
                if (array_key_exists($idProduit, $panier)) {
                    $panier[$idProduit] = $nvlleQuantite;
                    Cookie::enregistrer("panier", $panier);
                }
            }
        } else {
            $recupererPanier = (new PanierRepository())->recupererParClePrimaire([ConnexionUtilisateur::getLoginUtilisateurConnecte()])[0];
            $contenuPanier = (new ProduitPanierRepository())->recupererParClePrimaire([($recupererPanier->formatTableau())["idPanierTag"], $idProduit]);
            $i = 0;
            while (($contenuPanier[$i]->formatTableau())["idProduitTag"] != $idProduit) {
                $i++;
            }
            $contenuPanier = ($contenuPanier[$i])->formatTableau();
            $nouvelleQuantite = new ProduitPanier($contenuPanier["idPanierTag"], $idProduit, $nvlleQuantite);
            (new ProduitPanierRepository())->mettreAJour($nouvelleQuantite);
        }
    }

    public static function supprimerItem(int $idProduit) : void {
        if (!ConnexionUtilisateur::estConnecte()) {
            if (Cookie::contient("panier")) {
                $panier = Cookie::lire("panier");
                if (array_key_exists($idProduit, $panier)) {
                    unset($panier[$idProduit]);
                    Cookie::enregistrer("panier", $panier);
                }
            }
        } else {
            $recupererPanier = (new PanierRepository())->recupererParClePrimaire([ConnexionUtilisateur::getLoginUtilisateurConnecte()])[0];
            $nouvelleQuantite = new ProduitPanier(($recupererPanier->formatTableau())["idPanierTag"], $idProduit, 0);
            (new ProduitPanierRepository())->supprimerParAbstractDataObject($nouvelleQuantite);
        }
    }

    public static function enregistrerDansPanierEnTantQueCookie(int $idProduit, int $quantite) : void {
        if (!Cookie::contient("panier")){
            $panier[$idProduit] = $quantite;
        }
        else {
            $panier = Cookie::lire("panier");
            if(array_key_exists($idProduit, $panier)) {
                (new MessageFlash())->ajouter("warning", "Ce produit est déja dans votre panier !");
                (new ControleurProduit())->afficherCatalogue();
                return;
            }
            else {
                $panier[$idProduit] = $quantite;
            }
        }
        Cookie::enregistrer("panier", $panier);
        (new MessageFlash())->ajouter("success", "Le produit a été ajouté au panier !");
        (new ControleurProduit())->afficherCatalogue();
    }

    public function formatTableau()
    {
        return null;
    }
}
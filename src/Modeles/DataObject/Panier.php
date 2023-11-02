<?php

namespace App\Magasin\Modeles\DataObject;
use App\Magasin\Lib\ConnexionUtilisateur as ConnexionUtilisateur;
use App\Magasin\Modeles\HTTP\Cookie as Cookie;
class Panier {

    public static function ajouterItem(int $idProduit, int $quantite) : void {
        if (!ConnexionUtilisateur::estConnecte()) {
            self::enregistrerDansPanierEnTantQueCookie($idProduit, $quantite);
        }
    }

    public static function diminuerQuantite(int $idProduit) : void{
        if (!ConnexionUtilisateur::estConnecte()) {
            self::enregistrerDansPanierEnTantQueCookie($idProduit, -1);
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

        }
    }

    private static function enregistrerDansPanierEnTantQueCookie(int $idProduit, int $quantite) : void {
        if (!Cookie::contient("panier")){
            $panier[$idProduit] = $quantite;
        }
        else {
            $panier = Cookie::lire("panier");
            if(array_key_exists($idProduit, $panier)) {
                $panier[$idProduit] += $quantite;
            }
            else {
                $panier[$idProduit] = $quantite;
            }
        }
        Cookie::enregistrer("panier", $panier);
    }
}
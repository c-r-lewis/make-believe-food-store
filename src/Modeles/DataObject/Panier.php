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

    public static function supprimerItem(int $idProduit) : void {
        if (!ConnexionUtilisateur::estConnecte()) {
            if (Cookie::contient("panier")) {
                $panier = Cookie::lire("panier");
                if (isset($panier[$idProduit])) {
                    unset($panier[$idProduit]);
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
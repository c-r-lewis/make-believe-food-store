<?php

namespace App\Magasin\Modeles\DataObject;
use App\Magasin\Lib\ConnexionUtilisateur as ConnexionUtilisateur;
use App\Magasin\Modeles\HTTP\Cookie as Cookie;
class Panier {

    public static function ajouterItem(int $idProduit, int $quantite) : void {
        if (!ConnexionUtilisateur::estConnecte()) {
            self::enregistrerPanierEnTantQueCookie($idProduit, $quantite);
        }
    }

    private static function enregistrerPanierEnTantQueCookie(int $idProduit, int $quantite) : void {
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
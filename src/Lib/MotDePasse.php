<?php

namespace App\Magasin\Lib;

class MotDePasse
{

    private static string $poivre = "QnD2cbN4jipTkreM05KDNK";

    public static function hacher(string $mdpClair): string
    {
        $mdpPoivre = hash_hmac("sha256", $mdpClair, MotDePasse::$poivre);
        $mdpHache = password_hash($mdpPoivre, PASSWORD_DEFAULT);
        return $mdpHache;
    }

    public static function verifier(string $mdpClair, string $mdpHache): bool
    {
        $mdpPoivre = hash_hmac("sha256", $mdpClair, MotDePasse::$poivre);
        return password_verify($mdpPoivre, $mdpHache);
    }

    public static function genererChaineAleatoire(int $longueur = 10): string
    {
        $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $longueurCaracteres = strlen($caracteres);
        $chaineAleatoire = '';

        for ($i = 0; $i < $longueur; $i++) {
            $chaineAleatoire .= $caracteres[random_int(0, $longueurCaracteres - 1)];
        }

        return $chaineAleatoire;
    }
}

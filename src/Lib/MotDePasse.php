<?php

namespace App\Magasin\Lib;

class MotDePasse
{

// Exécutez genererChaineAleatoire() et stockez sa sortie dans le poivre
private static string $poivre = "";

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
}

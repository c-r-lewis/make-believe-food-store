<?php

namespace App\Magasin\Modele\HTTP;

class Cookie
{
    public static function enregistrer(string $cle, mixed $valeur, ?int $dureeExpiration = null): void
    {

        if ($dureeExpiration == null) {
            setcookie($cle, serialize($valeur));
        } else {
            setcookie($cle, serialize($valeur), time() + $dureeExpiration);
        }
    }

    public static function lire(string $cle): mixed
    {
        return isset($_COOKIE[$cle]) ? unserialize($_COOKIE[$cle]) : null;
    }

    public static function contient($cle): bool
    {
        return isset($_COOKIE[$cle]);
    }

    public static function supprimer($cle) : void
    {
        if (self::contient($cle))
        {
            unset($_COOKIE[$cle]);
        }
    }
}
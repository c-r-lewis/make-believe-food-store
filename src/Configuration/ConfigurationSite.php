<?php

namespace App\Magasin\Configuration;

class ConfigurationSite {
    public static function getURLAbsolue(): string
    {
        $protocole = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
        $hote = $_SERVER['HTTP_HOST'];
        $chemin = dirname($_SERVER['PHP_SELF']);

        $urlAbsolue = "$protocole://$hote$chemin";

        return $urlAbsolue;
    }
}
<?php

namespace App\Magasin\Lib;

use App\Covoiturage\Modele\HTTP\Session;

class ConnexionUtilisateur
{
    private static $cleConnexion = "_utilisateurConnecte";

    public static function connecter(string $login): void {
        $sessionEnCours = Session::getInstance();
        $sessionEnCours -> enregistrer(ConnexionUtilisateur::$cleConnexion, $login);
    }

    public static function getLoginUtilisateurConnecte(): ?string {
        if (!self::estConnecte()) {
            return null;
        }
        else {
            return Session::getInstance()->lire(ConnexionUtilisateur::$cleConnexion);
        }
    }

    public static function estConnecte(): bool {
        return Session::getInstance()->contient(ConnexionUtilisateur::$cleConnexion);
    }

    public static function deconnecter(): void {
        Session::getInstance()->detruire();
    }


}
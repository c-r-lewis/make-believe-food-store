<?php

namespace App\Magasin\Lib;

use App\Magasin\Controleurs\ControleurGenerique;
use App\Magasin\Controleurs\ControleurUtilisateurGenerique;
use App\Magasin\Modeles\HTTP\Session;
use App\Magasin\Modeles\Repository\UtilisateurRepository;

class ConnexionUtilisateur
{
    private static $cleConnexion = "_utilisateurConnecte";

    public static function connecter(string $login, string $mdpClair): void {
        $utilisateur = (new UtilisateurRepository())->recupererParClePrimaire([$login])[0];
        if (MotDePasse::verifier($mdpClair, $utilisateur->getMdpHache())) {
            $sessionEnCours = Session::getInstance();
            $sessionEnCours->enregistrer(ConnexionUtilisateur::$cleConnexion, $login);
        } else {
            (new MessageFlash())->ajouter("warning", "Email ou mot de passe incorrect !");
            (new ControleurUtilisateurGenerique())::afficherConnexion();
        }
    }

    public static function getLoginUtilisateurConnecte(): ?string {
        if (!self::estConnecte()) {
            return null;
        }
        else {
            return Session::getInstance()->lire(ConnexionUtilisateur::$cleConnexion);
        }
    }

    public static function setLoginUtilisateurConnecte(string $email): void {
        if (self::estConnecte()) {
            Session::getInstance()->enregistrer(ConnexionUtilisateur::$cleConnexion, $email);
        }
    }

    public static function estConnecte(): bool {
        return Session::getInstance()->contient(ConnexionUtilisateur::$cleConnexion);
    }

    public static function estAdmin(): bool {
        if (self::estConnecte()) {
            return (new UtilisateurRepository())->recupererParClePrimaire([self::getLoginUtilisateurConnecte()])[0]->estAdmin();
        }
        return false;
    }

    public static function deconnecter(): void {
        Session::getInstance()->detruire();
    }


}
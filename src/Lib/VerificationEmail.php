<?php
namespace App\Magasin\Lib;

use App\Magasin\Configuration\ConfigurationSite;
use App\Magasin\Modeles\DataObject\Utilisateur;
use App\Magasin\Modeles\Repository\UtilisateurRepository;

class VerificationEmail
{
    public static function envoiEmailValidation(Utilisateur $utilisateur): void
    {
        $loginURL = rawurlencode($utilisateur->getEmail());
        $nonceURL = rawurlencode($utilisateur->getNonce());
        $URLAbsolue = ConfigurationSite::getURLAbsolue();
        $lienValidationEmail = "$URLAbsolue?action=validerEmail&controleur=utilisateur&login=$loginURL&nonce=$nonceURL";
        $contenuEmail = "<a href=\"$lienValidationEmail\">Validation</a>";

        var_dump($contenuEmail);

        self::envoyerEmail($utilisateur->getEmail(), "Validation de l'adresse email", $contenuEmail);
    }

    public static function traiterEmailValidation($login, $nonce): bool
    {
        $utilisateurRepository = new UtilisateurRepository();
        $utilisateur = $utilisateurRepository->recupererParClePrimaire($login)[0];

        if ($utilisateur !== null && $utilisateur->getNonce() === $nonce) {
            $utilisateur->setEmailAValider('');
            $utilisateurRepository->mettreAJour($utilisateur);
            return true;
        }
        return false;
    }

    public function validerEmail(): void
    {
        $login = $_GET['login'] ?? null;
        $nonce = $_GET['nonce'] ?? null;

        if ($login === null || $nonce === null) {
            $this->afficherErreur('Paramètres manquants pour la validation de l\'email.');
            return;
        }

        $validationReussie = self::traiterEmailValidation($login, $nonce);

        if ($validationReussie) {
            $this->afficherPageDetailUtilisateur($login);
        } else {
            $this->afficherErreur('Échec de la validation de l\'email.');
        }
    }

    private static function envoyerEmail($destinataire, $sujet, $contenuHTML): void
    {
        $enTete = "MIME-Version: 1.0" . "\r\n";
        $enTete .= "Content-type:text/html;charset=UTF-8" . "\r\n";

        mail($destinataire, $sujet, $contenuHTML, $enTete);
    }

    private function afficherErreur($message): void
    {
        echo "Erreur: $message";
    }

    private function afficherPageDetailUtilisateur($login): void
    {
        echo "Page de détail de l'utilisateur $login";
    }
}

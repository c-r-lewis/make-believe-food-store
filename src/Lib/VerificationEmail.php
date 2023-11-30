<?php
namespace App\Magasin\Lib;

use App\Magasin\Configuration\ConfigurationSite;
use App\Magasin\Controleurs\ControleurProduit;
use App\Magasin\Modeles\DataObject\Utilisateur;
use App\Magasin\Modeles\Repository\UtilisateurRepository;

class VerificationEmail
{
    public static function envoiEmailValidation(Utilisateur $utilisateur): void
    {
        $loginURL = rawurlencode($utilisateur->getEmail());
        $nonceURL = rawurlencode($utilisateur->getNonce());
        $URLAbsolue = "https://webinfo.iutmontp.univ-montp2.fr/~renautj/make-believe-food/web/controleurFrontal.php";
        $lienValidationEmail = "$URLAbsolue?action=validerEmail&controleur=utilisateurGenerique&login=$loginURL&nonce=$nonceURL";
        $contenuEmail = "<p>Appuyez sur ce bouton pour valider votre email : <button style=\"padding: 10px; background-color: #4CAF50; color: white; border: none; border-radius: 5px;\"><a href=\"$lienValidationEmail\" style=\"text-decoration: none; color: white;\">Valider</a></button></p>";
        self::envoyerEmail($utilisateur->getEmail(), "Validation de l'adresse email", $contenuEmail);
    }

    public static function traiterEmailValidation($login, $nonce): bool
    {
        $utilisateurRepository = new UtilisateurRepository();
        $utilisateur = $utilisateurRepository->recupererParClePrimaire([$login])[0];

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
            (new MessageFlash())->ajouter('danger','Paramètres manquants pour la validation de l\'email.');
            (new ControleurProduit())::afficherCatalogue();
            return;
        }

        $validationReussie = self::traiterEmailValidation($login, $nonce);

        if ($validationReussie) {
            (new MessageFlash())->ajouter("success","Votre email a été validé !");
            (new ControleurProduit())::afficherCatalogue();
        } else {
            (new MessageFlash())->ajouter('danger','Échec de la validation de l\'email.');
            (new ControleurProduit())::afficherCatalogue();
        }
    }

    private static function envoyerEmail($destinataire, $sujet, $contenuHTML): void
    {
        $enTete = "MIME-Version: 1.0" . "\r\n";
        $enTete .= "Content-type:text/html;charset=UTF-8" . "\r\n";

        mail($destinataire, $sujet, $contenuHTML, $enTete);
    }

    private function afficherPageDetailUtilisateur($login): void
    {
        echo "Page de détail de l'utilisateur $login";
    }
}

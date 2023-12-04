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

    public static function envoiAchatConnecte(array $produits): void
    {
        $URLAbsolue = "https://webinfo.iutmontp.univ-montp2.fr/~renautj/make-believe-food/web/controleurFrontal.php";

        $contenuEmail = '<main class="d-flex justify-content-center align-items-center">';
        $contenuEmail .= '<div class="card p-4" style="width: 25rem; height: fit-content">';
        $contenuEmail .= '<div class="card-header">Détail de la commande</div>';
        $contenuEmail .= '<ul class="list-group list-group-flush">';
        $contenuEmail .= '<li class="list-group-item"><div class="row">';
        $contenuEmail .= '<div class="col-6"><span>Date</span><br><span>' . date('d F Y') . '</span></div>';
        $contenuEmail .= '<div class="col-6 d-flex flex-column align-items-end"><span>Commande N°</span><br>';
        $contenuEmail .= '<span>' . uniqid() . '</span></div></div></li>';

        foreach ($produits as $produit) {
            $contenuEmail .= '<li class="list-group-item"><div class="row">';
            $contenuEmail .= '<div class="col-5"><span>' . htmlspecialchars($produit->getNomProduit()) . '</span></div>';
            $contenuEmail .= '<div class="col-4">' . htmlspecialchars($produit->getQuantite()) . ' x ' . htmlspecialchars($produit->getPrixProduitUnitaire()) . ' €</div>';
            $contenuEmail .= '<div class="col-3"><span>' . htmlspecialchars($produit->getPrixProduitUnitaire() * $produit->getQuantite()) . ' €</span></div>';
            $contenuEmail .= '</div></li>';
        }

        $contenuEmail .= '<li class="list-group-item"><div class="row">';
        $contenuEmail .= '<div class="col-9"><span><strong>Total</strong></span></div>';
        $contenuEmail .= '<span class="col-3"><strong>';

        $prixTotalHistorique = array_reduce(
            $produits,
            function ($total, $produit) {
                return $total + $produit->getPrixProduitUnitaire() * $produit->getQuantite();
            },
            0
        );

        $contenuEmail .= '<p>' . htmlspecialchars($prixTotalHistorique) . ' €</p></strong></span></div></li>';
        $contenuEmail .= '</ul></div></main>';

        $lienValidationEmail = "$URLAbsolue?action=afficherDetailProduit";
        self::envoyerEmail(ConnexionUtilisateur::getLoginUtilisateurConnecte(), "Validation de l'achat", $contenuEmail);
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
        $enTete = "MIME-Version: 1.0\r\n";
        $enTete .= "Content-type:text/html;charset=UTF-8\r\n";
        //$enTete .= "From: votre_adresse_email@example.com\r\n";

        mail($destinataire, $sujet, $contenuHTML, $enTete);
    }

    private function afficherPageDetailUtilisateur($login): void
    {
        echo "Page de détail de l'utilisateur $login";
    }
}

<?php

use App\Magasin\Controleurs\ControleurProduit;
use App\Magasin\Controleurs\ControleurUtilisateurGenerique;
use App\Magasin\Lib\ConnexionUtilisateur as ConnexionUtilisateur;
use App\Magasin\Lib\MessageFlash;
use App\Magasin\Lib\MotDePasse;
use App\Magasin\Lib\VerificationEmail;
use \App\Magasin\Modeles\DataObject\Utilisateur as Utilisateur;
use \App\Magasin\Modeles\Repository\UtilisateurRepository as UtilisateurRepository;

/** @var string $login */
/** @var Utilisateur $utilisateur */
?>
<section>
    <div>
        <div style="display: flex; justify-content: space-between">
            <p>Paramètres</p>
            <?php
            if (!ConnexionUtilisateur::estAdmin()) {
                echo '<img src="../../../ressources/images/logo-supprimer.png" style="height: 40px; width: 40px"/>';
            }
            ?>

        </div>
        <form method="get" action="../web/controleurFrontal.php">
            <?php
            $utilisateur = (new UtilisateurRepository)->recupererParClePrimaire([ConnexionUtilisateur::getLoginUtilisateurConnecte()])[0];
            $utilisateur->setEmailAValider($utilisateur->getEmail());
            $email = $utilisateur->getEmail();

            if (!$email) {
                (new MessageFlash())->ajouter("warning", "Adresse email invalide !");
                (new ControleurUtilisateurGenerique())->afficherParametres();
                return;
            }

            if ((new UtilisateurRepository())->clePrimaireExiste([$email])) {
                (new MessageFlash())->ajouter("warning", "L'email est déjà utilisé !");
                (new ControleurProduit())->afficherCatalogue();
                return;
            }

            if ($_GET["mdp"] != $_GET["mdp2"]) {
                (new MessageFlash())->ajouter("warning", "Les mots de passe ne sont pas identiques !");
                (new ControleurProduit())->afficherCatalogue();
                return;
            }

            $utilisateur = Utilisateur::construireDepuisFormulaire($_GET);
            $utilisateur->setEmailAValider($email);
            $utilisateur->setNonce(MotDePasse::genererChaineAleatoire());

            (new UtilisateurRepository())->sauvegarder($utilisateur);

            VerificationEmail::envoiEmailValidation($utilisateur);

            (new MessageFlash())->ajouter("success", "Vos modifications ont été enregistrées ! Un email de validation a été envoyé !");
            (new ControleurProduit())->afficherCatalogue();
            ?>
            <div class="block-connexion">
                <label for="mpdActuel">Mot de passe</label><br>
                <input type="password" id="mpdActuel" name="mdpActuel" required><br>
                <div style="margin-right: 15px">
                    <label for="nom">Nom</label><br>
                    <input type="text" id="nom" name="nom" placeholder="<?= $utilisateur->getNom() ?>"><br>
                </div>
                <div>
                    <label for="prenom">Prenom</label><br>
                    <input type="text" id="prenom" name="prenom" placeholder="<?= $utilisateur->getPrenom() ?>"><br>
                </div>
            </div>
            <label for="email">Email</label><br>
            <input type="text" id="email" name="email" placeholder="<?= $utilisateur->getEmail() ?>"><br>

            <label for="mdpNouveau">Nouveau mot de passe</label><br>
            <input type="password" id="mdpNouveau" name="mdpNouveau"><br>
            <label for="mdpNouveau2">Confirmation mot de passe</label><br>
            <input type="password" id="mdpNouveau2" name="mdpNouveau2"><br>
            <input type="hidden" name="action" value="miseAJourParametres"><br>
            <input type="hidden" name="controleur" value="utilisateurGenerique"><br>
            <input class="button" type="submit" value="Sauvegarder"><br>

        </form>
    </div>
</section>
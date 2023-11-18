<?php

use App\Magasin\Lib\ConnexionUtilisateur as ConnexionUtilisateur;
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
            <p>Informations personelles</p>
            <?php
            $utilisateur = (new UtilisateurRepository)->recupererParClePrimaire($login)
            ?>
            <div class="block-connexion">
                <div style="margin-right: 15px">
                    <label for="nom">Nom</label>
                    <input type="text" id="nom" name="nom" value="<?= $utilisateur->getNom() ?>">
                </div>
                <div>
                    <label for="prenom">Prenom</label>
                    <input type="text" id="prenom" name="prenom" value="<?= $utilisateur->getPrenom() ?>">
                </div>
            </div>
            <label for="email">Email</label>
            <input type="text" id="email" name="email" value="<?= $utilisateur->getEmail() ?>">
            <h4>Mot de passe</h4>
            <label for="mpdActuel">Mot de passe actuel</label>
            <input type="text" id="mpdActuel" name="mdpActuel">
            <label for="mdpNouveau">Nouveau mot de passe</label>
            <input type="text" id="mdpNouveau" name="mdpNouveau">
            <label for="mdpNouveau2">Confirmation mot de passe</label>
            <input type="text" id="mdpNouveau2" name="mdpNouveau2">
            <input type="hidden" name="action" value="miseAJourParametres">
            <input type="hidden" name="controleur" value="utilisateurGenerique">
            <input class="button" type="submit" value="Sauvegarder">

        </form>
    </div>
</section>
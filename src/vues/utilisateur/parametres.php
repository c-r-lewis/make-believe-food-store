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
            <?php
            $utilisateur = (new UtilisateurRepository)->recupererParClePrimaire([$login])[0];
            ?>
            <div class="block-connexion">
                <label for="mpdActuel">Mot de passe</label><br>
                <input type="password" id="mpdActuel" name="mdpActuel"><br>
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
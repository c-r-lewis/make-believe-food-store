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
        <p>Informations personelles</p>
        <?php
        $utilisateur = (new UtilisateurRepository)->recupererParClePrimaire($login)[0]
        ?>
        <div class="block-connexion">
            <div style="margin-right: 15px">
                <p>Nom</p>
                <input type="text" value="<?= $utilisateur->getNom() ?>">
            </div>
            <div>
                <p>Prenom</p>
                <input type="text" value="<?= $utilisateur->getPrenom() ?>">
            </div>
        </div>
        <p>Email</p>
        <input type="text" value="<?= $utilisateur->getEmail() ?>">
        <p>Mot de passe</p>
        <p>Mot de passe actuel</p>
        <input type="text">
        <p>Nouveau mot de passe</p>
        <input type="text">
        <p>Confirmation mot de passe</p>
        <input type="text">
        <input class="button" type="submit" value="Sauvegarder">
    </div>
</section>
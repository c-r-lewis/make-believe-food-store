<section>
    <p>Comptes utilisateurs</p>

    <?php
    /** @var array $comptes*/

    foreach ($comptes as $compte): ?>
        <div class="item">
            <img src="../../../../ressources/images/logo-utilisateur.png">
            <p><?php echo $compte->toString(); ?></p>
            <a href="controleurFrontal.php?action=supprimerCompte&controleur=UtilisateurGenerique&email=<?php echo urlencode($compte->getEmail()); ?>">
                <button><img src="../../../../ressources/images/logo-supprimer.png"></button>
            </a>
        </div>
    <?php endforeach; ?>
</section>

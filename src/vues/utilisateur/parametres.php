<section>
    <div>
        <div style="display: flex; justify-content: space-between">
            <p>Paramètres</p>
            <?php
            use App\Magasin\Lib\ConnexionUtilisateur as ConnexionUtilisateur;
            echo '<img src="../../../ressources/images/logo-supprimer.png" style="height: 40px; width: 40px"/>';
            ?>

        </div>
        <p>Informations personelles</p>
        <div class="block-connexion">
            <div style="margin-right: 15px">
                <p>Nom</p>
                <input type="text" value="Nom">
            </div>
            <div>
                <p>Prenom</p>
                <input type="text" value="Prenom">
            </div>
        </div>
        <p>Email</p>
        <input type="text" value="xx@gmail.com">
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
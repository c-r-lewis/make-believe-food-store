<section class="block-connexion">
    <div class="infos-compte">

        <form method="get" action="../web/controleurFrontal.php">
            <p>Se connecter</p>
            <p>
                <input class="input" name="email" type="text" placeholder="Email" required/>
            </p>

            <p>
                <input class="input" type="text" placeholder="Mot de passe" required/>
            </p>
            <p>
                <input class="button" type="submit" value="Se connecter">
                <input type="hidden" name="action" value="connexion">
                <input type="hidden" name="controleur" value="utilisateurGenerique">
            </p>
            <p><span id="detail">Pas de compte ? <a href="controleurFrontal.php?action=afficherInscription&controleur=utilisateurGenerique">Inscrivez-vous</a></p>
        </form>
    </div>
    <div class="bienvenue">
        <p>BIENVENUE</p>
    </div>
</section>



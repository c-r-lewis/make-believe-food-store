<section class="block-connexion">
    <div class="bienvenue">
        <p>BIENVENUE</p>
    </div>
    <div class="infos-compte">
        <form method="get" action="../web/controleurFrontal.php">
            <p>S'inscrire</p>
            <p>
                <input type="text" placeholder="Email" name="email">
            </p>
            <div class="info-details">
                <p>
                    <input type="text" placeholder="Nom" name="nom">
                </p>
                <p>
                    <input type="text" placeholder="Prenom" name="prenom">
                </p>
            </div>
            <div class="info-details">
                <p class="InputAddOn">
                    <input class="InputAddOn-field" type="password" placeholder="Mot de passe" name="mdp" required>
                </p>
                <p class="InputAddOn">
                    <input class="InputAddOn-field" type="password" placeholder="Confirmer mot de passe" name="mdp2" required>
                </p>

            </div>
            <p>
                <input class="button" type="submit" value="S'inscrire">
            </p>
            <p><span id="detail">Déjà un compte ? <a href="controleurFrontal.php?action=afficherConnexion">Connectez-vous</a></p>

            <input type="hidden" name="action" value="inscription">
        </form>
    </div>
</section>
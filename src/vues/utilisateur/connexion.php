
<main class="d-flex align-items-center">
    <div class="container-fluid p-3">
        <div class="row gx-0" style="height: 80dvh">
            <div class="col-6 d-flex align-items-center flex-column
            justify-content-center data-entry rounded-start">
                <span class="mb-5">Se connecter</span>
                <form method="post" action="../web/controleurFrontal.php" class="d-flex align-items-center flex-column justify-content-center">
                    <input class="mb-4" name="email" type="text" placeholder="Email" required/>
                    <input class="mb-4" name="mdp" type="password" placeholder="Mot de passe" required/>
                    <input class="texte-white mb-3" type="submit" value="Se connecter">
                    <input type="hidden" name="action" value="connexion">
                    <input type="hidden" name="controleur" value="utilisateurGenerique">
                </form>
                <span>Pas de compte ? <a href="controleurFrontal.php?action=afficherInscription&controleur=utilisateurGenerique">Inscrivez-vous</a></span>
            </div>
            <div class="col-6 d-flex align-items-center flex-column
                 justify-content-center filler rounded-end">
                <span class="text-white">Bienvenue</span>
            </div>
        </div>
    </div>
</main>



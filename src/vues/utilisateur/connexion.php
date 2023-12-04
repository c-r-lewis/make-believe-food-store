
<main class="d-flex align-items-center">
    <div class="container-fluid p-3">
        <div class="row gx-0 d-flex flex-md-column flex-sm-row-reverse" style="height: 80dvh">
            <div class="col-md-6 col-sm-12 d-flex align-items-center flex-column
            justify-content-center data-entry">
                <span class="mb-5">Se connecter</span>
                <form method="post" action="../web/controleurFrontal.php" class="d-flex align-items-center flex-column justify-content-center">
                    <input class="mb-4" name="email" type="text" placeholder="Email" required/>
                    <input class="mb-4" name="mdp" type="password" placeholder="Mot de passe" required/>
                    <input class="texte-white mb-3" type="submit" value="Se connecter">
                    <input type="hidden" name="action" value="connexion">
                    <input type="hidden" name="controleur" value="utilisateurGenerique">
                </form>
                <span class="d-flex align-items-center">Pas de compte ?
                    <form method="post" action="../web/controleurFrontal.php">
                        <input type="hidden" name="action" value="afficherInscription">
                        <input type="hidden" name="controleur" value="utilisateurGenerique">
                        <button class="btn btn-link">Inscrivez-vous</button>
                    </form>
                </span>
            </div>
            <div class="col-md-6 col-sm-12 d-none d-md-flex align-items-center flex-column
                 justify-content-center filler" style="height: 100%">
                <span class="text-white">Bienvenue</span>
            </div>
        </div>
    </div>
</main>



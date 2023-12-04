<main class="d-flex align-items-center">
    <div class="container-fluid p-3">
        <div class="row gx-0" style="height: 80dvh">
            <div class="col-6 d-none d-md-flex align-items-center flex-column
                 justify-content-center filler rounded-start" style="height: 100%">
                <span class="text-white">Bienvenue</span>
            </div>
            <div class="col-md-6 col-sm-12 d-flex align-items-center flex-column
            justify-content-center data-entry rounded-end">
                <span class="mb-5">S'inscrire</span>

                <form method="post" action="../web/controleurFrontal.php" class="d-flex align-items-center flex-column justify-content-center">
                    <input type="text" class="mb-4" placeholder="Email" name="email">
                    <input type="text" class="mb-4" placeholder="Nom" name="nom">
                    <input type="text" class="mb-4" placeholder="Prenom" name="prenom">
                    <div class="info-details">
                        <p class="InputAddOn">
                            <input class="InputAddOn-field" type="password" placeholder="Mot de passe" name="mdp" required>
                        </p>
                        <p class="InputAddOn">
                            <input class="InputAddOn-field" type="password" placeholder="Confirmer mot de passe" name="mdp2" required>
                        </p>
                    </div>
                    <input class="texte-white mb-3" type="submit" value="S'inscrire">
                    <input type="hidden" name="action" value="inscription">
                    <input type="hidden" name="controleur" value="utilisateurGenerique">
                </form>
                <span class="d-flex align-items-center">Déjà un compte ?
                    <form action="../web/controleurFrontal.php" method="post">
                        <input type="hidden" name="action" value="afficherConnexion">
                        <input type="hidden" name="controleur" value="utilisateurGenerique">
                        <button class="btn btn-link">Connectez-vous</button>
                    </form>
                </span>
            </div>
        </div>
    </div>
</main>
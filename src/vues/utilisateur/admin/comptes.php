<main>
    <div class="wrapper rounded mx-3">
        <div class="table-responsive mt-3">
            <table class="table table-light table-borderless">
                <thead>
                <tr>
                    <th scope="col">Utilisateurs</th>
                    <th scope="col" class="text-right"></th>
                </tr>
                </thead>
                <tbody>
                <?php
                /** @var array $comptes */

                foreach ($comptes as $compte): ?>
                    <tr>
                        <td class="text-muted"><?= htmlspecialchars($compte->getEmail())?></td>
                        <td class="d-flex justify-content-end align-items-center">
                            <form action="../web/controleurFrontal.php" method="post">
                                <input type="hidden" name="controleur" value="utilisateurGenerique">
                                <input type="hidden" name="action" value="supprimerCompte">
                                <input type="hidden" name="email" value="<?= urlencode($compte->getEmail()); ?>">
                                <button class="btn btn-link" type="submit">
                                    <img src="../../../../ressources/images/logo-supprimer.png" height="50" alt="Supprimer">
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

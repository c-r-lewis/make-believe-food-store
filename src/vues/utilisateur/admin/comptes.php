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
                            <a href="controleurFrontal.php?action=supprimerCompte&email=<?php echo urlencode($compte->getEmail()); ?>">
                                <img src="../../../../ressources/images/logo-supprimer.png" height="50">
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

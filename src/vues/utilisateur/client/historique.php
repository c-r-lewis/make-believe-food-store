<main>
    <div class="wrapper rounded mx-3">
        <div class="table-responsive mt-3">
            <table class="table table-light table-borderless">
                <thead>
                <tr>
                    <th scope="col">Date</th>
                    <th scope="col" class="d-flex justify-content-end">Prix</th>
                </tr>
                </thead>
                <tbody>
                    <?php
                    /** @var array $achats */

                    foreach ($achats as $achat):
                    ?>
                    <tr>
                        <td class="text-muted">
                            <form action="../web/controleurFrontal.php" method="post">
                                <input type="hidden" name="action" value="afficherDetailAchat">
                                <input type="hidden" name="idAchat" value="<?=urlencode($achat->getIdAchat())?>">
                                <button type="submit" class="btn btn-link">
                                    <?= htmlspecialchars($achat->getDate())?>
                                </button>
                            </form>
                        </td>
                        <td class="d-flex justify-content-end align-items-center">
                            <?=$achat->getIdAchat()?>
                        </td>
                    </tr>
                    <?php endforeach;
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

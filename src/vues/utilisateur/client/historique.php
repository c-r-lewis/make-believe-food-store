<main>
    <div class="wrapper rounded mx-3">
        <div class="table-responsive mt-3">
            <table class="table table-dark table-borderless">
                <thead>
                <tr>
                    <th scope="col">Date</th>
                    <th scope="col" class="text-right">Prix</th>
                </tr>
                </thead>
                <tbody>
                <?php
                /** @var array $achats */

                foreach ($achats as $achat) {
                    echo '
                <a href="controleurFrontal.php?action=afficherDetailAchat&idAchat='.$achat->getIdAchat().'">
                    <tr>
                        <td class="text-muted">'.htmlspecialchars($achat->getDate()).'</td>
                        <td class="d-flex justify-content-end align-items-center">
                            $52.9
                        </td>
                    </tr>
                </a>';
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

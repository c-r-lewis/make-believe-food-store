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

                foreach ($achats as $achat) {
                    echo '<tr>';
                    echo '<td class="text-muted"><a style="color: black; text-decoration: none;" href="controleurFrontal.php?action=afficherDetailAchat&idAchat=' . $achat->getIdAchat() . '">' . htmlspecialchars($achat->getDate()) . '</a></td>';
                    echo '<td class="d-flex justify-content-end align-items-center">$52.9</td>';
                    echo '</tr>';
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

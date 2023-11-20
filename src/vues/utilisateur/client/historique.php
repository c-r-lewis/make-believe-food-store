<section class="grille-achats">
    <p>Historique</p>
    <div class="line"></div>
    <?php
    /** @var array $achats */

    foreach ($achats as $achat) {
        echo '<div class="achat">
            <p>Date: '.htmlspecialchars($achat->getDate()).'</p>
            <p>Montant total: '.htmlspecialchars($achat->getMontantTotal()).'</p>
            <a href="controleurFrontal.php?action=afficherDetailAchat&idAchat='.$achat->getIdAchat().'">Voir détails</a>
        </div>';
    }
    ?>
</section>

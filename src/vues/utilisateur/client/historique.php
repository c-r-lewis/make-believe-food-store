<section>
    <p>Historique</p>
    <div class="line"></div>
    <section class="grille-produits">
    <?php
    /** @var array $achats */

    foreach ($achats as $achat) {
        echo '<div class="article">
            <p>Id: '.htmlspecialchars($achat->getIdAchat()).'</p>
            <p>Date: '.htmlspecialchars($achat->getDate()).'</p>
            <a href="controleurFrontal.php?action=afficherDetailAchat&idAchat='.$achat->getIdAchat().'">Voir détails</a>
        </div>';
    }
    ?>
    </section>
</section>

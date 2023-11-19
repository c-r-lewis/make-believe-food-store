<?php
use App\Magasin\Modeles\DataObject\Produit as Produit;
/** @var Produit $produit */
?>

<section>
    <p>Nom produit : <?php echo htmlspecialchars($produit->getNomProduit()); ?></p>
    <p>Description produit : <?php echo htmlspecialchars($produit->getDescriptionProduit()); ?></p>
    <p>Prix produit : <?php echo htmlspecialchars($produit->getPrixProduit()); ?></p>

    <form action="../web/controleurFrontal.php" method="GET">
        <label for="quantite">Quantité :</label>
        <input name="quantite" type="number" value="1" id="quantite">
        <input type="submit" value="Ajouter au panier">
        <input type="hidden" name="action" value="ajouterProduitAuPanier">
        <input type="hidden" name="idProduit" value="<?php echo htmlspecialchars($produit->getIdProduit()); ?>">
    </form>
</section>

<main>
    <?php
    use App\Magasin\Modeles\DataObject\Produit;
    /** @var Produit $produit */
    ?>
    <div class="fluid-container m-4">
        <form method="post" action="../web/controleurFrontal.php" enctype="multipart/form-data" class="form-horizontal">
            <fieldset>

                <!-- Form Name -->
                <legend>METTRE A JOUR PRODUIT</legend>
                <!-- Text input-->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="product_name">NOM PRODUIT</label>
                    <div class="col-md-4">
                        <input id="product_name" name="nomProduit" value="<?=htmlspecialchars($produit->getNomProduit())?>" class="form-control input-md" required type="text">
                    </div>
                </div>

                <!-- Textarea -->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="product_description">DESCRIPTION PRODUIT</label>
                    <div class="col-md-4">
                        <textarea class="form-control" id="product_description" name="descriptionProduit"><?=htmlspecialchars($produit->getDescriptionProduit())?></textarea>
                    </div>
                </div>

                <div class="form-group mt-2">
                    <label class="col-md-4 control-label" for="price">PRIX</label>
                    <div class="col-md-4">
                        <input class="form-control" id="price" name="prixProduit" type="number" step="0.01" value="<?=htmlspecialchars($produit->getPrixProduit())?>">
                    </div>
                </div>

                <!-- Text input-->
                <div class="form-group">
                    <!-- File Button -->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="filebutton">IMAGE PRODUIT</label>
                        <div class="col-md-4">
                            <input id="filebutton" name="images" class="input-file" type="file" accept=".jpg, .jpeg, .png">
                        </div>
                    </div>
                    <!-- Button -->
                    <div class="form-group d-flex">
                        <div class="col-md-2 mt-2">
                            <button id="singlebutton" type="submit" name="action" class="btn btn-primary" value="modifierProduit">Valider</button>
                            <input type="hidden" name="idProduit" value="<?=urlencode($_POST["idProduit"])?>"/>
                        </div>
                        <div class="col-md-2 mt-2">
                            <form action="../web/controleurFrontal.php" method="post">
                                <button type="submit" name="action" value="supprimerProduit" class="btn btn-danger ms-3">
                                    Supprimer
                                </button>
                                <input type="hidden" name="idProduit" value="<?=urlencode($_POST["idProduit"])?>"/>
                            </form>
                        </div>
                    </div>
                </div>
            </fieldset>
        </form>

    </div>
</main>
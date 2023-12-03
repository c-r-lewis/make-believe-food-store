<main>
    <form method="get" action="../web/controleurFrontal.php" enctype="multipart/form-data" class="form-horizontal">
        <fieldset>

            <!-- Form Name -->
            <legend>METTRE A JOUR PRODUIT</legend>
            <!-- Text input-->
            <div class="form-group">
                <label class="col-md-4 control-label" for="product_name">NOM PRODUIT</label>
                <div class="col-md-4">
                    <input id="product_name" name="nomProduit" placeholder="NOM PRODUIT" class="form-control input-md" required type="text">
                </div>
            </div>

            <!-- Textarea -->
            <div class="form-group">
                <label class="col-md-4 control-label" for="product_description">DESCRIPTION PRODUIT</label>
                <div class="col-md-4">
                    <textarea class="form-control" id="product_description" name="descriptionProduit"></textarea>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label" for="available_quantity">QUANTITE EN STOCK</label>
                <div class="col-md-4">
                    <input id="available_quantity" name="available_quantity" placeholder="QUANTITE EN STOCK" class="form-control input-md" required="" type="text">
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label" for="price">PRIX</label>
                <div class="col-md-4">
                    <input class="form-control" id="price" name="prixProduit" type="number" step="0.01">
                </div>
            </div>

            <!-- Text input-->
            <div class="form-group">
                <!-- File Button -->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="filebutton">Image produit</label>
                    <div class="col-md-4">
                        <input id="filebutton" name="images" class="input-file" type="file" accept=".jpg, .jpeg, .png">
                    </div>
                </div>
                <!-- Button -->
                <div class="form-group">
                    <div class="col-md-4">
                        <button id="singlebutton" type="submit" name="action" class="btn btn-primary" value="modifierProduit">Valider</button>
                        <input type="hidden" name="idProduit" value="<?php echo urlencode($_GET["idProduit"]); ?>"/>
                    </div>
                </div>
            </div>
        </fieldset>
    </form>

</main>
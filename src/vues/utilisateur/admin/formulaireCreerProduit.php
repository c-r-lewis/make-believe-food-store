<main>
    <div class="fluid-container m-4">
        <form method="post" action="../web/controleurFrontal.php" enctype="multipart/form-data" class="form-horizontal">
            <fieldset>
                <!-- Text input-->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="product_name">NOM PRODUIT</label>
                    <div class="col-md-4">
                        <input id="product_name" name="nomProduit" placeholder="NOM PRODUIT" class="form-control input-md" required type="text">
                    </div>
                </div>

                <!-- Textarea -->
                <div class="form-group mt-2">
                    <label class="col-md-4 control-label" for="product_description">DESCRIPTION PRODUIT</label>
                    <div class="col-md-4">
                        <textarea class="form-control" id="product_description" name="descriptionProduit"></textarea>
                    </div>
                </div>


                <div class="form-group mt-2">
                    <label class="col-md-4 control-label" for="price">PRIX</label>
                    <div class="col-md-4">
                        <input class="form-control" id="price" name="prixProduit" type="number" step="0.01">
                    </div>
                </div>

                <!-- Text input-->
                <div class="form-group mt-2">
                    <!-- File Button -->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="filebutton">IMAGE PRODUIT</label>
                        <div class="col-md-4">
                            <input id="filebutton" name="images" class="input-file" type="file" accept=".jpg, .jpeg, .png">
                        </div>
                    </div>
                    <!-- Button -->
                    <div class="form-group mt-2">
                        <div class="col-md-4">
                            <button id="singlebutton" type="submit" name="action" class="btn btn-primary" value="creerProduit">Valider</button>
                        </div>
                    </div>
                </div>
            </fieldset>
        </form>

    </div>
</main>
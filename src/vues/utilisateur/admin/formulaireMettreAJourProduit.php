<section>
    <div class="button-container">
        <form method="get" action="../web/controleurFrontal.php" enctype="multipart/form-data">
            <fieldset>
                <legend>Présentation générale</legend>
                <p>
                    <label>Titre</label>
                    <input type="text" name="nomProduit" required/>
                </p>
                <p>
                    <label>Description</label>
                    <input type="text" name="descriptionProduit" required/>
                </p>
            </fieldset>
            <fieldset>
                <legend>Prix</legend>
                <p>
                    <label>Prix par objet</label>
                    <input type="text" name="prixProduit" required/>
                </p>
            </fieldset>
            <fieldset>
                <label>Images</label>
                <input type="file" name="images" accept=".jpg, .jpeg, .png">
            </fieldset>

            <button type="submit" name="action" value="modifierProduit">
                <img src="../../../../ressources/images/logo-modifier.png" alt="Valider"/>
                <input type="hidden" name="idProduit" value="<?php echo urlencode($_GET["idProduit"]); ?>"/>
            </button>
        </form>
        <a href="controleurFrontal.php?action=supprimerProduit&idProduit=<?php echo urlencode($_GET["idProduit"]); ?>">
            <button><img src="../../../../ressources/images/logo-supprimer.png" alt="Supprimer"></button></a>
    </div>
</section>

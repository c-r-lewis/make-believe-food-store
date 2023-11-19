<section>
    <form enctype="multipart/form-data" action="../web/controleurFrontal.php">
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
            <input type="file" accept=".jpg, .jpeg, .png">
        </fieldset>
        <input type="submit" value="Valider"/>
        <input type="hidden" name="action" value="creerProduit"/>
        <button>Annuler</button>
    </form>
</section>
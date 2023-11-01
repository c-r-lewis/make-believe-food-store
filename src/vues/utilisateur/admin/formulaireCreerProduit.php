<section>
    <form enctype="multipart/form-data">
        <fieldset>
            <legend>Présentation générale</legend>
            <p>
                <label>Titre</label>
                <input type="text" name="nomProduit"/>
            </p>
            <p>
                <label>Description</label>
                <input type="text" name="descriptionProduit"/>
            </p>
        </fieldset>
        <fieldset>
            <legend>Prix</legend>
            <p>
                <label>Prix par objet</label>
                <input type="text" name="prixProduit"/>
            </p>
        </fieldset>
        <fieldset>
            <label>Images</label>
            <input type="file" accept=".jpg, .jpeg, .png">
        </fieldset>
        <button>Annuler</button>
    </form>
</section>
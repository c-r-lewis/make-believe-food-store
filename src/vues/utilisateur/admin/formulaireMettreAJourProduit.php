<section>
    <div>
        <form enctype="multipart/form-data">
            <fieldset>
                <legend>Présentation générale</legend>
                <p>
                    <label>Titre</label>
                    <input type="text" required/>
                </p>
                <p>
                    <label>Description</label>
                    <input type="text" required/>
                </p>
            </fieldset>
            <fieldset>
                <legend>Prix</legend>
                <p>
                    <label>Prix par objet</label>
                    <input type="text" required/>
                </p>
            </fieldset>
            <fieldset>
                <label>Images</label>
                <input type="file" accept=".jpg, .jpeg, .png">
            </fieldset>
        </form>
        <a href="controleurFrontal.php?action=supprimerProduit&idProduit=<?php echo urlencode($_GET["idProduit"]); ?>">
            <button><img src="../../../../ressources/images/logo-supprimer.png"></button>
        </a>

        <input type="submit" value="Enregistrer"/>
        <input type="hidden" name="action" value="creerProduit"/>
    </div>
</section>
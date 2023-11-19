<section>
    <div>
        <form action="controleurFrontal.php" method="POST" enctype="multipart/form-data">
            <fieldset>
                <legend>Présentation générale</legend>
                <p>
                    <label>Titre</label>
                    <input type="text" name="titre" required/>
                </p>
                <p>
                    <label>Description</label>
                    <input type="text" name="description" required/>
                </p>
            </fieldset>
            <fieldset>
                <legend>Prix</legend>
                <p>
                    <label>Prix par objet</label>
                    <input type="text" name="prix" required/>
                </p>
            </fieldset>
            <fieldset>
                <label>Images</label>
                <input type="file" name="images" accept=".jpg, .jpeg, .png">
            </fieldset>

            <a href="controleurFrontal.php?action=supprimerProduit&idProduit=<?php echo urlencode($_GET["idProduit"]); ?>">
                <button><img src="../../../../ressources/images/logo-supprimer.png" alt="Supprimer"></button>
            </a>

            <button type="submit">
                <img src="../../../../ressources/images/logo-modifier.png" alt="Enregistrer"/>
            </button>

            <input type="hidden" name="action" value="creerProduit"/>
            <input type="hidden" name="idProduit" value="<?php echo urlencode($_GET["idProduit"]); ?>"/>
        </form>
    </div>
</section>

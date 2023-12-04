<main>
    <div class="d-flex align-items-center">
        <div class="container">
            <div class="row d-flex justify-content-center align-items-center">
                <div class="col">
                    <div class="card my-2">
                        <div class="card-body p-4">
                            <?php
                            /** @var array $produits */
                            /** @var float $prixTotal */
                            ?>
                            <div class="row">
                                <div class="col-lg-7">
                                    <h6 class="mb-3">
                                        <form action="../web/controleurFrontal.php" method="post">
                                            <input type="hidden" name="action" value="afficherCatalogue">
                                            <button type="submit" class="btn btn-link text-body">
                                                Continuer vos achats
                                            </button>
                                        </form>
                                    </h6>
                                    <hr>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div>
                                    <p class="mb-1">Panier</p>
                                    <p class="mb-0">Vous avez <?= htmlspecialchars(sizeof($produits)) ?> objet(s)
                                        différent(s) dans votre panier</p>
                                </div>
                            </div>

                            <?php
                            foreach ($produits as $item):
                                ?>
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <div class="d-flex flex-row align-items-center">
                                                <div class="ms-3">
                                                    <h5><?= htmlspecialchars($item["produit"]->getNomProduit()) ?></h5>
                                                    <p class="small mb-0"
                                                       style="white-space: nowrap; overflow: hidden;text-overflow: ellipsis;"><?= htmlspecialchars($item["produit"]->getDescriptionProduit()) ?></p>
                                                </div>
                                            </div>
                                            <div class="d-flex flex-row align-items-center">
                                                <form action="../web/controleurFrontal.php" id="itemUpdate" class="d-flex flex-row align-items-center">
                                                    <div class="me-4" style="width: 50px;">
                                                        <input class="fw-normal" style="width: 60px" type="number" name="quantite" min="1" value="<?=htmlspecialchars($item["quantite"])?>" class="quantite" data-price="<?=htmlspecialchars($item["produit"]->getPrixProduit()) ?>" oninput="mettreAJourPrixTotal(this)" onchange="this.form.submit()">
                                                    </div>
                                                    <div style="width: 80px;">
                                                        <h5 class="mb-0" id="prixTotalItem"><?=htmlspecialchars($item["quantite"] * $item["produit"]->getPrixProduit())?>€</h5>
                                                    </div>
                                                    <div>
                                                        <a href="controleurFrontal.php?action=supprimerProduitDuPanier&idProduit='<?=htmlspecialchars($item["produit"]->getIdProduit())?>'">
                                                            <img src="../../../../ressources/images/logo-fermer.png" alt="Supprimer" style="width: 30px"/>
                                                        </a>
                                                    </div>
                                                    <input type="hidden" name="action" value="modifierQuantitePanier">
                                                    <input type="hidden" name="idProduit" value="<?=htmlspecialchars($item["produit"]->getIdProduit())?>'">
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>

                            <div class="col-lg-5">

                                <div class="card bg-primary text-white rounded-3">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center mb-4">
                                            <h5 class="mb-6">Détails d'achat</h5>
                                        </div>
                                        <form class="mt-4">
                                            <div class="form-outline form-white mb-4">
                                                <input type="text" id="nom"
                                                       class="form-control form-control-lg fs-6" placeholder="Nom"
                                                       required/>
                                                <label class="form-label" for="nom">Nom</label>
                                            </div>

                                            <div class="form-outline form-white mb-4">
                                                <input type="text" id="num"
                                                       class="form-control form-control-lg fs-6"
                                                       placeholder="1234 5678 9012 3457" minlength="19" maxlength="19"
                                                       required/>
                                                <label class="form-label" for="num">Numéro de carte</label>
                                            </div>

                                            <div class="row mb-4">
                                                <div class="col-md-6">
                                                    <div class="form-outline form-white">
                                                        <input type="text" id="expire"
                                                               class="form-control form-control-lg fs-6"
                                                               placeholder="MM/YYYY" size="7" id="exp" minlength="7"
                                                               maxlength="7" required/>
                                                        <label class="form-label" for="expire">Expiration</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-outline form-white">
                                                        <input type="password" id="cvv"
                                                               class="form-control form-control-lg fs-6"
                                                               placeholder="&#9679;&#9679;&#9679;" size="1"
                                                               minlength="3" maxlength="3" required/>
                                                        <label class="form-label" for="cvv">CVV</label>
                                                    </div>
                                                </div>
                                            </div>';

                                            if (!ConnexionUtilisateur::estConnecte()) {
                                                echo '<div class="row mb-4">
                                                    <div class="col-md-12">
                                                        <div class="form-outline form-white">
                                                            <input type="text" id="email"
                                                                class="form-control form-control-lg fs-6"
                                                                   placeholder="exemple@gmail.com" required/>
                                                                    <label class="form-label" for="email">Email</label>
                                                                        </div>
                                                                    </div>
                                                                </div>';
                                            }?>

                                            <hr class="my-4">

                                            <div class="d-flex justify-content-between mb-4">
                                                <p class="mb-2">Total</p>
                                                <p class="mb-2"><?= $prixTotal ?>€</p>
                                            </div>

                                            <button type="submit" class="btn btn-info btn-block btn-lg" name="action"
                                                    value="validerAchat">
                                                <span class="fs-6">Valider</span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

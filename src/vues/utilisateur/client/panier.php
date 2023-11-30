<main class="d-flex align-items-center">
    <div class="container">
        <div class="row d-flex justify-content-center align-items-center">
            <div class="col">
                <div class="card my-2">
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col-lg-7">
                                <h6 class="mb-3">
                                    <a href="#!" class="text-body">Continuer vos achats</a>
                                </h6>
                                <hr>
                                <?php
                                /** @var array $produits */
                                echo '<div class="d-flex justify-content-between align-items-center mb-4">
                                    <div>
                                        <p class="mb-1">Panier</p>
                                        <p class="mb-0">Vous avez <span>'.sizeof($produits).'</span> objet(s) dans votre panier</p>
                                    </div>
                                </div>';

                                foreach ($produits as $item) {
                                    echo '
                                        <div class="card mb-3">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between">
                                                <div class="d-flex flex-row align-items-center">
                                                    <div>
                                                        <img
                                                                src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-shopping-carts/img1.webp"
                                                                class="img-fluid rounded-3" alt="Shopping item" style="width: 65px;">
                                                    </div>
                                                    <div class="ms-3">
                                                        <h5>'.htmlspecialchars($item["produit"]->getNomProduit()).'</h5>
                                                        <p class="small mb-0" style="white-space: nowrap; overflow: hidden;text-overflow: ellipsis;">'.$item["produit"]->getDescriptionProduit().'</p>
                                                    </div>
                                                </div>
                                                <div class="d-flex flex-row align-items-center">
                                                    <form action="../web/controleurFrontal.php" class="d-flex flex-row align-items-center">
                                                        <div class="me-4" style="width: 50px;">
                                                            <input class="fw-normal" style="width: 60px" type="number" name="quantite" min="1" value="'.htmlspecialchars($item["quantite"]).'" class="quantite" data-price="'.htmlspecialchars($item["produit"]->getPrixProduit()).'" oninput="mettreAJourPrixTotal(this)" onchange="this.form.submit()">
                                                        </div>
                                                        <div style="width: 80px;">
                                                            <h5 class="mb-0" id="prixTotalItem"></h5>
                                                        </div>
                                                        <div>
                                                            <a href="controleurFrontal.php?action=supprimerProduitDuPanier&idProduit='.htmlspecialchars($item["produit"]->getIdProduit()).'">
                                                                <img src="../../../../ressources/images/logo-fermer.png" alt="Supprimer" style="width: 30px"/>
                                                            </a>
                                                        </div>
                                                        <input type="hidden" name="action" value="modifierQuantitePanier">
                                                        <input type="hidden" name="idProduit" value="'.htmlspecialchars($item["produit"]->getIdProduit()).'">
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>';
                                }
                                ?>
                            </div>
                            <div class="col-lg-5">

                                <div class="card bg-primary text-white rounded-3">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center mb-4">
                                            <h5 class="mb-6">Détails d'achat</h5>
                                        </div>
                                        <form class="mt-4">
                                            <div class="form-outline form-white mb-4">
                                                <input type="text" id="typeName" class="form-control form-control-lg fs-6" placeholder="Nom" />
                                                <label class="form-label" for="typeName">Nom</label>
                                            </div>

                                            <div class="form-outline form-white mb-4">
                                                <input type="text" id="typeText" class="form-control form-control-lg fs-6" placeholder="1234 5678 9012 3457" minlength="19" maxlength="19" />
                                                <label class="form-label" for="typeText">Card Number</label>
                                            </div>

                                            <div class="row mb-4">
                                                <div class="col-md-6">
                                                    <div class="form-outline form-white">
                                                        <input type="text" id="typeExp" class="form-control form-control-lg fs-6" placeholder="MM/YYYY" size="7" id="exp" minlength="7" maxlength="7" />
                                                        <label class="form-label" for="typeExp">Expiration</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-outline form-white">
                                                        <input type="password" id="typeText" class="form-control form-control-lg fs-6" placeholder="&#9679;&#9679;&#9679;" size="1" minlength="3" maxlength="3" />
                                                        <label class="form-label" for="typeText">Cvv</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>

                                        <hr class="my-4">

                                        <div class="d-flex justify-content-between mb-4">
                                            <p class="mb-2">Total</p>
                                            <p class="mb-2">$4818.00</p>
                                        </div>

                                        <button type="button" class="btn btn-info btn-block btn-lg">
                                            <div class="d-flex justify-content-between">
                                                <span class="fs-6">Valider</span>
                                            </div>
                                        </button>

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

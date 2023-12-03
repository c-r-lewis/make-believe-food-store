<?php

use App\Magasin\Lib\ConnexionUtilisateur as ConnexionUtilisateur;
use \App\Magasin\Modeles\DataObject\Utilisateur as Utilisateur;
use \App\Magasin\Modeles\Repository\UtilisateurRepository as UtilisateurRepository;

/** @var string $login */
?>

<main class="py-6 bg-surface-secondary">
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-xl-7 mx-auto">
                <form class="mb-6">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div>
                                <?php
                                $utilisateur = (new UtilisateurRepository)->recupererParClePrimaire([$login])[0];
                                ?>
                                <label class="form-label" for="name">Nom</label>
                                <input type="text" id="name" class="form-control" value="<?= htmlspecialchars($utilisateur->getNom(), ENT_QUOTES, 'UTF-8')?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="">
                                <label class="form-label" for="first_name">Prénom</label>
                                <input type="text" class="form-control" id="first_name" value="<?= htmlspecialchars($utilisateur->getPrenom(), ENT_QUOTES, 'UTF-8') ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row g-4">
                        <div class="col-md-12">
                            <div>
                                <label class="form-label" for="email">Email</label>
                                <input type="email" class="form-control" id="email" value="<?= htmlspecialchars($utilisateur->getEmail(), ENT_QUOTES, 'UTF-8')?>">

                            </div>
                        </div>
                        <div class="col-12">
                            <div >
                                <label class="form-label" for="mdp">Mot de passe actuel</label>
                                <input type="text" class="form-control" id="mdp">
                            </div>
                        </div>
                        <div class="col-6">
                            <label class="form-label" for="mdp2">Nouveau mot de passe</label>
                            <input type="text" class="form-control" id="mdp2">
                        </div>
                        <div class="col-6">
                            <label class="form-label" for="mdp3">Confirmation mot de passe</label>
                            <input type="text" class="form-control" id="mdp3">
                        </div>
                    </div>
                    <div class="text-end mt-2">
                        <button type="button" class="btn btn-sm btn-neutral me-2">Annuler</button>
                        <button type="submit" class="btn btn-sm btn-primary">Enregistrer</button>
                    </div>
                </form>
                <hr class="my-10"/>
                <?php
                if (!ConnexionUtilisateur::estAdmin()) {
                    echo '
                    <div class="col-md-12">
                    <div class="card shadow border-0">
                        <div class="card-body d-flex align-items-center">
                            <div>
                                <h5 class="text-danger mb-2">Supprimer son compte</h5>
                                <p class="text-sm text-muted">
                                    Attention, une fois que vous supprimez votre compte il n\'y a pas de retour en arrière possible
                                </p>
                            </div>
                            <div class="ms-auto">
                                <button type="button" class="btn btn-sm btn-danger">Supprimer</button>
                            </div>
                        </div>
                    </div>
                </div>';
                }
                ?>
            </div>
        </div>
    </div>
</main>
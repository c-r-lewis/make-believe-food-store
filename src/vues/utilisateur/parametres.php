<?php

use App\Magasin\Lib\ConnexionUtilisateur as ConnexionUtilisateur;
use \App\Magasin\Modeles\DataObject\Utilisateur as Utilisateur;
use \App\Magasin\Modeles\Repository\UtilisateurRepository as UtilisateurRepository;

/** @var string $login */
/** @var Utilisateur $utilisateur */
?>

<main class="py-6 bg-surface-secondary">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-7 mx-auto">
                <form class="mb-6">
                    <div class="row mb-5">
                        <div class="col-md-6">
                            <div>
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
                    <div class="row g-5">
                        <div class="col-md-12">
                            <div>
                                <?php
                                $utilisateur = (new UtilisateurRepository)->recupererParClePrimaire([$login])[0]
                                ?>
                                <label class="form-label" for="email">Email</label>
                                <input type="email" class="form-control" id="email" value="<?= htmlspecialchars($utilisateur->getEmail(), ENT_QUOTES, 'UTF-8') ?>">
                            </div>
                        </div>
                        <div class="col-4">
                            <div >
                                <label class="form-label" for="mdp">Mot de passe actuel</label>
                                <input type="text" class="form-control" id="mdp">
                            </div>
                        </div>
                        <div class="col-4">
                            <label class="form-label" for="mdp2">Confirmation mot de passe</label>
                            <input type="text" class="form-control" id="mdp2">
                        </div>
                        <div class="col-4">
                            <label class="form-label" for="mdp3">Confirmation mot de passe</label>
                            <input type="text" class="form-control" id="mdp3">
                        </div>
                    </div>
                    <div class="text-end mt-2">
                        <button type="button" class="btn btn-sm btn-neutral me-2">Cancel</button>
                        <button type="submit" class="btn btn-sm btn-primary">Save</button>
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
                                <h5 class="text-danger mb-2">Deactivate account</h5>
                                <p class="text-sm text-muted">
                                    Once you delete your account, there is no going back. Please be certain.
                                </p>
                            </div>
                            <div class="ms-auto">
                                <button type="button" class="btn btn-sm btn-danger">Deactivate</button>
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
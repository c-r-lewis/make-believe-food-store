<?php

namespace App\Magasin\Controleurs;

use App\Magasin\Lib\ConnexionUtilisateur;
use App\Magasin\Lib\MessageFlash;
use App\Magasin\Lib\MotDePasse;
use App\Magasin\Lib\VerificationEmail;
use App\Magasin\Modeles\DataObject\PanierConnecte;
use App\Magasin\Modeles\DataObject\Utilisateur;
use App\Magasin\Modeles\HTTP\Cookie;
use App\Magasin\Modeles\HTTP\Session;
use App\Magasin\Modeles\Repository\PanierRepository;
use App\Magasin\Modeles\Repository\ProduitPanierRepository;
use App\Magasin\Modeles\Repository\ProduitRepository;
use App\Magasin\Modeles\Repository\UtilisateurRepository;
use Exception;

class ControleurUtilisateurGenerique extends ControleurGenerique
{

    public static function afficherPanier(): void
    {
        try {
            $produits = [];
            $panier = [];
            $totalPrix = 0;
            if (ConnexionUtilisateur::estConnecte()) {
                $recupererPanier = ((new PanierRepository())->recupererParClePrimaire([ConnexionUtilisateur::getLoginUtilisateurConnecte()])[0])->formatTableau();
                foreach ((new ProduitRepository())->recuperer() as $produit) {
                    if ((new ProduitPanierRepository())->clePrimaireExiste([$recupererPanier["idPanierTag"], ($produit->formatTableau())["idProduitTag"]])) {
                        $verifProduit = (new ProduitPanierRepository())->recupererParClePrimaire([$recupererPanier["idPanierTag"], ($produit->formatTableau())["idProduitTag"]]);
                        $panier[] = $verifProduit;
                        $totalPrix += $produit->getPrixProduit()*$verifProduit[0]->getQuantite();
                    }
                }
                foreach ($panier as $produitsPanier) {
                    foreach ($produitsPanier as $produitPanier) {
                        $ajoutPanier = $produitPanier->formatTableau();
                        $produit = (new ProduitRepository())->recupererParClePrimaire([$ajoutPanier["idProduitTag"]])[0];
                        $produits[] = [
                            "produit" => $produit,
                            "quantite" => $ajoutPanier["quantiteTag"]
                        ];
                    }
                }
            } else {
                if (Cookie::contient("panier")) {
                    $panier = Cookie::lire("panier");
                }
                foreach ($panier as $idProduit => $quantite) {
                    $produit = (new ProduitRepository())->recupererParClePrimaire([$idProduit])[0];
                    $produits[] = ["produit" => $produit,
                        "quantite" => $quantite];
                    $totalPrix += $produit->getPrixProduit() * $quantite;
                }
            }
            self::afficherVue(
                "vueGenerale.php",
                [
                    "cheminVueBody" => "utilisateur/client/panier.php",
                    "produits" => $produits, "prixTotal" => $totalPrix,
                    "pagetitle" => "Votre panier"
                ]
            );
        } catch (Exception $e) {
            (new MessageFlash())->ajouter("danger", "Une erreur est survenue lors de l'affichage du panier");
            (new ControleurProduit())->afficherCatalogue();
        }
    }


    public static function afficherConnexion(): void
    {
        self::afficherVue("vueGenerale.php",
            [
                "cheminVueBody" => "utilisateur/connexion.php",
                "pagetitle" => "Connexion"
            ]
        );
    }

    public static function afficherParametres(): void
    {
        if (ConnexionUtilisateur::estConnecte()) {
            self::afficherVue(
                "vueGenerale.php",
                [
                    "cheminVueBody" => "utilisateur/parametres.php",
                    "utilisateur" => (new UtilisateurRepository())->recupererParClePrimaire([ConnexionUtilisateur::getLoginUtilisateurConnecte()])[0],
                    "pagetitle" => "Changer vos informations"
                ]
            );
        }

    }

    public static function afficherInscription(): void
    {
        self::afficherVue(
            "vueGenerale.php",
            [
                "cheminVueBody" => "utilisateur/inscription.php",
                "pagetitle" => "Inscription"
            ]
        );
    }

    public static function afficherComptes(): void
    {
        $comptes = (new UtilisateurRepository())->recuperer();
        $i = 0;
        while (!$comptes[$i]->estAdmin()) {
            $i++;
        }
        unset($comptes[$i]);

        self::afficherVue(
            "vueGenerale.php",
            [
                "cheminVueBody" => "utilisateur/admin/comptes.php",
                "comptes" => $comptes,
                "pagetitle" => "Utilisateurs Inscrits"
            ]
        );
    }

    public static function supprimerCompte(): void
    {
        try {
            $user = (new UtilisateurRepository())->recupererParClePrimaire([$_POST["email"]])[0];
            (new UtilisateurRepository())->supprimerParAbstractDataObject($user);
            if ($_POST["email"] == ConnexionUtilisateur::getLoginUtilisateurConnecte()) {
                ConnexionUtilisateur::deconnecter();
                (new MessageFlash())->ajouter("success", "Le compte a bien été supprimé !");
                ControleurProduit::afficherCatalogue();
            } else {
                (new MessageFlash())->ajouter("success", "Le compte a bien été supprimé !");
                self::afficherComptes();
            }
        } catch (Exception $e) {
            (new MessageFlash())->ajouter("danger", "Le compte n'a pas été supprimé !");
            (new ControleurProduit())->afficherCatalogue();
        }
    }


    public static function inscription(): void
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = filter_var($_POST["email"], FILTER_VALIDATE_EMAIL);


            if (!$email) {
                (new MessageFlash())->ajouter("warning", "Adresse email invalide !");
                self::afficherInscription();
                return;
            }


            if ((new UtilisateurRepository())->clePrimaireExiste([$email])) {
                (new MessageFlash())->ajouter("warning", "L'email est déjà utilisé !");
                self::afficherInscription();
                return;
            }

            if ($_POST["mdp"] != $_POST["mdp2"]) {
                (new MessageFlash())->ajouter("warning", "Les mots de passe ne sont pas identiques !");
                self::afficherInscription();
                return;
            }

            $utilisateur = Utilisateur::construireDepuisFormulaire($_POST);
            $utilisateur->setEmailAValider($email);
            $utilisateur->setNonce(MotDePasse::genererChaineAleatoire());

            (new UtilisateurRepository())->sauvegarder($utilisateur);

            VerificationEmail::envoiEmailValidation($utilisateur);

            (new MessageFlash())->ajouter("success", "Votre compte a bien été créé ! Un email de validation a été envoyé !");

            $panierConnecte = new PanierConnecte(hexdec(uniqid()), $utilisateur->getEmail());
            $panierRepository = new PanierRepository();
            $panierRepository->sauvegarder($panierConnecte);

            self::connexion();
        }
    }

    public static function validerEmail()
    {
        (new VerificationEmail())->validerEmail();
    }


    public static function connexion(): void
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (
                (new UtilisateurRepository())->clePrimaireExiste([$_POST["email"]])
            ) {
                ConnexionUtilisateur::connecter($_POST["email"], $_POST["mdp"]);
                ControleurProduit::afficherCatalogue();
            } else {
                (new MessageFlash())->ajouter("warning", "Email ou mot de passe incorrect !");
                self::afficherConnexion();
            }
        }
    }

    public static function miseAJourParametres(): void
    {
        // TODO: refactorer
        $mdpActuel = $_POST["mdpActuel"];
        $login = ConnexionUtilisateur::getLoginUtilisateurConnecte();
        $repo = new UtilisateurRepository();
        /** @var Utilisateur $utilisateur */
        $utilisateur = $repo->recupererParClePrimaire([$login])[0];
        if (!MotDePasse::verifier($mdpActuel, $utilisateur->getMdpHache())) {
            (new MessageFlash())->ajouter("warning", "Mot de passe incorrect");
            self::afficherParametres();
            return;
        };
        if ($_POST["mdpNouveau"] != "" && $_POST["mdpNouveau"] == $_POST["mdpNouveau2"]) {
            $nouveauMdp = MotDePasse::hacher($_POST["mdpNouveau"]);
            $utilisateur->setMdpHache($nouveauMdp);
        }
        if (isset($_POST["prenom"]) && $_POST["prenom"] != "") {
            $utilisateur->setPrenom($_POST["prenom"]);
        }
        if (isset($_POST["prenom"]) && $_POST["prenom"] != "") {
            $utilisateur->setPrenom($_POST["prenom"]);
        }

        $email = $utilisateur->getEmail();
        $nouveauEmail = $email;
        if (isset($_POST["email"]) && $_POST["email"] != "" && $_POST["email"] != $email) {
            $nouveauEmail = filter_var($_POST["email"], FILTER_VALIDATE_EMAIL);

            if (!$nouveauEmail) {
                (new MessageFlash())->ajouter("warning", "Adresse email invalide !");
                ControleurUtilisateurGenerique::afficherParametres();
                return;

            }

            if ((new UtilisateurRepository())->clePrimaireExiste([$nouveauEmail])) {
                (new MessageFlash())->ajouter("warning", "L'email est déjà utilisé !");
                ControleurUtilisateurGenerique::afficherParametres();
                return;
            }

            $utilisateur->setEmailAValider($nouveauEmail);
            $nouveauEmail = $_POST["email"];
            $utilisateur->setNonce(MotDePasse::genererChaineAleatoire());
            ConnexionUtilisateur::setLoginUtilisateurConnecte($nouveauEmail);

            VerificationEmail::envoiEmailValidation($utilisateur);
        }
        $repo->mettreAJour($utilisateur);
        if ($nouveauEmail != $email) $repo->mettreAJourClePrimaire(["email" => $email], ["email" => $_POST["email"]]);
        (new MessageFlash())->ajouter("success", "Vos modifications ont été enregistrées ! Un email de validation a été envoyé !");
        (new ControleurProduit())->afficherCatalogue();
    }


    public static function deconnexion(): void
    {
        ConnexionUtilisateur::deconnecter();
        ControleurProduit::afficherCatalogue();
    }
}
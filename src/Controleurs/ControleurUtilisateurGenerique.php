<?php

namespace App\Magasin\Controleurs;

use App\Magasin\Lib\ConnexionUtilisateur;
use App\Magasin\Lib\MessageFlash;
use App\Magasin\Lib\MotDePasse;
use App\Magasin\Lib\VerificationEmail;
use App\Magasin\Modeles\DataObject\PanierConnecte;
use App\Magasin\Modeles\DataObject\Utilisateur;
use App\Magasin\Modeles\HTTP\Cookie;
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
                        $panier[] = (new ProduitPanierRepository())->recupererParClePrimaire([$recupererPanier["idPanierTag"], ($produit->formatTableau())["idProduitTag"]]);
                        $totalPrix += $produit->getPrix();
                    }
                }
                foreach ($panier as $produitsPanier) {
                    foreach ($produitsPanier as $produitPanier) {
                        $ajoutPanier = $produitPanier->formatTableau();
                        $produit = (new ProduitRepository())->recupererParClePrimaire([$ajoutPanier["idProduitTag"]])[0];
                        $totalPrix += $produit->getPrixProduit();
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
                    $totalPrix += $produit->getPrixProduit()*$quantite;
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
            self::erreur("Une erreur est survenue lors de l'affichage du panier : " . $e->getMessage());
        }
    }


    public static function afficherConnexion(): void
    {
        self::afficherVue("vueGenerale.php", ["cheminVueBody" => "utilisateur/connexion.php"]);
    }

    public static function afficherParametres(): void
    {
        if (ConnexionUtilisateur::estConnecte()) {
            self::afficherVue(
                "vueGenerale.php",
                [
                    "cheminVueBody" => "utilisateur/parametres.php",
                    "utilisateur" => (new UtilisateurRepository())->recupererParClePrimaire([ConnexionUtilisateur::getLoginUtilisateurConnecte()])[0],
                    "pagetitle"=>"Changer vos informations"
                ]
            );
        }

    }

    public static function afficherInscription(): void
    {
        self::afficherVue("vueGenerale.php", ["cheminVueBody" => "utilisateur/inscription.php"]);
    }

    public static function afficherComptes(): void
    {
        $comptes = (new UtilisateurRepository())->recuperer();
        $i = 0;
        while (!$comptes[$i]->estAdmin()) {
            $i++;
        }
        unset($comptes[$i]);

        self::afficherVue("vueGenerale.php", ["cheminVueBody" => "utilisateur/admin/comptes.php", "comptes" => $comptes]);
    }

    public static function supprimerCompte(): void
    {
        try {
            $user = (new UtilisateurRepository())->recupererParClePrimaire([$_GET["email"]])[0];
            (new UtilisateurRepository())->supprimerParAbstractDataObject($user);
            (new MessageFlash())->ajouter("success", "Le compte a bien été supprimé !");
            self::afficherComptes();
        } catch (Exception $e) {
            (new MessageFlash())->ajouter("danger", "Le compte n'a pas été supprimé !");
            self::erreur("Vous ne pouvez pas supprimer un compte qui n'existe pas");
        }
    }


    public static function inscription(): void
    {
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            $email = filter_var($_GET["email"], FILTER_VALIDATE_EMAIL);


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

            if ($_GET["mdp"] != $_GET["mdp2"]) {
                (new MessageFlash())->ajouter("warning", "Les mots de passe ne sont pas identiques !");
                self::afficherInscription();
                return;
            }

            $utilisateur = Utilisateur::construireDepuisFormulaire($_GET);
            $utilisateur->setEmailAValider($email);
            $utilisateur->setNonce(MotDePasse::genererChaineAleatoire());

            (new UtilisateurRepository())->sauvegarder($utilisateur);

            VerificationEmail::envoiEmailValidation($utilisateur);

            (new MessageFlash())->ajouter("success", "Votre compte a bien été créé ! Un email de validation a été envoyé !");

            $panierConnecte = new PanierConnecte(count((new PanierRepository())->recuperer()), $utilisateur->getEmail());
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
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            if (
                (new UtilisateurRepository())->clePrimaireExiste([$_GET["email"]])
            ) {
                ConnexionUtilisateur::connecter($_GET["email"], $_GET["mdp"]);
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
        $mdpActuel = $_GET["mdpActuel"];
        $login = ConnexionUtilisateur::getLoginUtilisateurConnecte();
        $repo = new UtilisateurRepository();
        /** @var Utilisateur $utilisateur */
        $utilisateur = $repo->recupererParClePrimaire([$login])[0];
        if (!MotDePasse::verifier($mdpActuel, $utilisateur->getMdpHache())) {
            echo "mauvais mot de passe";
            return;
        };
        if ($_GET["mdpNouveau"] != "" && $_GET["mdpNouveau"] == $_GET["mdpNouveau2"]) {
            $nouveauMdp = MotDePasse::hacher($_GET["mdpNouveau"]);
            $utilisateur->setMdpHache($nouveauMdp);
        }
        if (isset($_GET["prenom"]) && $_GET["prenom"] != "") {
            $utilisateur->setPrenom($_GET["prenom"]);
        }
        if (isset($_GET["prenom"]) && $_GET["prenom"] != "") {
            $utilisateur->setPrenom($_GET["prenom"]);
        }

        $email = $utilisateur->getEmail();
        $nouveauEmail = $email;
        if (isset($_GET["email"]) && $_GET["email"] != "" && $_GET["email"] != $email) {
            $nouveauEmail = filter_var($_GET["email"], FILTER_VALIDATE_EMAIL);

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
            $nouveauEmail = $_GET["email"];
            $utilisateur->setNonce(MotDePasse::genererChaineAleatoire());
            ConnexionUtilisateur::setLoginUtilisateurConnecte($nouveauEmail);

            VerificationEmail::envoiEmailValidation($utilisateur);
        }
        $repo->mettreAJour($utilisateur);
        if ($nouveauEmail != $email) $repo->mettreAJourClePrimaire(["email" => $email], ["email" => $_GET["email"]]);
        (new MessageFlash())->ajouter("success", "Vos modifications ont été enregistrées ! Un email de validation a été envoyé !");
        (new ControleurProduit())->afficherCatalogue();
    }


    public static function deconnexion(): void
    {
        ConnexionUtilisateur::deconnecter();
        ControleurProduit::afficherCatalogue();
    }
}
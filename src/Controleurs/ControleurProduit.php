<?php

namespace App\Magasin\Controleurs;

use App\Magasin\Lib\ConnexionUtilisateur;
use App\Magasin\Lib\MessageFlash;
use App\Magasin\Lib\VerificationEmail;
use App\Magasin\Modeles\DataObject\Achat;
use App\Magasin\Modeles\DataObject\Image;
use App\Magasin\Modeles\DataObject\Produit;
use App\Magasin\Modeles\DataObject\ProduitAchat;
use App\Magasin\Modeles\HTTP\Cookie;
use App\Magasin\Modeles\Repository\AchatRepository;
use App\Magasin\Modeles\Repository\ImageRepository;
use App\Magasin\Modeles\Repository\PanierRepository;
use App\Magasin\Modeles\Repository\ProduitAchatRepository;
use App\Magasin\Modeles\Repository\ProduitPanierRepository;
use App\Magasin\Modeles\Repository\ProduitRepository as ProduitRepository;
use App\Magasin\Modeles\DataObject\Panier as Panier;
use App\Magasin\Modeles\Repository\UtilisateurRepository;
use Exception;

class ControleurProduit extends ControleurGenerique
{
    public static function afficherCatalogue(): void
    {
        $produits = (new ProduitRepository())->recuperer();
        self::afficherVue("vueGenerale.php", ["pagetitle" => "Affichage catalogue", "cheminVueBody" => "produit/catalogue.php",
            "produits" => $produits]);
    }

    public static function afficherCreationProduit(): void
    {
        self::afficherVue("vueGenerale.php", ["pagetitle" => "Création produit", "cheminVueBody" => "utilisateur/admin/formulaireCreerProduit.php"]);
    }

    public static function afficherModificationProduit(Produit $produit): void
    {
        self::afficherVue("vueGenerale.php", ["pagetitle" => "Modifier produit", "cheminVueBody" => "utilisateur/admin/formulaireMettreAJourProduit.php", "produit"=>$produit]);
    }

    public static function creerProduit(): void
    {
        try {
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $nomProduit = $_POST["nomProduit"];
                $descriptionProduit = $_POST["descriptionProduit"];
                $prixProduit = $_POST["prixProduit"];

                if (empty($nomProduit) || empty($descriptionProduit) || empty($prixProduit)) {
                    (new MessageFlash())->ajouter("warning", "Veuillez remplir tous les champs");
                    self::afficherCreationProduit();
                    return;
                }

                if (!filter_var($prixProduit, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^-?\d+(\.\d{2})?$/")))) {
                    (new MessageFlash())->ajouter("warning", "Le prix doit être un nombre décimal avec deux chiffres après la virgule ou un nombre entier");
                    self::afficherCreationProduit();
                    return;
                }

                if ($prixProduit < 0) {
                    (new MessageFlash())->ajouter("warning", "Le prix doit être un nombre positif");
                    self::afficherCreationProduit();
                    return;
                }

                if (strlen($nomProduit) > 100) {
                    (new MessageFlash())->ajouter("warning", "Le nom que vous essayez de donner est trop long");
                    self::afficherCreationProduit();
                    return;
                }

                if (strlen($descriptionProduit) > 500) {
                    (new MessageFlash())->ajouter("warning", "La description est limitée à 500 caractères");
                    self::afficherCreationProduit();
                    return;
                }

                $produit = new Produit(hexdec(uniqid()), $nomProduit, $descriptionProduit, $prixProduit);

                (new ProduitRepository())->sauvegarder($produit);

                $idProduit = $produit->getIdProduit();

                if (isset($_FILES['images']) && $_FILES['images']['error'] === UPLOAD_ERR_OK) {
                    $imagePath = self::deplacerImageProduit($_FILES['images'], $idProduit);
                    $image = new Image($idProduit, $imagePath);
                    (new ImageRepository())->sauvegarder($image);
                }

                (new MessageFlash())->ajouter("success", "Le produits a bien été crée !");
                self::afficherCatalogue();
            }
        } catch (Exception $e) {
            (new MessageFlash())->ajouter("danger", "Erreur lors de la création du produit !");
            (new ControleurProduit())->afficherCatalogue();
        }
    }

    /**
     * Télécharge un fichier image et renvoie le chemin.
     *
     * @param array $file Les données du fichier téléchargé.
     * @return string|null Le chemin de l'image téléchargée, ou null en cas d'échec du téléchargement.
     */
    private static function deplacerImageProduit(array $file, int $idProduit): ?string
    {
        $dossierUpload = '../ressources/images/imagesProduits/';
        $nomFichierUpload = $dossierUpload . $idProduit . ".";

        $typeFichierImage = $file["type"];
        switch ($typeFichierImage) {
            case 'image/jpg':
            case 'image/jpeg':
                $nomFichierUpload .= 'jpg';
                break;
            case 'image/png':
                $nomFichierUpload .= "png";
                break;
            default:
                (new MessageFlash())->ajouter("danger", "Mauvais format d'image");
                return null;
        }

        if (!getimagesize($file['tmp_name'])) {
            (new MessageFlash())->ajouter("warning", "Le fichier n'est pas une image valide.");
            return null;
        }

        if (move_uploaded_file($file['tmp_name'], $nomFichierUpload)) {
            return $nomFichierUpload;
        } else {
            (new MessageFlash())->ajouter("danger", "Erreur lors du téléchargement du fichier.");
            return null;
        }
    }


    public static function afficherDetailProduit(): void
    {
        try {
            if (empty($_POST["idProduit"])) {
                (new MessageFlash())->ajouter("danger", "L'identifiant du produit est manquant.");
                (new ControleurProduit())->afficherCatalogue();
            }

            $idProduit = $_POST["idProduit"];
            if (!(new ProduitRepository())->clePrimaireExiste([$idProduit])) {
                (new MessageFlash())->ajouter("danger", "Ce produit n'existe pas.");
                (new ControleurProduit())->afficherCatalogue();
            }

            $produit = (new ProduitRepository())->recupererParClePrimaire([$idProduit])[0];

            if (ConnexionUtilisateur::estConnecte() && ConnexionUtilisateur::estAdmin()) {
                self::afficherModificationProduit($produit);
            }
            else {
                self::afficherVue("vueGenerale.php", ["pagetitle" => "Détail produit", "cheminVueBody" => "produit/detail.php", "produit" => $produit]);
            }
        } catch (\Exception $e) {
            (new MessageFlash())->ajouter("danger", "Erreur lors de l'affichage des détails d'un produit");
            (new ControleurProduit())->afficherCatalogue();
        }
    }

    public static function ajouterProduitAuPanier(): void
    {
        if (!(new ProduitRepository())->clePrimaireExiste([$_POST["idProduit"]])) {
            (new MessageFlash())->ajouter("danger", "Ajoutez un produit qui existe dans votre panier");
            (new ControleurProduit())->afficherCatalogue();
        } else if (!filter_var($_POST["quantite"], FILTER_VALIDATE_INT)) {
            (new MessageFlash())->ajouter("warning", "La quantité doit être un entier");
            (new ControleurProduit())->afficherCatalogue();
        } else if ($_POST["quantite"] <= 0) {
            (new MessageFlash())->ajouter("warning", "La quantité doit être un entier positif");
            (new ControleurProduit())->afficherCatalogue();
        } else {
            if (!ConnexionUtilisateur::estConnecte()) {
                (new Panier())->enregistrerDansPanierEnTantQueCookie($_POST["idProduit"], $_POST["quantite"]);
            } else {
                $recupererPanier = ((new PanierRepository())->recupererParClePrimaire([ConnexionUtilisateur::getLoginUtilisateurConnecte()])[0])->formatTableau();
                if (!(new ProduitPanierRepository())->clePrimaireExiste([$recupererPanier["idPanierTag"], $_POST["idProduit"]])) {
                    (new MessageFlash())->ajouter("success", "Le produit a été ajouté au panier !");
                }
                Panier::ajouterItem($_POST["idProduit"], $_POST["quantite"]);
                self::afficherCatalogue();
            }
        }
    }

    public
    static function supprimerProduitDuPanier(): void
    {
        if (!(new ProduitRepository())->clePrimaireExiste([$_POST["idProduit"]])) {
            (new MessageFlash())->ajouter("danger", "Vous ne pouvez pas supprimer un produit qui n'existe pas");
            (new ControleurProduit())->afficherCatalogue();
        } else {
            Panier::supprimerItem((int)$_POST["idProduit"]);
            (new MessageFlash())->ajouter("success","Le produit a bien été supprimé du panier !");
            echo '<meta http-equiv="refresh" content="0;url=controleurFrontal.php?action=afficherPanier&controleur=utilisateurGenerique">';
        }
    }

    public
    static function modifierQuantitePanier(): void
    {
        if (!(new ProduitRepository())->clePrimaireExiste([$_POST["idProduit"]])) {
            (new MessageFlash())->ajouter("warning", "Modifiez la quantité d'un produit qui est dans votre panier");
            (new ControleurProduit())->afficherCatalogue();
        } else if (!filter_var($_POST["quantite"], FILTER_VALIDATE_INT)) {
            (new MessageFlash())->ajouter("warning", "La quantité doit être un entier");
            (new ControleurProduit())->afficherCatalogue();
        } else if ($_POST["quantite"] <= 0) {
            (new MessageFlash())->ajouter("warning", "La quantité doit être un entier positif");
            (new ControleurProduit())->afficherCatalogue();
            return;
        } else {
            Panier::modifierQuantite($_POST["idProduit"], $_POST["quantite"]);
            echo '<meta http-equiv="refresh" content="0;url=controleurFrontal.php?action=afficherPanier&controleur=utilisateurGenerique">';
        }
    }

    public static function supprimerProduit(): void
    {
        if (isset($_POST['idProduit'])) {
            $idProduit = $_POST['idProduit'];

            $produitRepository = new ProduitRepository();
            $produit = $produitRepository->recupererParClePrimaire([$idProduit]);

            if (!empty($produit)) {
                $produitRepository->supprimerParAbstractDataObject($produit[0]);
                (new MessageFlash())->ajouter("success", "Le produit a été supprimé avec succès.");
            } else {
                (new MessageFlash())->ajouter("warning", "Le produit avec l'ID $idProduit n'existe pas.");
            }
        } else {
            (new MessageFlash())->ajouter("danger", "L'ID du produit n'est pas défini.");
        }

        self::afficherCatalogue();
    }


    public static function modifierProduit(): void
    {
        try {
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $idProduit = $_POST["idProduit"];
                $nomProduit = $_POST["nomProduit"];
                $descriptionProduit = $_POST["descriptionProduit"];
                $prixProduit = $_POST["prixProduit"];

                if (isset($_FILES['images']) && $_FILES['images']['error'] === UPLOAD_ERR_OK) {
                    $imagePath = self::deplacerImageProduit($_FILES['images']);
                } else {
                    $imagePath = null;
                }

                if (!filter_var($prixProduit, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^-?\d+(\.\d{2})?$/")))) {
                    (new MessageFlash())->ajouter("warning", "Le prix doit être un nombre décimal avec deux chiffres après la virgule ou un nombre entier");
                    self::afficherCreationProduit();
                    return;
                }

                if ($prixProduit < 0) {
                    (new MessageFlash())->ajouter("warning", "Le prix doit être un nombre positif");
                    self::afficherCreationProduit();
                    return;
                }


                $produitRepository = new ProduitRepository();
                $produit = $produitRepository->recupererParClePrimaire([$idProduit])[0];

                if (empty($produit)) {
                    (new MessageFlash())->ajouter("danger", "Le produit n'a pas été trouvé.");
                    self::afficherCatalogue();
                    return;
                }

                $produit->setNomProduit($nomProduit);
                $produit->setDescriptionProduit($descriptionProduit);
                $produit->setPrixProduit($prixProduit);

                $produitRepository->mettreAJour($produit);

                if ($imagePath !== null) {
                    $imageRepository = new ImageRepository();
                    $image = new Image($idProduit, $imagePath);
                    $imageRepository->mettreAJour($image);
                }

                (new MessageFlash())->ajouter("success", "Les modifications ont été enregistrées");
                self::afficherCatalogue();
            } else {
                (new MessageFlash())->ajouter("warning", "Veuillez spécifier tous les paramètres nécessaires pour la modification.");
                self::afficherCatalogue();
            }
        } catch (Exception $e) {
            (new MessageFlash())->ajouter("danger", "Erreur lors de la modification d'un produit");
            (new ControleurProduit())->afficherCatalogue();
        }
    }

    public static function afficherHistorique(): void
    {
        $recupererAchat = (new AchatRepository())->recuperer();

        $achats = [];
        if (!empty($recupererAchat)) {
            foreach ($recupererAchat as $achat) {
                if ($achat->getEmail() == ConnexionUtilisateur::getLoginUtilisateurConnecte()) {
                    $achats[] = $achat;
                }
            }
        }

        self::afficherVue("vueGenerale.php", ["pagetitle" => "Historique", "cheminVueBody" => "utilisateur/client/historique.php", "achats" => $achats]);
    }

    public static function afficherDetailAchat(): void {
        $idAchat = $_POST["idAchat"];
        $toutProduitAchat = (new ProduitAchatRepository())->recuperer();

        $produitAchat = [];
        $prixTotalAchats = 0;

        foreach ($toutProduitAchat as $produit) {
            if ($produit->getIdAchat()==$idAchat) {
                $produitAchat[] = $produit;
                $prixTotalAchats += $produit ->getPrixProduitUnitaire()*$produit->getQuantite();
            }
        }

        self::afficherVue("vueGenerale.php", ["pagetitle" => "Détail achat",
            "cheminVueBody" => "utilisateur/client/detailAchat.php",
            "produits" => $produitAchat,
            "prixTotalAchats" => $prixTotalAchats]);
    }

    public static function validerAchat(): void {
        try {
            $produitMail = [];
            if (ConnexionUtilisateur::estConnecte()) {
                $utilisateur = (new UtilisateurRepository())->recupererParClePrimaire([ConnexionUtilisateur::getLoginUtilisateurConnecte()])[0];
                if ($utilisateur->getEmailAValider() != null) {
                    (new MessageFlash())->ajouter("warning","Veuillez valider votre email !");
                    ControleurUtilisateurGenerique::afficherPanier();
                    return;
                }
                $recupererPanier = ((new PanierRepository())->recupererParClePrimaire([ConnexionUtilisateur::getLoginUtilisateurConnecte()])[0])->formatTableau();
                $panier = [];

                foreach ((new ProduitRepository())->recuperer() as $produit) {
                    if ((new ProduitPanierRepository())->clePrimaireExiste([$recupererPanier["idPanierTag"], ($produit->formatTableau())["idProduitTag"]])) {
                        $verifProduit = (new ProduitPanierRepository())->recupererParClePrimaire([$recupererPanier["idPanierTag"], ($produit->formatTableau())["idProduitTag"]]);
                        $panier[] = $verifProduit;
                    }
                }

                if (empty($panier)) {
                    (new MessageFlash())->ajouter("warning", "Votre panier est vide");
                    ControleurUtilisateurGenerique::afficherPanier();
                    return;
                }

                $achat = new Achat(hexdec(uniqid()),date('Y-m-d'),ConnexionUtilisateur::getLoginUtilisateurConnecte());

                (new AchatRepository())->sauvegarder($achat);

                $idAchat = $achat->getIdAchat();

                foreach ($panier as $produitsPanier) {
                    foreach ($produitsPanier as $produitPanier) {
                        $produit = (new ProduitRepository())->recupererParClePrimaire([$produitPanier->getIdProduit()])[0];
                        $produitAchat = new ProduitAchat($produitPanier->getIdProduit(), $idAchat, $produit->getNomProduit(), $produitPanier->getQuantite(), $produit->getPrixProduit());

                        (new ProduitAchatRepository())->sauvegarder($produitAchat);
                        (new ProduitPanierRepository())->supprimerParAbstractDataObject($produitPanier);
                        $produitMail[] = $produitAchat;
                    }
                }
            } else {
                $email = filter_var($_POST["email"], FILTER_VALIDATE_EMAIL);


                if (!$email) {
                    (new MessageFlash())->ajouter("warning", "Adresse email invalide !");
                    ControleurUtilisateurGenerique::afficherPanier();
                    return;
                }

                if (Cookie::contient("panier")) {
                    $panier = Cookie::lire("panier");
                    $idAchat = hexdec(uniqid());
                    if ($panier == null) {
                        (new MessageFlash())->ajouter("warning", "Votre panier est vide");
                        ControleurUtilisateurGenerique::afficherPanier();
                        return;
                    }
                    foreach ($panier as $idProduit => $quantite) {
                        $produitInfo = (new ProduitRepository())->recupererParClePrimaire([$idProduit])[0];
                        $produitAchat = new ProduitAchat($produitInfo->getidProduit(), $idAchat, $idProduit,$quantite, $produitInfo->getPrixProduit());
                        $produitMail[] = $produitAchat;
                    }
                    Cookie::supprimer("panier");
                } else {
                    (new MessageFlash())->ajouter("warning", "Votre panier est vide");
                    ControleurUtilisateurGenerique::afficherPanier();
                    return;
                }
            }
            try {
                VerificationEmail::envoiAchatConnecte($produitMail);
                (new MessageFlash())->ajouter("success", "Votre achat a été validé. Un email vous a été envoyé !");
                self::afficherCatalogue();
            } catch (Exception $e) {
                (new MessageFlash())->ajouter("warning", "Votre achat a été validé mais l'email n'a pas pu être envoyé !");
                self::afficherCatalogue();
            }
        } catch (Exception $e) {
            echo $e;
            (new MessageFlash())->ajouter("danger", "Une erreur est survenue lors de la validation du panier");
            (new ControleurProduit())->afficherCatalogue();
        }
    }
}
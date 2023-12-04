<?php

namespace App\Magasin\Controleurs;

use App\Magasin\Lib\ConnexionUtilisateur;
use App\Magasin\Lib\MessageFlash;
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

    public static function afficherModificationProduit(): void
    {
        self::afficherVue("vueGenerale.php", ["pagetitle" => "Modifier produit", "cheminVueBody" => "utilisateur/admin/formulaireMettreAJourProduit.php"]);
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

                if (!filter_var($prixProduit, FILTER_VALIDATE_INT)) {
                    (new MessageFlash())->ajouter("warning", "Le prix doit être un nombre");
                    self::afficherCreationProduit();
                    return;
                }

                $produit = new Produit(hexdec(uniqid()), $nomProduit, $descriptionProduit, $prixProduit);

                (new ProduitRepository())->sauvegarder($produit);

                $idProduit = (new ProduitRepository())->getDerniereIdIncrementee();

                if (isset($_FILES['images']) && $_FILES['images']['error'] === UPLOAD_ERR_OK) {
                    $imagePath = self::deplacerImageProduit($_FILES['images'], $idProduit);
                    $image = new Image($idProduit, $imagePath);
                    (new ImageRepository())->sauvegarder(new Image($image));
                }


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
            self::afficherVue("vueGenerale.php", ["pagetitle" => "Détail produit", "cheminVueBody" => "produit/detail.php", "produit" => $produit]);
        } catch (\Exception $e) {
            (new MessageFlash())->ajouter("danger", "Erreur lors de l'affichage des détails d'un produit");
            (new ControleurProduit())->afficherCatalogue();
        }
    }

    public
    static function ajouterProduitAuPanier(): void
    {
        if (!(new ProduitRepository())->clePrimaireExiste([$_POST["idProduit"]])) {
            (new MessageFlash())->ajouter("danger", "Ajoutez un produit qui existe dans votre panier");
            (new ControleurProduit())->afficherCatalogue();
        } else if (!filter_var($_POST["idProduit"], FILTER_VALIDATE_INT)) {
            (new MessageFlash())->ajouter("warning", "La quantité doit être un entier");
            (new ControleurProduit())->afficherCatalogue();
        } else {
            $recupererPanier = ((new PanierRepository())->recupererParClePrimaire([ConnexionUtilisateur::getLoginUtilisateurConnecte()])[0])->formatTableau();
            if (!(new ProduitPanierRepository())->clePrimaireExiste([$recupererPanier["idPanierTag"], $_POST["idProduit"]])) {
                (new MessageFlash())->ajouter("success", "Le produit a été ajouté au panier !");
            }
            Panier::ajouterItem($_POST["idProduit"], $_POST["quantite"]);
            self::afficherCatalogue();
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
        } else if (!filter_var($_POST["idProduit"], FILTER_VALIDATE_INT)) {
            (new MessageFlash())->ajouter("warning", "La quantité doit être un entier");
            (new ControleurProduit())->afficherCatalogue();
        } else {
            Panier::modifierQuantite($_POST["idProduit"], $_POST["quantite"]);
            echo '<meta http-equiv="refresh" content="0;url=controleurFrontal.php?action=afficherPanier&controleur=utilisateurGenerique">';
        }
    }

    public
    static function supprimerProduit(): void
    {
        if (isset($_POST['idProduit'])) {
            $idProduit = $_POST['idProduit'];

            $produit = (new ProduitRepository())->recupererParClePrimaire([$idProduit])[0];

            $produitRepository = new ProduitRepository();
            $produitRepository->supprimerParAbstractDataObject($produit);

        } else {
            (new ControleurGenerique)::erreur("L'ID du produit n'est pas défini.");
        }
        self::afficherCatalogue();
    }

    public
    static function modifierProduit(): void
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

                if (!filter_var($prixProduit, FILTER_VALIDATE_INT)) {
                    (new MessageFlash())->ajouter("warning", "Le prix doit être un nombre");
                    self::afficherModificationProduit();
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
        $ToutProduitAchat = (new ProduitAchatRepository())->recuperer();

        $produitAchat = [];
        foreach ($ToutProduitAchat as $produit) {
            if ($produit->getIdAchat()==$idAchat) {
                $produitAchat[] = $produit;
            }
        }

        self::afficherVue("vueGenerale.php", ["pagetitle" => "Détail achat", "cheminVueBody" => "utilisateur/client/detailAchat.php", "produits" => $produitAchat]);
    }

    public static function validerAchat(): void {
        try {
            if (ConnexionUtilisateur::estConnecte()) {
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
                    }
                }
            } else {
                if (Cookie::contient("panier")) {
                    $panier = Cookie::lire("panier");
                    if ($panier == null) {
                        (new MessageFlash())->ajouter("warning", "Votre panier est vide");
                        ControleurUtilisateurGenerique::afficherPanier();
                        return;
                    }
                    Cookie::supprimer("panier");
                } else {
                    (new MessageFlash())->ajouter("warning", "Votre panier est vide");
                    ControleurUtilisateurGenerique::afficherPanier();
                    return;
                }
            }
            (new MessageFlash())->ajouter("success", "Votre achat a été validé !");
            self::afficherCatalogue();
        } catch (Exception $e) {
            (new MessageFlash())->ajouter("danger", "Une erreur est survenue lors de la validation du panier");
            (new ControleurProduit())->afficherCatalogue();
        }
    }
}
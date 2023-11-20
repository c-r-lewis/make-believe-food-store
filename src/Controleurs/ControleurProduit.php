<?php

namespace App\Magasin\Controleurs;

use App\Magasin\Lib\MessageFlash;
use App\Magasin\Modeles\DataObject\Image;
use App\Magasin\Modeles\DataObject\Produit;
use App\Magasin\Modeles\DataObject\ProduitPanier;
use App\Magasin\Modeles\Repository\ImageRepository;
use App\Magasin\Modeles\Repository\ProduitPanierRepository;
use App\Magasin\Modeles\Repository\ProduitRepository as ProduitRepository;
use App\Magasin\Modeles\DataObject\Panier as Panier;
use Exception;

class ControleurProduit extends ControleurGenerique
{
    public static function afficherCatalogue(): void
    {
        $produits = (new ProduitRepository())->recuperer();
        self::afficherVue("vueGenerale.php", ["cheminVueBody" => "produit/catalogue.php",
            "produits" => $produits]);
    }

    public static function afficherCreationProduit(): void
    {
        self::afficherVue("vueGenerale.php", ["cheminVueBody" => "utilisateur/admin/formulaireCreerProduit.php"]);
    }

    public static function afficherModificationProduit(): void
    {
        self::afficherVue("vueGenerale.php", ["cheminVueBody" => "utilisateur/admin/formulaireMettreAJourProduit.php"]);
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

                $produit = new Produit($nomProduit, $descriptionProduit, $prixProduit);

                (new ProduitRepository())->sauvegarder($produit);

                $idProduit = (new ProduitRepository())->getDerniereIdIncrementee();

                if (isset($_FILES['images']) && $_FILES['images']['error'] === UPLOAD_ERR_OK) {
                    $imagePath = self::deplacerImageProduit($_FILES['images'], $idProduit);
                    $image = new Image($idProduit, $imagePath);
                    (new ImageRepository())->sauvegarder($image);
                }


                self::afficherCatalogue();
            }
        } catch (Exception $e) {
            self::erreur($e->getMessage());
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


    public
    static function afficherDetailProduit(): void
    {
        try {
            if (empty($_GET["idProduit"])) {
                self::erreur("L'identifiant du produit est manquant.");
            }

            $idProduit = $_GET["idProduit"];
            if (!(new ProduitRepository())->clePrimaireExiste([$idProduit])) {
                self::erreur("Ce produit n'existe pas.");
            }

            $produit = (new ProduitRepository())->recupererParClePrimaire([$idProduit])[0];
            self::afficherVue("vueGenerale.php", ["cheminVueBody" => "produit/detail.php", "produit" => $produit]);
        } catch (\Exception $e) {
            self::erreur($e->getMessage());
        }
    }

    public
    static function ajouterProduitAuPanier(): void
    {
        if (!(new ProduitRepository())->clePrimaireExiste([$_GET["idProduit"]])) {
            self::erreur("Ajoutez un produit qui existe dans votre panier");
        } else if (!filter_var($_GET["idProduit"], FILTER_VALIDATE_INT)) {
            self::erreur("La quantité doit être un entier");
        } else {
            Panier::ajouterItem($_GET["idProduit"], $_GET["quantite"]);
            self::afficherDetailProduit();
        }
    }

    public
    static function supprimerProduitDuPanier(): void
    {
        if (!(new ProduitRepository())->clePrimaireExiste([$_GET["idProduit"]])) {
            self::erreur("Vous ne pouvez pas supprimer un produit qui n'existe pas");
        } else {
            Panier::supprimerItem((int)$_GET["idProduit"]);
            echo '<meta http-equiv="refresh" content="0;url=controleurFrontal.php?action=afficherPanier&controleur=utilisateurGenerique">';
        }
    }

    public
    static function modifierQuantitePanier(): void
    {
        if (!(new ProduitRepository())->clePrimaireExiste([$_GET["idProduit"]])) {
            self::erreur("Modifiez la quantité d'un produit qui est dans votre panier");
        } else if (!filter_var($_GET["idProduit"], FILTER_VALIDATE_INT)) {
            self::erreur("La quantité doit être un entier");
        } else {
            Panier::modifierQuantite($_GET["idProduit"], $_GET["quantite"]);
            echo '<meta http-equiv="refresh" content="0;url=controleurFrontal.php?action=afficherPanier&controleur=utilisateurGenerique">';
        }
    }

    public
    static function supprimerProduit(): void
    {
        if (isset($_GET['idProduit'])) {
            $idProduit = $_GET['idProduit'];

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
            if ($_SERVER["REQUEST_METHOD"] == "GET") {
                $idProduit = $_GET["idProduit"];
                $nomProduit = $_GET["nomProduit"];
                $descriptionProduit = $_GET["descriptionProduit"];
                $prixProduit = $_GET["prixProduit"];

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
            self::erreur($e->getMessage());
        }
    }
}
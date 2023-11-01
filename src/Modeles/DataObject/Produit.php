<?php
namespace App\Magasin\Modeles\DataObject;

class Produit extends AbstractDataObject
{
    private int $idProduit;
    private string $nomProduit;
    private string $descriptionProduit;
    private float $prixProduit;

    public function __construct(string $nomProduit, string $dscriptionProduit, float $prixProduit) {
        $this->nomProduit = $nomProduit;
        $this->descriptionProduit = $dscriptionProduit;
        $this->prixProduit = $prixProduit;
    }

    /**
     * @return int
     */
    public function getIdProduit(): int
    {
        return $this->idProduit;
    }
    

    /**
     * @return string
     */
    public function getNomProduit(): string
    {
        return $this->nomProduit;
    }

    /**
     * @param string $nomProduit
     */
    public function setNomProduit(string $nomProduit): void
    {
        $this->nomProduit = $nomProduit;
    }

    /**
     * @return string
     */
    public function getDescriptionProduit(): string
    {
        return $this->descriptionProduit;
    }

    /**
     * @param string $descriptionProduit
     */
    public function setDescriptionProduit(string $descriptionProduit): void
    {
        $this->descriptionProduit = $descriptionProduit;
    }

    /**
     * @return float
     */
    public function getPrixProduit(): float
    {
        return $this->prixProduit;
    }

    /**
     * @param float $prixProduit
     */
    public function setPrixProduit(float $prixProduit): void
    {
        $this->prixProduit = $prixProduit;
    }

    public function __toString() : string {
        return  "<p> idProduit : $this->idProduit \n
                Nom produit : $this->nomProduit \n
                Description produit : $this->descriptionProduit \n
                Prix Produit : $this->prixProduit \n</p>";
    }

    public function formatTableau() : array
    {
        return [
            "idProduitTag"=>$this->idProduit,
            "nomProduitTag"=>$this->nomProduit,
            "descriptionProduitTag"=>$this->descriptionProduit,
            "prixProduitTag"=>$this->prixProduit
        ];
    }
}
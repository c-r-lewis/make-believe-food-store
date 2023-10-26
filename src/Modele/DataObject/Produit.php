<?php
namespace App\Magasin\Modele\DataObject;

class Produit
{
    private int $idProduit;
    private string $nomProduit;
    private string $descriptionProduit;
    private float $prixProduit;

    public function __construct(int $idProduit, string $nomProduit, string $dscriptionProduit, float $prixProduit) {
        $this->idProduit = $idProduit;
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
     * @param int $idProduit
     */
    public function setIdProduit(int $idProduit): void
    {
        $this->idProduit = $idProduit;
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


}
<?php
namespace App\Magasin\Modeles\DataObject;

class Produit extends AbstractDataObject
{
    private int $idProduit;
    private string $nomProduit;
    private string $descriptionProduit;
    private float $prixProduit;

    public function __construct() {
        $args = func_get_args();
        $numArgs = func_num_args();

        if (method_exists($this, $f = '__construct' . $numArgs)) {
            call_user_func_array(array($this, $f), $args);
        }
    }

    public function __construct4(int $idProduit, string $nomProduit, string $dscriptionProduit, float $prixProduit) {
        $this->nomProduit = $nomProduit;
        $this->descriptionProduit = $dscriptionProduit;
        $this->prixProduit = $prixProduit;
        $this->idProduit = $idProduit;
    }

    public function __construct3(string $nomProduit, string $dscriptionProduit, float $prixProduit) {
        $this->nomProduit = $nomProduit;
        $this->descriptionProduit = $dscriptionProduit;
        $this->prixProduit = $prixProduit;
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

    public function formatTableau() : array
    {
        if ($this->idProduit!=null){
            return [
                "idProduitTag"=>$this->idProduit,
                "nomProduitTag"=>$this->nomProduit,
                "descriptionProduitTag"=>$this->descriptionProduit,
                "prixProduitTag"=>$this->prixProduit
            ];
        }
        return [
            "nomProduitTag"=>$this->nomProduit,
            "descriptionProduitTag"=>$this->descriptionProduit,
            "prixProduitTag"=>$this->prixProduit
        ];
    }

    public function getIdProduit() : ?int {
        return $this->idProduit;
    }
}
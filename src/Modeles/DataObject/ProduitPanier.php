<?php
namespace App\Magasin\Modeles\DataObject;

class ProduitPanier extends Panier {
    private int $idPanier;
    private int $idProduit;
    private int $quantite;

    public function __construct(int $idPanier, int $idProduit, int $quantite) {
        $this->idPanier = $idPanier;
        $this->idProduit = $idProduit;
        $this->quantite = $quantite;
    }

    public static function construireDepuisFormulaire(array $tableauFormulaire): ProduitPanier
    {
        return new ProduitPanier(
            $tableauFormulaire["idPanier"],
            $tableauFormulaire["idProduit"],
            $tableauFormulaire["quantite"]
        );

    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getIdPanier(): int
    {
        return $this->idPanier;
    }

    public function setIdPanier(int $idPanier): void
    {
        $this->idPanier = $idPanier;
    }

    public function formatTableau()
    {
        return ["idPanierTag"=>$this->idPanier,
        "idProduitTag"=>$this->idProduit,
        "quantiteTag"=>$this->quantite];
    }
}
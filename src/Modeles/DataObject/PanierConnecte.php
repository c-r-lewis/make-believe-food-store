<?php
namespace App\Magasin\Modeles\DataObject;

class PanierConnecte extends Panier {
    private string $email;
    private string $idPanier;

    public function __construct(string $email, string $idPanier) {
        $this->email = $email;
        $this->idPanier = $idPanier;
    }

    public static function construireDepuisFormulaire(array $tableauFormulaire): PanierConnecte
    {
        return new PanierConnecte(
            $tableauFormulaire["email"],
            $tableauFormulaire["idPanier"]
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
        return [
            "emailTag" => $this->getEmail(),
            "idPanierTag" => $this->getIdPanier(),
        ];
    }
}
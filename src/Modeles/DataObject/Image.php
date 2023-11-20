<?php

namespace App\Magasin\Modeles\DataObject;

class Image extends AbstractDataObject
{
    private ?int $idProduit;
    private string $image;

    public function __construct()
    {
        $args = func_get_args();
        $numArgs = func_num_args();

        if (method_exists($this, $f = '__construct' . $numArgs)) {
            call_user_func_array([$this, $f], $args);
        }
    }

    public function __construct2(int $idProduit, string $image)
    {
        $this->idProduit = $idProduit;
        $this->image = $image;
    }

    public function __construct1(string $image)
    {
        $this->idProduit = null;
        $this->image = $image;
    }

    public function getIdProduit(): ?int
    {
        return $this->idProduit;
    }

    public function setIdProduit(int $idProduit): void
    {
        $this->idProduit = $idProduit;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function setImage(string $image): void
    {
        $this->image = $image;
    }

    public function formatTableau(): array
    {
        if ($this->idProduit !== null) {
            return [
                "idProduitTag" => $this->idProduit,
                "imageTag" => $this->image,
            ];
        }

        return [
            "imageTag" => $this->image,
        ];
    }
}

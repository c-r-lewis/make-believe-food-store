<?php

namespace App\Magasin\Modeles\DataObject;
class Utilisateur extends AbstractDataObject
{

    public function formatTableau(): array    {
        return
        [
            "email" => $this->getEmail(),
            "nom" => $this->getNom(),
            "prenom" => $this->getPrenom(),
            "mdp" => $this->getMdp()
        ];
    }
}
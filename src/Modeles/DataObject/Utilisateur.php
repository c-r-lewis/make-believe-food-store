<?php

namespace App\Magasin\Modeles\DataObject;

class Utilisateur extends AbstractDataObject
{
    private string $email;
    private string $nom;
    private string $prenom;
    private string $mdp;
    private bool $estAdmin;

    public function __construct(string $email, string $nom, string $prenom, string $mdp, bool $estAdmin = false) {
        $this->email = $email;
        $this->nom = $nom;
        $this->prenom =  $prenom;
        $this->mdp = $mdp;
        $this->estAdmin = $estAdmin;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function setNom(string $nom): void
    {
        $this->nom = $nom;
    }

    public function getPrenom(): string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): void
    {
        $this->prenom = $prenom;
    }

    public function getMdp(): string
    {
        return $this->mdp;
    }

    public function setMdp(string $mdp): void
    {
        $this->mdp = $mdp;
    }

    public function estAdmin(): bool
    {
        return $this->estAdmin;
    }

    public function setEstAdmin(bool $estAdmin): void
    {
        $this->estAdmin = $estAdmin;
    }


    public function formatTableau(): array    {
        if ($this->estAdmin) {
            $admin = 1;
        }
        else {
            $admin = 0;
        }
        return
            [
                "emailTag" => $this->getEmail(),
                "nomTag" => $this->getNom(),
                "prenomTag" => $this->getPrenom(),
                "mdpTag" => $this->getMdp(),
                "estAdminTag" => $admin
            ];
    }
}
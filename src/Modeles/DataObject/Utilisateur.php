<?php

namespace App\Magasin\Modeles\DataObject;

use App\Magasin\Lib\MotDePasse;

class Utilisateur extends AbstractDataObject
{
    private string $email;
    private string $emailAValider;
    private string $nonce;
    private string $nom;
    private string $prenom;
    private string $mdpHache;
    private bool $estAdmin;

    public function __construct(string $email, string $nom, string $prenom, string $mdpHache, bool $estAdmin = false) {
        $this->email = $email;
        $this->emailAValider = $email;
        $this->nonce = MotDePasse::genererChaineAleatoire(16);
        $this->nom = $nom;
        $this->prenom =  $prenom;
        $this->mdpHache = $mdpHache;
        $this->estAdmin = $estAdmin;
    }

    public static function construireDepuisFormulaire(array $tableauFormulaire): Utilisateur
    {
        $mdpHache = MotDePasse::hacher($tableauFormulaire["mdp"]);
        return new Utilisateur(
            $tableauFormulaire["email"],
            $tableauFormulaire["nom"],
            $tableauFormulaire["prenom"],
            $mdpHache
        );
    }

    public function getEmailAValider(): string
    {
        return $this->emailAValider;
    }

    public function setEmailAValider(string $emailAValider): void
    {
        $this->emailAValider = $emailAValider;
    }

    public function getNonce(): string
    {
        return $this->nonce;
    }

    public function setNonce(string $nonce): void
    {
        $this->nonce = $nonce;
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

    public function getMdpHache(): string
    {
        return $this->mdpHache;
    }

    public function setMdpHache(string $mdpHache): void
    {
        $this->mdpHache = $mdpHache;
    }

    public function estAdmin(): bool
    {
        return $this->estAdmin;
    }

    public function setEstAdmin(bool $estAdmin): void
    {
        $this->estAdmin = $estAdmin;
    }


    public function formatTableau(): array
    {
        if ($this->estAdmin) {
            $admin = 1;
        } else {
            $admin = 0;
        }

        return [
            "emailTag" => $this->getEmail(),
            "nomTag" => $this->getNom(),
            "prenomTag" => $this->getPrenom(),
            "mdpHacheTag" => $this->getMdpHache(),
            "estAdminTag" => $admin,
            "emailAValiderTag" => $this->getEmailAValider(),
            "nonceTag" => $this->getNonce(),
        ];
    }
}
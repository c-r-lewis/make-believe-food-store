<?php

namespace App\Magasin\Lib;

use App\Magasin\Modeles\HTTP\Session;

class MessageFlash
{
    private string $cleFlash = "_messagesFlash";
    private Session $session;

    public function __construct()
    {
        $this->session = Session::getInstance();
    }

    public function ajouter(string $type, string $message): void
    {
        if (!$this->session->contient($this->cleFlash)) {
            $this->session->enregistrer($this->cleFlash, []);
        }

        $messages = $this->session->lire($this->cleFlash);

        if (!isset($messages[$type])) {
            $messages[$type] = [];
        }

        $messages[$type][] = $message;

        $this->session->enregistrer($this->cleFlash, $messages);
    }

    public function contientMessage(string $type): bool
    {
        return $this->session->contient($this->cleFlash) && isset($this->session->lire($this->cleFlash)[$type]);
    }

    public function lireMessages(string $type): array
    {
        $messages = $this->session->lire($this->cleFlash)[$type] ?? [];
        $this->session->supprimer($this->cleFlash, $type);
        return $messages;
    }

    public function lireTousMessages(): array
    {
        $allMessages = $this->session->lire($this->cleFlash) ?? [];
        $this->session->supprimer($this->cleFlash);
        return $allMessages;
    }
}

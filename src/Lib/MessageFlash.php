<?php
namespace App\Magasin\Lib;

class MessageFlash
{
    private static string $cleFlash = "_messagesFlash";

    public static function ajouter(string $type, string $message): void
    {
        if (!isset($_SESSION[self::$cleFlash][$type])) {
            $_SESSION[self::$cleFlash][$type] = [];
        }

        $_SESSION[self::$cleFlash][$type][] = $message;
    }

    public static function contientMessage(string $type): bool
    {
        return isset($_SESSION[self::$cleFlash][$type]);
    }

    public static function lireMessages(string $type): array
    {
        $messages = isset($_SESSION[self::$cleFlash][$type]) ? $_SESSION[self::$cleFlash][$type] : [];
        unset($_SESSION[self::$cleFlash][$type]); // Remove the messages from the session
        return $messages;
    }

    public static function lireTousMessages(): array
    {
        $allMessages = $_SESSION[self::$cleFlash] ?? [];
        $_SESSION[self::$cleFlash] = []; // Clear all flash messages
        return $allMessages;
    }
}

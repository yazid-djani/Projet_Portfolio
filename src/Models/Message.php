<?php
namespace App\Models;
use App\Lib\Database;

class Message extends Model {
    protected static string $table = 'messages_contact';

    public static function add($nom, $email, $sujet, $message) {
        $db = Database::getPDO();
        $stmt = $db->prepare("INSERT INTO messages_contact (nom, email, sujet, message) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$nom, $email, $sujet, $message]);
    }
}
<?php
require_once __DIR__ . '/../config/database.php';

class Message {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    /**
     * Get list of conversations (unique users) for a given user
     */
    public function getConversations(int $user_id): array {
        $stmt = $this->db->prepare("
            SELECT 
                u.ID as user_id, u.Name as user_name, u.Role as user_role,
                m.Content as last_message, m.Sent_at as last_time,
                (SELECT COUNT(*) FROM Messages 
                 WHERE Sender = u.ID AND Receiver = :uid3 AND Is_read = FALSE
                ) as unread_count
            FROM Users u
            JOIN Messages m ON m.ID = (
                SELECT m2.ID FROM Messages m2 
                WHERE (m2.Sender = u.ID AND m2.Receiver = :uid1)
                   OR (m2.Sender = :uid2 AND m2.Receiver = u.ID)
                ORDER BY m2.Sent_at DESC LIMIT 1
            )
            WHERE u.ID != :uid4
              AND (u.ID IN (SELECT Sender FROM Messages WHERE Receiver = :uid5)
                OR u.ID IN (SELECT Receiver FROM Messages WHERE Sender = :uid6))
            ORDER BY m.Sent_at DESC
        ");
        $stmt->execute([
            'uid1' => $user_id, 'uid2' => $user_id, 'uid3' => $user_id,
            'uid4' => $user_id, 'uid5' => $user_id, 'uid6' => $user_id
        ]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get all messages between two users
     */
    public function getThread(int $user1, int $user2): array {
        $stmt = $this->db->prepare("
            SELECT m.ID as id, m.Sender as sender_id, m.Receiver as receiver_id,
                   m.Content as content, m.Is_read as is_read, m.Sent_at as sent_at,
                   u.Name as sender_name
            FROM Messages m
            JOIN Users u ON m.Sender = u.ID
            WHERE (m.Sender = :u1a AND m.Receiver = :u2a)
               OR (m.Sender = :u2b AND m.Receiver = :u1b)
            ORDER BY m.Sent_at ASC
        ");
        $stmt->execute(['u1a' => $user1, 'u2a' => $user2, 'u2b' => $user2, 'u1b' => $user1]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Send a message
     */
    public function send(int $sender_id, int $receiver_id, string $content): bool {
        $stmt = $this->db->prepare("
            INSERT INTO Messages (Sender, Receiver, Content) 
            VALUES (:sender, :receiver, :content)
        ");
        return $stmt->execute([
            'sender' => $sender_id,
            'receiver' => $receiver_id,
            'content' => trim($content)
        ]);
    }

    /**
     * Mark all messages from a sender as read for a receiver
     */
    public function markAsRead(int $sender_id, int $receiver_id): bool {
        $stmt = $this->db->prepare("
            UPDATE Messages SET Is_read = TRUE 
            WHERE Sender = :sender AND Receiver = :receiver AND Is_read = FALSE
        ");
        return $stmt->execute(['sender' => $sender_id, 'receiver' => $receiver_id]);
    }

    /**
     * Get total unread message count for a user
     */
    public function getUnreadCount(int $user_id): int {
        $stmt = $this->db->prepare("
            SELECT COUNT(*) FROM Messages 
            WHERE Receiver = :uid AND Is_read = FALSE
        ");
        $stmt->execute(['uid' => $user_id]);
        return (int)$stmt->fetchColumn();
    }
}

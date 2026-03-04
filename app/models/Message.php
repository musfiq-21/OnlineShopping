<?php
require __DIR__ . '/../../core/Database.php';
class Message {
    public int $id;
    public int $sender_id;
    public int $receiver_id;
    public string $content;
    public bool $is_read;
    public string $sent_at;

    private PDO $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function getConversation(int $user_a, int $user_b): array {
        $sql = "SELECT * FROM Messages 
                WHERE (Sender = :ua AND Receiver = :ub) 
                   OR (Sender = :ub AND Receiver = :ua) 
                ORDER BY Sent_at ASC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['ua' => $user_a, 'ub' => $user_b]);
        return $stmt->fetchAll(PDO::FETCH_CLASS, self::class, [$this->db]);
    }

    public function getInbox(int $receiver_id): array {
        $sql = "SELECT m.*, u.Name as sender_name 
                FROM Messages m
                JOIN Users u ON m.Sender = u.ID
                WHERE m.ID IN (
                    SELECT MAX(ID) FROM Messages 
                    WHERE Receiver = :receiver_id 
                    GROUP BY Sender
                )
                ORDER BY m.Sent_at DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['receiver_id' => $receiver_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC); 
    }

    public function send(int $sender_id, int $receiver_id, string $content): bool {
        $stmt = $this->db->prepare("
            INSERT INTO Messages (Sender, Receiver, Content) 
            VALUES (:sender, :receiver, :content)
        ");
        return $stmt->execute([
            'sender'   => $sender_id,
            'receiver' => $receiver_id,
            'content'  => $content
        ]);
    }

    public function markAsRead(int $sender_id, int $receiver_id): bool {
        $stmt = $this->db->prepare("
            UPDATE Messages 
            SET Is_read = TRUE 
            WHERE Sender = :sender AND Receiver = :receiver AND Is_read = FALSE
        ");
        return $stmt->execute([
            'sender'   => $sender_id,
            'receiver' => $receiver_id
        ]);
    }

    public function countUnread(int $receiver_id): int {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM Messages WHERE Receiver = :id AND Is_read = FALSE");
        $stmt->execute(['id' => $receiver_id]);
        return (int)$stmt->fetchColumn();
    }
}
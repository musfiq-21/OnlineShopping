<?php
require_once __DIR__ . '/../../core/Database.php';
class Comment {
    public int $id;
    public int $writer_id;
    public int $product_id;
    public string $content;
    public string $created_at;
    
    // Extra attribute from the JOIN (optional but helpful)
    public ?string $writer_name = null;

    private PDO $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    /**
     * Fetch all comments for a product, including the writer's name
     */
    public function findByProduct(int $product_id): array {
        $sql = "SELECT c.*, u.Name as writer_name 
                FROM Comments c
                JOIN Users u ON c.Writer = u.ID
                WHERE c.Product = :product_id
                ORDER BY c.Created_at DESC";
                
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['product_id' => $product_id]);
        
        // We use FETCH_OBJ or FETCH_ASSOC here because the added 'writer_name' 
        // isn't a native property of the base Comments table.
        return $stmt->fetchAll(PDO::FETCH_CLASS, self::class, [$this->db]);
    }

    /**
     * Post a new comment
     */
    public function create(int $writer_id, int $product_id, string $content): bool {
        $stmt = $this->db->prepare("
            INSERT INTO Comments (Writer, Product, Content) 
            VALUES (:writer_id, :product_id, :content)
        ");
        
        return $stmt->execute([
            'writer_id'  => $writer_id,
            'product_id' => $product_id,
            'content'    => $content
        ]);
    }

    /**
     * Admin moderation - remove a comment
     */
    public function delete(int $id): bool {
        $stmt = $this->db->prepare("DELETE FROM Comments WHERE ID = :id");
        return $stmt->execute(['id' => $id]);
    }
}
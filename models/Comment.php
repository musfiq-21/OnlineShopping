<?php
require_once __DIR__ . '/../config/database.php';

class Comment {
    public int $id;
    public int $writer_id;
    public int $product_id;
    public string $content;
    public string $created_at;
    public ?string $writer_name;

    private PDO $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function getByProduct(int $product_id): array {
        $stmt = $this->db->prepare("
            SELECT c.ID as id, c.Writer as writer_id, c.Product as product_id, 
                   c.Content as content, c.Created_at as created_at, u.Name as writer_name
            FROM Comments c 
            JOIN Users u ON c.Writer = u.ID 
            WHERE c.Product = :product_id 
            ORDER BY c.Created_at DESC
        ");
        $stmt->execute(['product_id' => $product_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create(int $writer_id, int $product_id, string $content): bool {
        $stmt = $this->db->prepare("
            INSERT INTO Comments (Writer, Product, Content) 
            VALUES (:writer_id, :product_id, :content)
        ");
        return $stmt->execute([
            'writer_id' => $writer_id,
            'product_id' => $product_id,
            'content' => trim($content)
        ]);
    }

    public function getBySeller(int $seller_id): array {
        $stmt = $this->db->prepare("
            SELECT c.ID as id, c.Writer as writer_id, c.Product as product_id, 
                   c.Content as content, c.Created_at as created_at, 
                   u.Name as writer_name, p.Name as product_name
            FROM Comments c 
            JOIN Users u ON c.Writer = u.ID 
            JOIN Products p ON c.Product = p.ID
            WHERE p.Seller = :seller_id 
            ORDER BY c.Created_at DESC
        ");
        $stmt->execute(['seller_id' => $seller_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function delete(int $id): bool {
        $stmt = $this->db->prepare("DELETE FROM Comments WHERE ID = :id");
        return $stmt->execute(['id' => $id]);
    }

    public function deleteByProduct(int $product_id): bool {
        $stmt = $this->db->prepare("DELETE FROM Comments WHERE Product = :product_id");
        return $stmt->execute(['product_id' => $product_id]);
    }
}

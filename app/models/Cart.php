<?php
require_once __DIR__ . '/../../core/Database.php';
class Cart {
    public int $id;
    public int $user_id;
    public int $product_id;
    public int $quantity;
    public string $added_at;

    private PDO $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function getByUser(int $user_id): array {
        $sql = "SELECT c.*, p.Name as product_name, p.Price as unit_price, p.Stock_image
                FROM Carts c
                JOIN Products p ON c.Product = p.ID
                WHERE c.User = :user_id
                ORDER BY c.Added_at DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['user_id' => $user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addOrUpdate(int $user_id, int $product_id, int $quantity): bool {
        $sql = "INSERT INTO Carts (User, Product, Quantity) 
                VALUES (:user, :prod, :qty)
                ON DUPLICATE KEY UPDATE Quantity = Quantity + VALUES(Quantity)";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'user' => $user_id,
            'prod' => $product_id,
            'qty'  => $quantity
        ]);
    }

    public function remove(int $user_id, int $product_id): bool {
        $stmt = $this->db->prepare("DELETE FROM Carts WHERE User = :user AND Product = :prod");
        return $stmt->execute([
            'user' => $user_id,
            'prod' => $product_id
        ]);
    }

    public function clearByUser(int $user_id): bool {
        $stmt = $this->db->prepare("DELETE FROM Carts WHERE User = :user_id");
        return $stmt->execute(['user_id' => $user_id]);
    }
}
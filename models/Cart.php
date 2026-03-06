<?php
require_once __DIR__ . '/../config/database.php';

class Cart {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function getByUser(int $user_id): array {
        $stmt = $this->db->prepare("
            SELECT c.ID, c.Product, c.Quantity, c.Added_at,
                   p.Name as product_name, p.Price as unit_price, p.Stock_image as image
            FROM Carts c
            JOIN Products p ON c.Product = p.ID
            WHERE c.User = :user_id
            ORDER BY c.Added_at DESC
        ");
        $stmt->execute(['user_id' => $user_id]);
        return $stmt->fetchAll();
    }

    public function add(int $user_id, int $product_id, int $quantity): bool {
        $stmt = $this->db->prepare("
            INSERT INTO Carts (User, Product, Quantity) 
            VALUES (:user, :product, :qty)
            ON DUPLICATE KEY UPDATE Quantity = Quantity + VALUES(Quantity)
        ");
        return $stmt->execute([
            'user' => $user_id,
            'product' => $product_id,
            'qty' => $quantity
        ]);
    }

    public function remove(int $user_id, int $product_id): bool {
        $stmt = $this->db->prepare("DELETE FROM Carts WHERE User = :user AND Product = :product");
        return $stmt->execute(['user' => $user_id, 'product' => $product_id]);
    }

    public function clear(int $user_id): bool {
        $stmt = $this->db->prepare("DELETE FROM Carts WHERE User = :user_id");
        return $stmt->execute(['user_id' => $user_id]);
    }
}

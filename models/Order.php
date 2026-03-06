<?php
require_once __DIR__ . '/../config/database.php';

class Order {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function create(int $product_id, int $buyer_id, int $quantity, float $total): bool {
        $stmt = $this->db->prepare("
            INSERT INTO Sells (Product, Buyer, Quantity, Total_price) 
            VALUES (:product, :buyer, :qty, :total)
        ");
        return $stmt->execute([
            'product' => $product_id,
            'buyer' => $buyer_id,
            'qty' => $quantity,
            'total' => $total
        ]);
    }

    public function getByBuyer(int $buyer_id): array {
        $stmt = $this->db->prepare("
            SELECT s.ID, s.Quantity, s.Total_price, s.Sold_at,
                   p.Name as product_name, p.Stock_image as image
            FROM Sells s
            JOIN Products p ON s.Product = p.ID
            WHERE s.Buyer = :buyer_id
            ORDER BY s.Sold_at DESC
        ");
        $stmt->execute(['buyer_id' => $buyer_id]);
        return $stmt->fetchAll();
    }

    public function getBySeller(int $seller_id): array {
        $stmt = $this->db->prepare("
            SELECT s.ID, s.Quantity, s.Total_price, s.Sold_at,
                   p.Name as product_name, u.Name as buyer_name
            FROM Sells s
            JOIN Products p ON s.Product = p.ID
            JOIN Users u ON s.Buyer = u.ID
            WHERE p.Seller = :seller_id
            ORDER BY s.Sold_at DESC
        ");
        $stmt->execute(['seller_id' => $seller_id]);
        return $stmt->fetchAll();
    }

    public function getAll(): array {
        $stmt = $this->db->query("
            SELECT s.ID, s.Quantity, s.Total_price, s.Sold_at,
                   p.Name as product_name, u.Name as buyer_name
            FROM Sells s
            JOIN Products p ON s.Product = p.ID
            JOIN Users u ON s.Buyer = u.ID
            ORDER BY s.Sold_at DESC
        ");
        return $stmt->fetchAll();
    }
}

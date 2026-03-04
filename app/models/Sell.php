<?php
require "../../core/Database.php";
class Sell {
    public int $id;
    public int $product_id;
    public int $buyer_id;
    public int $quantity;
    public float $total_price;
    public string $sold_at;

    private PDO $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function create(int $product_id, int $buyer_id, int $quantity, float $total_price): bool {
        $stmt = $this->db->prepare("
            INSERT INTO Sells (Product, Buyer, Quantity, Total_price) 
            VALUES (:product, :buyer, :qty, :total)
        ");
        return $stmt->execute([
            'product' => $product_id,
            'buyer'   => $buyer_id,
            'qty'     => $quantity,
            'total'   => $total_price
        ]);
    }
    public function getByBuyer(int $buyer_id): array {
        $sql = "SELECT s.*, p.Name as product_name, p.Stock_image 
                FROM Sells s
                JOIN Products p ON s.Product = p.ID
                WHERE s.Buyer = :buyer_id
                ORDER BY s.Sold_at DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['buyer_id' => $buyer_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getBySeller(int $seller_id): array {
        $sql = "SELECT s.*, p.Name as product_name, u.Name as buyer_name
                FROM Sells s
                JOIN Products p ON s.Product = p.ID
                JOIN Users u ON s.Buyer = u.ID
                WHERE p.Seller = :seller_id
                ORDER BY s.Sold_at DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['seller_id' => $seller_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAll(): array {
        $sql = "SELECT s.*, p.Name as product_name, u.Name as buyer_name 
                FROM Sells s
                JOIN Products p ON s.Product = p.ID
                JOIN Users u ON s.Buyer = u.ID
                ORDER BY s.Sold_at DESC";
                
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
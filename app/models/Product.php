<?php
require_once __DIR__ . '/../../core/Database.php';
class Product {
    public int $id;
    public string $name;
    public float $price;
    public int $quantity;
    public int $seller_id; 
    public ?string $stock_image;
    public string $created_at;

    private PDO $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function findById(int $id): ?Product {
        $stmt = $this->db->prepare("SELECT * FROM Products WHERE ID = :id LIMIT 1");
        $stmt->execute(['id' => $id]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, self::class, [$this->db]);
        return $stmt->fetch() ?: null;
    }

    public function findBySeller(int $seller_id): array {
        $stmt = $this->db->prepare("SELECT * FROM Products WHERE Seller = :seller_id");
        $stmt->execute(['seller_id' => $seller_id]);
        return $stmt->fetchAll(PDO::FETCH_CLASS, self::class, [$this->db]);
    }

    public function search(string $keyword): array {
        $stmt = $this->db->prepare("SELECT * FROM Products WHERE Name LIKE :keyword");
        $stmt->execute(['keyword' => "%$keyword%"]);
        return $stmt->fetchAll(PDO::FETCH_CLASS, self::class, [$this->db]);
    }

    public function getAll(): array {
        $stmt = $this->db->query("SELECT * FROM Products ORDER BY Created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_CLASS, self::class, [$this->db]);
    }

    public function create(string $name, float $price, int $qty, int $seller_id, string $image_path): bool {
        $stmt = $this->db->prepare("
            INSERT INTO Products (Name, Price, Quantity, Seller, Stock_image) 
            VALUES (:name, :price, :qty, :seller_id, :image)
        ");
        return $stmt->execute([
            'name' => $name,   'price' => $price,  'qty' => $qty, 
            'seller_id' => $seller_id,  'image' => $image_path
        ]);
    }

    public function updatePrice(int $id, float $price): bool {
        $stmt = $this->db->prepare("UPDATE Products SET Price = :price WHERE ID = :id");
        return $stmt->execute(['price' => $price, 'id' => $id]);
    }

    public function restock(int $id, int $quantity): bool {
        $stmt = $this->db->prepare("UPDATE Products SET Quantity = Quantity + :qty WHERE ID = :id");
        return $stmt->execute(['qty' => $quantity, 'id' => $id]);
    }

    public function decrementStock(int $id, int $quantity): bool {

        $stmt = $this->db->prepare("
            UPDATE Products 
            SET Quantity = Quantity - :qty 
            WHERE ID = :id AND Quantity >= :qty
        ");
        $stmt->execute(['qty' => $quantity, 'id' => $id]);
        return $stmt->rowCount() > 0; 
    }

    public function delete(int $id): bool {
        $stmt = $this->db->prepare("DELETE FROM Products WHERE ID = :id");
        return $stmt->execute(['id' => $id]);
    }
}
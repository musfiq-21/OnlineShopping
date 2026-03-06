-- Database Schema for Online Shopping Application (shopdb)

-- 1. Create Users Table
CREATE TABLE Users (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(50) NOT NULL UNIQUE,
    Role ENUM('admin', 'seller', 'customer') NOT NULL,
    Hashed_password VARCHAR(255) NOT NULL
);

-- 2. Create Products Table (Reference Users, not User)
CREATE TABLE Products (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(100) NOT NULL,
    Price DECIMAL(10, 2) NOT NULL CHECK (Price >= 0),
    Quantity INT NOT NULL DEFAULT 0 CHECK (Quantity >= 0),
    Seller INT NOT NULL,
    Stock_image VARCHAR(255),
    Created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (Seller) REFERENCES Users(ID) ON DELETE CASCADE
);

-- 3. Create Comments Table
CREATE TABLE Comments (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Writer INT NOT NULL,
    Product INT NOT NULL,
    Content TEXT NOT NULL,
    Created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (Writer) REFERENCES Users(ID) ON DELETE CASCADE,
    FOREIGN KEY (Product) REFERENCES Products(ID) ON DELETE CASCADE
);

-- 4. Create Messages Table
CREATE TABLE Messages (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Sender INT NOT NULL,
    Receiver INT NOT NULL,
    Content TEXT NOT NULL,
    Is_read BOOLEAN DEFAULT FALSE,
    Sent_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (Sender) REFERENCES Users(ID) ON DELETE CASCADE,
    FOREIGN KEY (Receiver) REFERENCES Users(ID) ON DELETE CASCADE
);

-- 5. Create Carts Table
CREATE TABLE Carts (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    User INT NOT NULL,
    Product INT NOT NULL,
    Quantity INT NOT NULL DEFAULT 1 CHECK (Quantity > 0),
    Added_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_cart_item (User, Product),
    FOREIGN KEY (User) REFERENCES Users(ID) ON DELETE CASCADE,
    FOREIGN KEY (Product) REFERENCES Products(ID) ON DELETE CASCADE
);

-- 6. Create Sells Table
CREATE TABLE Sells (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Product INT NOT NULL,
    Buyer INT NOT NULL,
    Quantity INT NOT NULL CHECK (Quantity > 0),
    Total_price DECIMAL(10, 2) NOT NULL,
    Sold_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (Product) REFERENCES Products(ID) ON DELETE CASCADE,
    FOREIGN KEY (Buyer) REFERENCES Users(ID) ON DELETE CASCADE
);



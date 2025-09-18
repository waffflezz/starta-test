CREATE TABLE IF NOT EXISTS products (
    id INT UNSIGNED PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    category VARCHAR(100) NOT NULL,
    price INT NOT NULL,
    stock INT NOT NULL DEFAULT 0,
    rating DECIMAL(2,1) DEFAULT 0.0,
    reviews_count INT UNSIGNED DEFAULT 0,
    created_at DATE NOT NULL,
    image VARCHAR(255),
    promo VARCHAR(255) NULL
)
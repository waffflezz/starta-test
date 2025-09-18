<?php

namespace App\Model;

use App\Kernel\Database;
use App\Kernel\Model;

/**
 * @property int id
 * @property string name
 * @property string category
 * @property int price
 * @property int stock
 * @property float rating
 * @property int reviews_count
 * @property \DateTime created_at
 * @property string image
 * @property string promo
 */
class Product extends Model
{
    protected static string $table = 'products';

    public function create(array $data): int
    {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("
            INSERT INTO products (id, name, category, price, stock, rating, reviews_count, created_at, image, promo)
            VALUES (id:, :name, :category, :price, :stock, :rating, :reviews_count, NOW(), :image, :promo)
            "
        );

        $stmt->execute([
            'id' => $data['id'],
            'name' => $data['name'],
            'category' => $data['category'],
            'price' => $data['price'],
            'stock' => $data['stock'],
            'rating' => $data['rating'],
            'reviews_count' => $data['reviews_count'],
            'image' => $data['image'],
            'promo' => $data['promo']
        ]);

        return (int)$pdo->lastInsertId();
    }

    public function insertMany(array $items): int
    {
        if (empty($items)) {
            return 0;
        }

        $pdo = Database::getInstance();

        $placeholders = [];
        $values = [];

        foreach ($items as $item) {
            $placeholders[] = "(?, ?, ?, ?, ?, ?, ?, NOW(), ?, ?)";
            $values[] = $item['id'];
            $values[] = $item['name'];
            $values[] = $item['category'];
            $values[] = $item['price'];
            $values[] = $item['stock'];
            $values[] = $item['rating'];
            $values[] = $item['reviews_count'];
            $values[] = $item['image'];
            $values[] = $item['promo'];
        }

        $sql = "
            INSERT INTO products 
                (id, name, category, price, stock, rating, reviews_count, created_at, image, promo)
            VALUES " . implode(", ", $placeholders);

        $stmt = $pdo->prepare($sql);
        $stmt->execute($values);

        return $stmt->rowCount();
    }
}
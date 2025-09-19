<?php

namespace App\Model;

use App\Kernel\Database;
use App\Kernel\Model;
use PDO;

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

    public static function create(array $data): int
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

    public static function insertMany(array $items): int
    {
        if (empty($items)) {
            return 0;
        }

        $pdo = Database::getInstance();

        $placeholders = [];
        $values = [];

        foreach ($items as $item) {
            $placeholders[] = "(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $values[] = $item['id'];
            $values[] = $item['name'];
            $values[] = $item['category'];
            $values[] = $item['price'];
            $values[] = $item['stock'];
            $values[] = $item['rating'];
            $values[] = $item['reviews_count'];
            $values[] = $item['created_at'];
            $values[] = $item['image'];
            $values[] = $item['promo'];
        }

        $sql = "
            INSERT INTO products 
                (id, name, category, price, stock, rating, reviews_count, created_at, image, promo)
            VALUES " . implode(", ", $placeholders) . "
            ON DUPLICATE KEY UPDATE
                name = VALUES(name),
                category = VALUES(category),
                price = VALUES(price),
                stock = VALUES(stock),
                rating = VALUES(rating),
                reviews_count = VALUES(reviews_count),
                created_at = VALUES(created_at),
                image = VALUES(image),
                promo = VALUES(promo)
            ";

        $stmt = $pdo->prepare($sql);
        $stmt->execute($values);

        return $stmt->rowCount();
    }

    public static function getPaginated(array $filters = [], array $sort = [], int $page = 1, int $perPage = 20): array
    {
        $pdo = Database::getInstance();

        $where = [];
        $params = [];

        if (!empty($filters['category'])) {
            $where[] = "category = :category";
            $params[':category'] = $filters['category'];
        }

        if (!empty($filters['min_price'])) {
            $where[] = "price >= :min_price";
            $params[':min_price'] = $filters['min_price'];
        }

        if (!empty($filters['max_price'])) {
            $where[] = "price <= :max_price";
            $params[':max_price'] = $filters['max_price'];
        }

        if (!empty($filters['search'])) {
            $where[] = "name LIKE :search";
            $params[':search'] = "%" . $filters['search'] . "%";
        }

        $whereSql = $where ? "WHERE " . implode(" AND ", $where) : "";

        $allowedSortFields = ['id', 'name', 'price', 'stock', 'rating', 'reviews_count', 'created_at'];
        $field = $sort['field'] ?? 'id';
        $direction = strtolower($sort['direction'] ?? 'asc');

        if (!in_array($field, $allowedSortFields)) {
            $field = 'id';
        }

        $direction = in_array($direction, ['asc', 'desc']) ? $direction : 'asc';

        $orderBy = "ORDER BY {$field} {$direction}";

        $offset = ($page - 1) * $perPage;
        $limit = "LIMIT :offset, :limit";

        $sql = "
        SELECT SQL_CALC_FOUND_ROWS * 
        FROM " . self::$table . "
        $whereSql
        $orderBy
        $limit
    ";

        $stmt = $pdo->prepare($sql);

        foreach ($params as $key => $val) {
            $stmt->bindValue($key, $val);
        }

        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $stmt->bindValue(':limit', (int)$perPage, PDO::PARAM_INT);

        $stmt->execute();

        $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $total = $pdo->query("SELECT FOUND_ROWS()")->fetchColumn();

        return [
            'data' => $items,
            'pagination' => [
                'page' => $page,
                'perPage' => $perPage,
                'total' => (int)$total,
                'pages' => (int)ceil($total / $perPage),
            ],
        ];
    }

    public static function getCategories(): array
    {
        $pdo = Database::getInstance();

        $sql = "SELECT DISTINCT category FROM " . static::$table;
        $stmt = $pdo->query($sql);

        $categories = $stmt->fetchAll(PDO::FETCH_COLUMN);

        $categories = array_filter(array_unique($categories));

        sort($categories, SORT_STRING | SORT_FLAG_CASE);

        return $categories;
    }

    public static function getCategoryMedians(): array
    {
        $pdo = Database::getInstance();
        $medians = [];

        $categories = $pdo->query("SELECT DISTINCT category FROM " . static::$table)
            ->fetchAll(PDO::FETCH_COLUMN);

        foreach ($categories as $cat) {
            $prices = $pdo->query("SELECT price FROM " . static::$table . " WHERE category = " . $pdo->quote($cat) . " ORDER BY price ASC")
                ->fetchAll(PDO::FETCH_COLUMN);

            if (count($prices) === 0) continue;

            $middle = (int)floor(count($prices)/2);
            $median = count($prices) % 2 === 0
                ? ($prices[$middle - 1] + $prices[$middle]) / 2
                : $prices[$middle];

            $medians[$cat] = $median;
        }

        return $medians;
    }
}
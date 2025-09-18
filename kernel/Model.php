<?php

namespace App\Kernel;


use PDO;

class Model
{
    protected static string $table;
    protected static string $primaryKey = 'id';
    protected array $attributes = [];

    public function __construct(array $attributes = [])
    {
        $this->fill($attributes);
    }

    public function fill(array $data): static
    {
        foreach ($data as $key => $value) {
            $this->attributes[$key] = $value;
        }
        return $this;
    }

    public function save(): bool
    {
        $pdo = Database::getInstance();

        if (isset($this->attributes[static::$primaryKey])) {
            // UPDATE
            $fields = [];
            $values = [];
            foreach ($this->attributes as $key => $value) {
                if ($key === static::$primaryKey) continue;
                $fields[] = "`$key` = ?";
                $values[] = $value;
            }
            $values[] = $this->attributes[static::$primaryKey];
            $sql = "UPDATE " . static::$table . " SET " . implode(", ", $fields) . " WHERE " . static::$primaryKey . " = ?";
            $stmt = $pdo->prepare($sql);
            return $stmt->execute($values);
        } else {
            // INSERT
            $keys = array_keys($this->attributes);
            $placeholders = implode(',', array_fill(0, count($keys), '?'));
            $sql = "INSERT INTO " . static::$table . " (" . implode(',', $keys) . ") VALUES ($placeholders)";
            $stmt = $pdo->prepare($sql);
            $success = $stmt->execute(array_values($this->attributes));

            if ($success) {
                $this->attributes[static::$primaryKey] = $pdo->lastInsertId();
            }

            return $success;
        }
    }

    public function delete(): bool
    {
        if (!isset($this->attributes[static::$primaryKey])) {
            return false;
        }

        $pdo = Database::getInstance();
        $sql = "DELETE FROM " . static::$table . " WHERE " . static::$primaryKey . " = ?";
        $stmt = $pdo->prepare($sql);

        return $stmt->execute([$this->attributes[static::$primaryKey]]);
    }

    public static function find(int $id): ?static
    {
        $pdo = Database::getInstance();

        $sql = "SELECT * FROM " . static::$table . " WHERE " . static::$table . " = ? LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);

        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ? new static($data) : null;
    }

    public static function findAll(): array
    {
        $pdo = Database::getInstance();

        $sql = "SELECT * FROM " . static::$table;
        $stmt = $pdo->query($sql);

        $results = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $results[] = new static($row);
        }

        return $results;
    }

    public function __get(string $key)
    {
        return $this->attributes[$key] ?? null;
    }

    public function __set(string $key, mixed $value): void
    {
        $this->attributes[$key] = $value;
    }

    public function toArray(): array
    {
        return $this->attributes;
    }
}
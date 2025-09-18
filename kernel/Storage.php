<?php

namespace App\Kernel;

use RuntimeException;

class Storage
{
    protected string $uploadPath;

    public function __construct(string $uploadPath)
    {
        $this->uploadPath = rtrim($uploadPath, '/') . '/';

        if (!is_dir($this->uploadPath)) {
            mkdir($this->uploadPath, 0777, true);
        }
    }

    public function save(array $file): string
    {
        if ($file['error'] !== UPLOAD_ERR_OK) {
            throw new RuntimeException('Ошибка загрузки файла');
        }

        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $name = uniqid('img_', true) . '.' . strtolower($ext);

        $targetPath = $this->uploadPath . '/' . $name;

        if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
            throw new RuntimeException('Не удалось сохранить файл');
        }

        return $name;
    }
}
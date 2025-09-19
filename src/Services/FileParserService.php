<?php

namespace App\Services;

class FileParserService
{
    public static function parse(string $filePath, string $mimeType): array
    {
        if (str_contains($mimeType, 'json')) {
            return self::parseJson($filePath);
        }

        if (str_contains($mimeType, 'csv')) {
            return self::parseCsv($filePath);
        }

        throw new \InvalidArgumentException("Неподдерживаемый тип файла: {$mimeType}");
    }

    private static function parseJson(string $filePath): array
    {
        $content = file_get_contents($filePath);
        return json_decode($content, true) ?? [];
    }

    private static function parseCsv(string $filePath): array
    {
        $rows = [];
        if (($handle = fopen($filePath, 'r')) !== false) {
            $header = str_getcsv(fgets($handle));

            while (($line = fgets($handle)) !== false) {
                $rawFields = str_getcsv($line);
                $fields = [];

                foreach ($rawFields as $field) {
                    if ($field === '') {
                        $fields[] = null;
                    } elseif ($field === '""') {
                        $fields[] = '';
                    } else {
                        $fields[] = $field;
                    }
                }

                $rows[] = array_combine($header, $fields);
            }
            fclose($handle);
        }
        return $rows;
    }
}
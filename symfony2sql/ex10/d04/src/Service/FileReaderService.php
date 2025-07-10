<?php

namespace App\Service;

class FileReaderService
{
    public function readFile(string $filePath): string
    {
        if (!is_readable($filePath)) {
            throw new \RuntimeException("File not readable or does not exist: $filePath");
        }

        return file_get_contents($filePath);
    }
}

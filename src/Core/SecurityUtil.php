<?php

declare(strict_types=1);

namespace App\Core;

/**
 * Security Utility.
 * Provides functions for strict input sanitization and validation.
 */
class SecurityUtil
{
    /**
     * Strictly sanitize an input as an integer.
     */
    public static function sanitizeInt(mixed $input, int $default = 0): int
    {
        if (is_numeric($input)) {
            return (int)$input;
        }
        return $default;
    }

    /**
     * Sanitize a string to prevent null-byte injection and basic XSS.
     */
    public static function sanitizeString(mixed $input): string
    {
        if (!is_string($input)) {
            return "";
        }
        
        // Remove Null Byte
        $input = str_replace(chr(0), '', $input);
        
        // Trim whitespace
        return trim($input);
    }

    /**
     * Validate and sanitize sorting criteria.
     */
    public static function sanitizeSort(string $sort, array $allowedColumns): array
    {
        $criteria = [];
        $parts = explode(',', $sort);
        
        foreach ($parts as $part) {
            $segments = explode(':', $part);
            $column = trim($segments[0] ?? '');
            $direction = strtolower(trim($segments[1] ?? 'desc'));
            
            if (in_array($column, $allowedColumns, true)) {
                $criteria[] = [
                    'column' => $column,
                    'direction' => ($direction === 'asc') ? 'asc' : 'desc'
                ];
            }
        }
        
        return $criteria;
    }
}

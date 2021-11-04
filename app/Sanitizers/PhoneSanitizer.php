<?php

namespace App\Sanitizers;
use function preg_replace;

class PhoneSanitizer
{
    public static function sanitize(?string $value) : ?string
    {
        if ($value === null) {
            return null;
        }
        return '7' . substr(preg_replace('/\D+/', '', $value), 1);
    }
}

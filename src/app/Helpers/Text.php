<?php
namespace App\Helpers;

class Text
{
    public static function purify(string $text): string
    {
        $purifier = new \HTMLPurifier();

        return $purifier->purify($text);
    }
}

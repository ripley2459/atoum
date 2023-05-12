<?php

class RString
{
    public const EMPTY = '';
    public const SPACE = ' ';

    /**
     * Join des chaînes de caractères avec la chaînes de caractère donnée.
     * @param string $separator
     * @param array $strings
     * @return string
     */
    public static function join(string $separator, array $strings): string
    {
        if (count($strings) <= 0) {
            return RString::EMPTY;
        }

        $joined = $strings[0];

        for ($i = 1; $i < count($strings); $i++) {
            $joined .= $separator;
            $joined .= $strings[$i];
        }

        return $joined;
    }

    /**
     * @param string $main
     * @param string $separator
     * @param string $string
     * @return void
     */
    public static function concat(string &$main, string $separator, string $string): void
    {
        if (self::nullOrEmpty($main)) {
            $main = $string;
            return;
        }

        $main .= $separator . $string;
    }

    /**
     * @param string $string
     * @return bool
     */
    public static function nullOrEmpty(string $string): bool
    {
        return $string === null || trim($string) === self::EMPTY;
    }
}
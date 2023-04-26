<?php

class RString
{
    public const EMPTY = '';

    /**
     * Join des chaînes de caractères avec la chaînes de caractère donnée.
     * @param string $separator
     * @param array $string
     * @return string
     */
    public static function join(string $separator, array $string): string
    {
        if (count($string) <= 0) {
            return RString::EMPTY;
        }

        $joined = $string[0];

        for ($i = 1; $i < count($string); $i++) {
            $joined .= $separator;
            $joined .= $string[$i];
        }

        return $joined;
    }
}
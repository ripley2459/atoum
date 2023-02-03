<?php

/**
 * Donne quelque chose comme "a  B c @$  aBc" -> "a_B_c_@$_aBc".
 * @param string $string
 * @return string
 */
function lightNormalize(string $string): string
{
    return preg_replace('/\s+/', '_', $string);
}

/**
 * Donne quelque chose comme "a  B c @$  aBc" -> "a__B_c____aBc".
 * @param string $string
 * @return string
 */
function normalize(string $string): string
{
    return strtolower(preg_replace('/[^a-zA-Z0-9-_\.]/', '_', $string));
}

/**
 * @param string $string
 * @return bool
 */
function nullOrEmpty(string $string): bool
{
    return ($string === null || trim($string) === '');
}


/**
 * Vérifie si une valeur est dans un ensemble. Si oui, retourne cette valeur, sinon, crée une erreur.
 * @param $value
 * @param array $allowed
 * @return mixed La valeur indiquée si autorisée
 */
function whitelist($value, array $allowed): mixed
{
    $key = in_array($value, $allowed, true);

    if ($key === false) {
        throw new InvalidArgumentException('This value is not allowed here.');
    } else {
        return $value;
    }
}


/**
 * @param string $input
 * @return string ASC ou DESC. ASC par défaut.
 */
function switchOrderDirection(string $input): string
{
    if (!isset($input)) return 'ASC';

    return str_contains($input, 'ASC') ? 'DESC' : 'ASC';
}

/**
 * Analyse un chemin et renvoie les fichiers en omettant "." et "..";
 * @param $path
 * @return array
 */
function normalizedScan($path): array
{
    return array_diff(scandir($path), ['.', '..']);
}


/**
 * Affiche un block.
 * @param string $block
 * @return string
 */
function block(string $block): string
{
    $path = BLOCKS . $block . '.php';
    if (is_file($path)) {
        ob_start();
        include $path;
        return ob_get_clean();
    }
    return false;
}
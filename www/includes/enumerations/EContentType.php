<?php

enum EContentType: int
{
    case MOVIE = 0;
    case IMAGE = 1;
    case GALLERY = 2;
    case PLAYLIST = 3;
    case POST = 4;
    case PAGE = 5;
    case COMMENT = 6;

    public static function fromInt(int $int): EContentType
    {
        return EContentType::from($int);
    }

    public static function fromMime(string $mime): EContentType
    {
        return match ($mime) {
            'image/giff', 'image/jpeg', 'image/png' => EContentType::IMAGE,
            'video/mp4', 'video/ogg' => EContentType::MOVIE
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}

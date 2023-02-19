<?php

enum EDataType: int
{
    case TAG = 0;
    case MOVIE = 1;
    case PLAYLIST = 2;
    case IMAGE = 3;
    case GALLERY = 4;
    case COMMENT = 5;
    case POST = 6;
    case PAGE = 7;
    case USER = 8;

    public static function fromInt(int $int): EDataType
    {
        return EDataType::from($int);
    }

    public static function fromMime(string $mime): EDataType
    {
        return match ($mime) {
            'image/giff', 'image/jpeg', 'image/png' => EDataType::IMAGE,
            'video/mp4', 'video/ogg' => EDataType::MOVIE
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}

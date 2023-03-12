<?php

enum EDataType: int
{
    case VIDEO = 0;
    case IMAGE = 1;
    case GALLERY = 2;
    case PLAYLIST = 3;
    case POST = 4;
    case PAGE = 5;
    case COMMENT = 6;
    case TAG = 7;
    case USER = 8;

    public static function fromInt(int $int): EDataType
    {
        return EDataType::from($int);
    }

    public static function fromMime(string $mime): EDataType
    {
        return match ($mime) {
            'image/giff', 'image/jpeg', 'image/png' => EDataType::IMAGE,
            'video/mp4', 'video/ogg' => EDataType::VIDEO
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}

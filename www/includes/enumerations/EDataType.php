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
    case ACTOR = 8;
    case USER = 9;

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

    public static function fromName(string $value): EDataType
    {
        foreach (EDataType::cases() as $v) {
            if ($value === strtolower($v->name)) {
                return $v;
            }
        }

        throw new Exception('Can\'t get the EDataType of this type');
    }

    public static function names(): array
    {
        return array_column(self::cases(), 'name');
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}

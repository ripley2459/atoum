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
    case MENU = 10;

    public static function names(): array
    {
        return array_column(self::cases(), 'name');
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Converts a MIME type to an EDataType enumeration.
     * Supported image MIME types include 'image/gif', 'image/jpeg', and 'image/png', mapping to EDataType::IMAGE.
     * Supported video MIME types include 'video/mp4' and 'video/ogg', mapping to EDataType::VIDEO.
     * @param mixed $mime The MIME type to convert to EDataType.
     * @return EDataType The corresponding EDataType based on the provided MIME type.
     */
    public static function fromMime(mixed $mime): EDataType
    {
        return match ($mime) {
            'image/giff', 'image/jpeg', 'image/png' => EDataType::IMAGE,
            'video/mp4', 'video/ogg' => EDataType::VIDEO
        };
    }

    /**
     * @throws Exception
     */
    public static function fromName(string $value): EDataType
    {
        foreach (EDataType::cases() as $v) {
            if ($value === strtolower($v->name))
                return $v;
        }

        throw new Exception('Can\'t get the EDataType of this type: ' . $value);
    }
}

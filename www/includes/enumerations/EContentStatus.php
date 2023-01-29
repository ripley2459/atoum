<?php

enum EContentStatus: int
{
    case PUBLISHED = 0;
    case HIDDEN = 1;
    case ARCHIVED = 2;
    case DELETED = 3;

    public static function fromInt(int $value): EContentStatus
    {
        return EContentStatus::from($value);
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}

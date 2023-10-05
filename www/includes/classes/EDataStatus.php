<?php

enum EDataStatus: int
{
    case PUBLISHED = 0;
    case HIDDEN = 1;
    case ARCHIVED = 2;
    case DELETED = 3;

    /**
     * @throws Exception
     */
    public static function fromName(string $value): EDataType
    {
        foreach (EDataType::cases() as $v) {
            if ($value === strtolower($v->name)) return $v;
        }

        throw new Exception('Can\'t get the EDataStatus of this type');
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

<?php

class FileHandler
{
    public const SEPARATOR = '/';
    public const DATE_FORMAT = 'Y/m/d';
    public const ALLOWED_TYPES = ['image/giff', 'image/gif', 'image/jpeg', 'image/png', 'video/mp4', 'video/ogg'];

    /**
     * Checks if a directory exists, and if not, creates it along with any necessary parent directories.
     * @param string $directory The directory path to check or create.
     * @return void
     */
    public static function checkPath(string $directory): void
    {
        if (!is_dir($directory))
            mkdir($directory, 0777, true);
    }

    public static function getURL(Content $file): string
    {
        return R::concat(self::SEPARATOR, URL, 'public', 'content/uploads', $file->getDateCreated()->format(self::DATE_FORMAT), $file->getSlug());
    }

    public static function getPath(Content $file): string
    {
        return R::concat(self::SEPARATOR, path_CONTENT, 'uploads', $file->getDateCreated()->format(self::DATE_FORMAT), $file->getSlug());
    }

    /**
     * @return string Something like public/uploads/2024/01/01/
     */
    public static function getDefaultPath(): string
    {
        return path_CONTENT . 'uploads' . self::SEPARATOR . date(self::DATE_FORMAT) . self::SEPARATOR;
    }
}
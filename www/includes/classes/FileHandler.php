<?php

class FileHandler
{
    const DATE_FORMAT = 'Y/m/d';
    const ALLOWED_TYPES = ['image/giff', 'image/gif', 'image/jpeg', 'image/png', 'video/mp4', 'video/ogg'];

    /**
     * Checks if the default directory exists, and if not, creates it.
     * @return void
     */
    public static function checkDefaultPath(): void
    {
        self::checkPath(self::getPath());
    }

    /**
     * Checks if a directory exists, and if not, creates it along with any necessary parent directories.
     * @param string $directory The directory path to check or create.
     * @return void
     */
    public static function checkPath(string $directory): void
    {
        if (!is_dir($directory)) mkdir($directory, 0777, true);
    }

    /**
     * Donne le chemin du fichier fourni, sinon le chemin par défaut du dossier d'envois.
     * @param IFile|null $file
     * @return string
     */
    public static function getPath(IFile $file = null): string
    {
        return $file ? $file->getUploadedDate()->format(self::DATE_FORMAT) . '/' . $file->getUploadName() : UPLOADS . self::getDate() . '/';
    }

    /**
     * Gets the current date as a formatted string.
     * @return string The current date in the specified format.
     */
    private static function getDate(): string
    {
        return date(self::DATE_FORMAT);
    }

    /**
     * Donne l'url du fichier fourni, sinon l'url par défaut du dossier d'envois.
     * @param IFile|null $file
     * @return string
     */
    public static function getUrl(IFile $file = null): string
    {
        return $file ? $file->getUploadedDate()->format(self::DATE_FORMAT) . '/' : UPLOADS_URL . self::getDate() . '/';
    }

    /**
     * Ajoute x à la fin d'une chaine de caractères.
     * Donne quelque chose comme "nom_du_fichier_2"
     * @param string $fileName Le nom du fichier auquel sera éventuellement ajouté un nombre
     * @param string $where L'emplacement où va se trouver le fichier (avec le "/" à la fin)
     * @return string Le nom final du fichier
     */
    public static function getNextFreeName(string $fileName, string $where, int $iteration = 0): string
    {
        $infos = pathinfo($where . $fileName);
        $ext = $infos['extension'];
        $name = $infos['filename'];
        $tryName = $iteration == 0 ? $fileName : $name . '_' . $iteration . '.' . $ext;

        if (file_exists($where . $tryName)) return self::getNextFreeName($tryName, $where, $iteration + 1);

        return $tryName;
    }

    public static function createPath(string $file): string
    {
        return self::getPath() . R::sanitize($file);
    }

    /**
     * Delete (or rename) the file(s).
     * @param IFile $file Le fichier sur le disque à supprimer
     * @param bool $renameOnly Si vrai le fichier est renommé avec le prefix "DELETED_".
     * @return bool
     */
    public static function removeFile(IFile $file, bool $renameOnly = true): bool
    {
        $path = UPLOADS . '/' . $file->getUploadedDate()->format(self::DATE_FORMAT) . '/';
        return $renameOnly ? rename($path . $file->getUploadName(), $path . 'DELETED_' . $file->getUploadName()) : unlink(self::getPath($file));
    }
}
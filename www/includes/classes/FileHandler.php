<?php

class FileHandler
{
    const DATE_FORMAT = "Y/m/d";
    const ALLOWED_TYPES = ['image/giff', 'image/jpeg', 'image/png', 'video/mp4', 'video/ogg'];
    private static ?FileHandler $_instance = null;

    private function __construct()
    {
    }

    /**
     * Singleton.
     * @return FileHandler
     */
    public static function Instance(): FileHandler
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new FileHandler();
        }
        return self::$_instance;
    }

    /**
     * Donne l'url du fichier fourni, sinon l'url par défaut du dossier d'envois.
     * @param IFile|null $file
     * @return string
     */
    public static function getUrl(IFile $file = null): string
    {
        return $file ? $file->getUploadedDate()->format(self::DATE_FORMAT) . '/' : UPLOADS_URL . self::getDefaultPath() . '/';
    }

    /**
     * Donne la date utilisée comme chemin pour les fichiers stockés sur le serveur.
     * Donne quelque chose comme "2023/01/21"
     * @return string
     */
    private static function getDefaultPath(): string
    {
        return date(self::DATE_FORMAT);
    }

    /**
     * Télécharge les fichiers sur le serveur.
     * @param array $files
     * @return bool Vrai si et seulement tous les fichiers ont pu être envoyés sans erreurs.
     */
    public static function uploadFiles(array $files): bool
    {
        $fileAmount = count($_FILES['files']['name']);

        // Réorganise les fichiers pour être utilisables plus facilement.
        $bucket = [];
        $filesKeys = array_keys($files);
        for ($i = 0; $i < $fileAmount; $i++) {
            foreach ($filesKeys as $key) {
                $bucket[$i][$key] = $files[$key][$i];
            }
        }

        foreach ($bucket as $file) {
            if (!empty($file['tmp_name'])) {
                if (true) { // Vérifier la taille du fichier manuellement
                    if (in_array(mime_content_type($file['tmp_name']), self::ALLOWED_TYPES)) {
                        self::checkDefaultPath();
                        $path = self::getPathForFile($file['name']);
                        if (!file_exists($path)) {
                            if (move_uploaded_file($file['tmp_name'], $path)) {
                                echo EContentStatus::PUBLISHED->value;
                            }
                        }
                    }
                }
            }
        }

        return false;
    }

    /**
     * Vérifie si le chemin par défaut existe, sinon le crée.
     * @return void
     */
    public static function checkDefaultPath(): void
    {
        self::checkPath(self::getPath());
    }

    /**
     * Vérifie si le chemin donné existe, sinon le crée.
     * @param string $directory
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
        return $file ? $file->getUploadedDate()->format(self::DATE_FORMAT) . '/' : UPLOADS . self::getDefaultPath() . '/';
    }

    /**
     * Crée un chemin pour un fichier destiné à être envoyé.
     * Donne quelque chose comme "content/uploads/2023/01/16/nom_du_fichier.ext"
     * @param string $file
     * @return string
     */
    public static function getPathForFile(string $file): string
    {
        return self::getPath() . lightNormalize($file);
    }
}
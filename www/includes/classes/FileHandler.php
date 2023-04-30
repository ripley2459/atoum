<?php

class FileHandler
{
    const DATE_FORMAT = 'Y/m/d';
    const DATE_FORMAT_LONG = 'Y-m-d\TH:i';
    const ALLOWED_TYPES = ['image/giff', 'image/gif', 'image/jpeg', 'image/png', 'video/mp4', 'video/ogg'];
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
     * Télécharge les fichiers sur le serveur et les enregistre dans la base de données.
     * @param array $files
     * @return bool Vrai si et seulement tous les fichiers ont pu être envoyés sans erreurs.
     * @throws Exception Dans le cas où le type n'est pas supporté
     * @deprecated Utiliser la fonction éponyme.
     */
    public static function uploadFiles(array $files): bool
    {
        $fileAmount = count($_FILES['files']['name']);
        Logger::logInfo('Uploading ' . $fileAmount . ' file(s)');
        // Réorganise les fichiers pour être utilisables plus facilement.
        $bucket = [];
        $filesKeys = array_keys($files);
        for ($i = 0; $i < $fileAmount; $i++) {
            foreach ($filesKeys as $key) {
                $bucket[$i][$key] = $files[$key][$i];
            }
        }

        foreach ($bucket as $file) {
            Logger::logInfo('Uploading file: ' . $file['name']);
            if (!empty($file['tmp_name'])) {
                if (true) { // todo Vérifier la taille du fichier
                    $mimeType = mime_content_type($file['tmp_name']);
                    if (in_array($mimeType, self::ALLOWED_TYPES)) {
                        self::checkDefaultPath();
                        $path = self::getPathForFile($file['name']);
                        if (!file_exists($path)) {
                            if (move_uploaded_file($file['tmp_name'], $path)) {
                                $instance = AContent::createInstance(EDataType::fromMime($mimeType));
                                if ($instance->registerInstance(0,
                                    EDataType::fromMime($mimeType),
                                    EDataStatus::PUBLISHED,
                                    0,
                                    lightNormalize($file['name']),
                                    $file['name'],
                                    'null',
                                    0)
                                ) {
                                    Logger::logInfo($file['name'] . ' has been registered in the database');
                                }
                            } else {
                                unlink($file['tmp_name']);
                                Logger::logError('Can\'t move the file to its destination');
                            }
                        } else Logger::logError('A file with that name already exist');
                    } else Logger::logError('This type of file is not allowed');
                }
            } else Logger::logError('File is empty');
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
        if (!is_dir($directory)) {
            mkdir($directory, 0777, true);
        }
    }

    /**
     * Donne le chemin du fichier fourni, sinon le chemin par défaut du dossier d'envois.
     * @param IFile|null $file
     * @return string
     */
    public static function getPath(IFile $file = null): string
    {
        return $file ? $file->getUploadedDate()->format(self::DATE_FORMAT) . '/' . $file->getUploadName() : UPLOADS . self::getDefaultPath() . '/';
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

        if (file_exists($where . $tryName)) {
            return self::getNextFreeName($tryName, $where, $iteration + 1);
        }

        return $tryName;
    }
}
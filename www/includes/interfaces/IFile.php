<?php

interface IFile
{
    /**
     * Donne la date de sauvegarde de ce fichier.
     * @return DateTime
     */
    public function getUploadedDate(): DateTime;
}
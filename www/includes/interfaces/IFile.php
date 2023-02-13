<?php


/**
 * Représente un objet ayant un ou plusieurs éléments sur le disque.
 */
interface IFile
{
    /**
     * Donne la date de sauvegarde de ce fichier.
     * @return DateTime
     */
    public function getUploadedDate(): DateTime;


    /**
     * Donne une chance à la classe de supprimer ses éléments.
     * @return bool
     */
    public function deleteContent(): bool;
}
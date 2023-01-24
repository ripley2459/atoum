<?php


/**
 * Fonctions requises par la majorité des classes pouvant être chargées ou sauvegardées depuis/dans une base de données.
 */
interface IData
{
    /**
     * Enregistre cette instance dans la base de données.
     * @return bool Vrai si l'instance a été sauvegardée avec succès.
     */
    public function register(): bool;

    /**
     * Supprime cette instance de la base de données.
     * @return bool Vrai si l'instance a été supprimée avec succès.
     */
    public function unregister(): bool;

    /**
     * Sauvegarde les changements effectués sur cette instance.
     * @return bool Vrai si l'instance a été modifiée avec succès.
     */
    public function save(): bool;


    /**
     * Vérifie et crée si besoin la table associée à cette instance.
     * @return bool Vrai si la table existe ou a été créée avec succès.
     */
    public static function checkTable(): bool;
}
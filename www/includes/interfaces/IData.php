<?php

interface IData
{
    /**
     * Enregistre cette instance dans la base de données.
     * @return void
     */
    public function register(): void;

    /**
     * Supprime cette instance de la base de données.
     * @return void
     */
    public function unregister(): void;

    /**
     * Sauvegarde les changements effectués sur cette instance.
     * @return void
     */
    public function save(): void;
}
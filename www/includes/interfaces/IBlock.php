<?php

interface IBlock
{
    /**
     * Affiche le block immédiatement.
     * @return void
     */
    public function echo(): void;

    /**
     * Retourne le bloc HTML pour afficher le block.
     * @return string
     */
    public function display(): string;
}
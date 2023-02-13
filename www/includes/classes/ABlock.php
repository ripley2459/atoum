<?php

abstract class ABlock
{
    /**
     * affiche le bloc HTML pour afficher le block.
     * @param bool $echo Si le bloc doit être retourné ou afficher via echo
     * @return string
     */
    public abstract function display(bool $echo = true): string;
}
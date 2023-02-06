<?php

interface IBlockNP extends IBlock
{

    /**
     * Affiche le block immédiatement sans utiliser de classe.
     * @return void
     */
    public static function echoS(): void;
}
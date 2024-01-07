<?php

abstract class AContent extends AData
{
    /**
     * @return EDataType The data type that describes the nature of this data.
     */
    public abstract function getType(): EDataType;
}
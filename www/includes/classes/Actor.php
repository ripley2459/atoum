<?php

class Actor extends AContent
{
    /**
     * @inheritDoc
     */
    public static function getType(): EDataType
    {
        return EDataType::ACTOR;
    }

    /**
     * @inheritDoc
     */
    public function display(): string
    {
        return $this->_name;
    }
}
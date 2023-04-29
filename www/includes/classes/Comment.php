<?php

class Comment extends AContent
{
    /**
     * @inheritDoc
     */
    public static function getType(): EDataType
    {
        // TODO: Implement getType() method.
    }

    /**
     * @inheritDoc
     */
    public function display(): string
    {
        return $this->_content;
    }
}
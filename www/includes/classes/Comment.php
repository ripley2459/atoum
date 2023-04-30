<?php

class Comment extends AContent
{
    /**
     * @inheritDoc
     */
    public static function getType(): EDataType
    {
        return EDataType::COMMENT;
    }

    /**
     * @inheritDoc
     */
    public function display(): string
    {
        return $this->_content;
    }
}
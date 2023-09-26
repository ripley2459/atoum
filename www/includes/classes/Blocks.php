<?php

class Blocks
{
    public static function buttonUrlParamSet(string $text, string $param, string $value): string
    {
        return '<button onclick="' . R::createFunctionJS('toggle', $param, $value) . '">' . $text . '</button>';
    }

    public static function buttonUrlParamToggle(string $text, string $param, string $valueA, string $valueB): string
    {
        return '<button onclick="' . R::createFunctionJS('toggleBetween', $param, $valueA, $valueB) . '">' . $text . '</button>';
    }

    public static function searchData(string $id, string $label, string $placeholder, EDataType $type, Content $content = null): string
    {
        $existing = R::EMPTY;
        if (isset($content)) {
            foreach (Relation::getChildren(Relation::getRelationType($type, $content->getType()), $content->getId()) as $in) {
                $existing .= self::chip($in, $id);
            }
        }

        $r = '<label for="' . $id . '">' . $label . '</label><div class="search">';
        $r .= '<div id="' . $id . '-input" class="search-input">
        ' . $existing . '
        <input class="u-full-width" type="text" placeholder="' . $placeholder . '" id="' . $id . '" onkeyup="' . R::createFunctionJS('typeaheadSearch', $id, $type->value) . '" onkeydown="' . R::createFunctionJS('typeaheadOnKey', $id) . '">
        </div>';

        $r .= '<div id="' . $id . '-result" class="search-result"></div></div>';
        return $r;
    }

    private static function chip(Content $content, string $field): string
    {
        $r = '<div id="' . strtolower($content->getSlug()) . '-input-container" class="input u-full-width">';
        $r .= '<input id="' . strtolower($content->getSlug()) . '-value" type="text" value="' . $content->getName() . '" name="' . $field . '[]" readonly>';
        $r .= '<button type="button" onclick="' . R::createFunctionJS('typeaheadRemove', strtolower($content->getSlug()) . '-input-container') . '">x</button>';
        $r .= '</div>';
        return $r;
    }

    public static function buttonSearchData(string $id, string $value): string
    {
        return '<button type="button" onclick="' . R::createFunctionJS('typeaheadAdd', $id, $value) . '">' . $value . '</button>';
    }

    public static function viewLink(Content $content): string
    {
        return match ($content->getType()) {
            EDataType::VIDEO => ' <a class="button button-primary" href="' . URL . '/index.php?page=video&id=' . $content->getId() . '">View</a> ',
            EDataType::GALLERY => ' <a class="button button-primary" href="' . URL . '/index.php?page=gallery&id=' . $content->getId() . '">View</a> ',
            default => R::EMPTY,
        };
    }

    public static function formattedDate(DateTime $dateTime): string
    {
        return $dateTime->format('d M Y H:i');
    }

    public static function accordion(string $id, string $title, string $content, string $classes = R::EMPTY): string
    {
        return '<button id="' . $id . '-button" onclick="accordion(\'' . $id . '\')" class="accordion button">' . $title . '</button><div id="' . $id . '-panel" class="accordion panel">' . $content . '</div>';
    }
}
<?php

$content = new Content(R::getParameter('data'));

$name = R::getParameter('name');
$data = [
    $content->getOwner(),
    $content->getType()->value,
    $content->getStatus(),
    R::getParameter('views'),
    $content->getDateLastViewed()->format('Y-m-d H:i:s'),
    R::concat('.', R::sanitize($name), R::pathInfo(FileHandler::getPath($content))['extension']),
    $name,
    $content->getContent(),
    $content->getParent()
];

R::checkArgument($content->update($data), 'Failed to update data!', true);

foreach (array_unique(R::getParameter('sections')) as $section) {
    $section = strtolower($section);

    try {
        $type = EDataType::fromName($section);
    } catch (Exception $e) {
        R::checkArgument(false, 'Failed to get the type of section!', true);
    }

    R::checkArgument(Relation::clear($content, $type), 'Failed to clear relations for this data!', true);

    if (!isset($_POST[$section]))
        continue;

    foreach ($_POST[$section] as $input) {
        $request = RDB::select('contents', 'id')
            ->where('name', '=', $input)
            ->where('type', '=', $type->value)
            ->execute();

        if ($request->rowCount() > 0)
            $data = new Content($request->fetch()['id']);
        else $data = new Content(Content::register([[0], [$type->value], [0], [R::sanitize($input)], [$input], [R::EMPTY], [0]])[0]);

        Relation::register([[Relation::getTypeFor($data->getType(), $content->getType())], [$data->getId()], [$content->getId()]]);
    }
}

echo 'Data updated!';
<?php

$field = R::getParameter('field', null, 'Can\'t search for data without a target type!');
$type = R::whitelist(intval(R::getParameter('type')), EDataType::values());
$search = R::getParameter('search', R::EMPTY);

$r = RDB::select('contents', 'id', 'type', 'name')
    ->where('type', '=', $type)
    ->where('name')
    ->contains($search);
$data = $r->execute();

while ($d = $data->fetch(PDO::FETCH_ASSOC)) { ?>
    <div class="search-result"><?= buttonSearchData($field, $d['name']) ?></div>
<?php }
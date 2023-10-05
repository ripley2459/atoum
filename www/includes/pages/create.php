<?php

require_once dirname(__DIR__, 2) . '/load.php';
R::require('create');

$type = EDataType::from($_GET['create']);
R::whitelist($type, [EDataType::GALLERY, EDataType::MENU]);

?>

<h1><?= R::concat(R::SPACE, 'Create', '-', ucfirst(strtolower($type->name))) ?></h1>
<div class="row">
    <div class="u-full-width">
        <label for="name">Name</label>
        <input type="text" placeholder="name..." name="name" id="name" <?= isset($_POST['name']) ? 'value="' . $_POST['name'] . '"' : R::EMPTY ?>>
    </div>
</div>
<button onclick="create()" class="button-primary">Create</button>

<script>
    const create = () => {
        const uploadDest = new URL('<?= URL . '/includes/functions/create.php' ?>');
        const name = document.querySelector("#name");
        const request = new XMLHttpRequest();
        const formData = new FormData();
        formData.append("name", name.value);
        formData.append("type", <?= $type->value ?>);

        request.onreadystatechange = () => {
            if (request.readyState === 4 && (request.status === 200 || request.status === 201 || request.status === 204)) {
                window.location.href = "<?= URL . '/index.php?page=uploads&data=' ?>" + parseInt(request.responseText);
            }
        };

        request.open("POST", uploadDest);
        request.send(formData);
    }
</script>
<?php

if (!Auth::isLoggedIn())
    App::redirect('home');

App::setTitle('Atoum - Create');
App::setDescription('Atoum - Create');

$type = EDataType::from(R::getParameter('data'));

R::whitelist($type, [EDataType::GALLERY, EDataType::PLAYLIST]);

?>

<div class="container settings">
    <h1>Create - <?php eDataTypeToString($type) ?></h1>
    <div class="u-space-top u-space-bot">
        <label for="name">Name</label>
        <input class="u-full-width" type="text" placeholder="name..." id="name">
    </div>
    <button onclick="create()" class="button-primary">Create</button>
    <div id="feedbacks"></div>
</div>

<script>
    const create = () => {
        const uploadDest = new URL(func("data/createData").concat("&type=").concat(<?= $type->value ?>));
        const name = document.querySelector("#name");
        const request = new XMLHttpRequest();
        const formData = new FormData();
        formData.append("name", name.value);
        formData.append("type", <?= $type->value ?>);

        request.onreadystatechange = () => {
            if (request.readyState === 4 && (request.status === 200 || request.status === 201 || request.status === 204))
                window.location.href = "<?= URL . '/index.php?page=uploads&data=' ?>" + parseInt(request.responseText);
        };

        request.open("POST", uploadDest);
        request.send(formData);
    }
</script>
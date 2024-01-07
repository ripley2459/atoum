<?php

if (!Auth::isLoggedIn())
    App::redirect('home');

$type = EDataType::from(R::getParameter('data'));

R::whitelist($type, [EDataType::GALLERY]);

?>

<div class="container">
    <h1>Create - <?= eDataTypeToString($type) ?></h1>
    <label for="name">Name</label>
    <input class="u-full-width" type="text" placeholder="name..." id="name">
    <button onclick="create()" class="button-primary">Create</button>
</div>

<div id="feedbacks"></div>

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
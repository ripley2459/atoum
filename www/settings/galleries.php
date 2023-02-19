<?php

$contentType = EDataType::GALLERY;

?>

<h1>Galleries</h1>
<div id="registerContent"></div>
<h2>Your galleries</h2>
<div class="row">
    <div class="column">
        <div id="registeredGalleries"></div>
    </div>
    <div class="column">
        <input type="text" id="imagesSearcher" onkeyup="setSearchFor(value, listImages)"/>
        <input type="range" id="imagesGridColumnsAmount" onchange="changeGridColumnsAmount('registeredImagesGrid', this.value)" value="3" min="1" max="10" step="1">
        <div id="registeredImages"></div>
    </div>
</div>

<script>
    const registerForm = document.querySelector("#registerContent");
    const registeredGalleries = document.querySelector("#registeredGalleries");
    const registeredImages = document.querySelector("#registeredImages");
    const contentModal = document.querySelector("#contentModal");

    document.addEventListener("DOMContentLoaded", function () {
        getRegisterForm();
        listGalleries();
        listImages();
    });

    const registerContent = () => {
        const request = new XMLHttpRequest();
        let from = new URL('<?= FUNCTIONS_URL . 'registerContent.php' ?>');

        from.searchParams.set("type", <?= $contentType->value ?>);
        from.searchParams.set("name", document.querySelector("#contentName").value);

        request.onreadystatechange = () => {
            if (request.readyState === 4 && request.status === 200) {
                getRegisterForm();
                listGalleries();
            }
        };

        request.open("GET", from);
        request.send();
    }

    const getRegisterForm = () => {
        const request = new XMLHttpRequest();
        let from = new URL('<?= FUNCTIONS_URL . 'getContentRegisterForm.php' ?>');

        from.searchParams.set("type", <?= $contentType->value ?>);

        request.onreadystatechange = () => {
            if (request.readyState === 4 && request.status === 200) {
                registerForm.innerHTML = request.responseText;
            }
        };

        request.open("GET", from);
        request.send();
        registerForm.innerHTML = `<?= BlockSpinner0::echo() ?>`;
    }

    const listGalleries = () => {
        const request = new XMLHttpRequest();
        let from = new URL('<?= FUNCTIONS_URL . 'getGalleries.php' ?>');

        from.searchParams.set("type", <?= $contentType->value ?>);

        request.onreadystatechange = () => {
            if (request.readyState === 4 && request.status === 200) {
                registeredGalleries.innerHTML = request.responseText;
            }
        };

        request.open("GET", from);
        request.send();
        registeredGalleries.innerHTML = `<?= BlockSpinner0::echo() ?>`;
    }

    const listImages = () => {
        const request = new XMLHttpRequest();
        const params = new URLSearchParams(new URL(document.URL).toString());
        let from = new URL('<?= FUNCTIONS_URL . 'getUploadedImages.php' ?>');

        from.searchParams.set("type", <?= EDataType::IMAGE->value ?>);
        from.searchParams.set("status", <?= EDataStatus::PUBLISHED->value ?>);
        if (params.has("orderBy")) from.searchParams.set("orderBy", params.get("orderBy"));
        if (params.has("limit")) from.searchParams.set("limit", params.get("limit"));
        if (params.has("currentPage")) from.searchParams.set("currentPage", params.get("currentPage"));
        if (params.has("searchFor")) from.searchParams.set("searchFor", params.get("searchFor"));

        request.onreadystatechange = () => {
            if (request.readyState === 4 && request.status === 200) {
                registeredImages.innerHTML = request.responseText;
            }
        };

        request.open("GET", from);
        request.send();
        registeredImages.innerHTML = `<?= BlockSpinner0::echo() ?>`;
    }
</script>
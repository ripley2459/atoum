<?php

$contentType = EDataType::GALLERY;

?>

<h1>Galleries</h1>
<div id="registerGallery"></div>
<h2>Your galleries</h2>
<div id="registeredGalleries"></div>

<script>
    const registerForm = document.querySelector("#registerGallery");
    const registeredGalleries = document.querySelector("#registeredGalleries");
    const contentModal = document.querySelector("#contentModal");

    document.addEventListener("DOMContentLoaded", function () {
        getRegisterForm();
        getGalleries();
    });

    const registerContent = () => {
        const request = new XMLHttpRequest();
        let from = new URL('<?= FUNCTIONS_URL . 'uploads/registerContent.php' ?>');

        from.searchParams.set("type", <?= $contentType->value ?>);
        from.searchParams.set("name", document.querySelector("#contentName").value);

        request.onreadystatechange = () => {
            if (request.readyState === 4 && request.status === 200) {
                getRegisterForm();
                getGalleries();
            }
        };

        request.open("GET", from);
        request.send();
    }

    const getRegisterForm = () => {
        const request = new XMLHttpRequest();
        let from = new URL('<?= FUNCTIONS_URL . 'uploads/getRegisterForm.php' ?>');

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

    const getGalleries = () => {
        const request = new XMLHttpRequest();
        let from = new URL('<?= FUNCTIONS_URL . 'galleries/getGalleries.php' ?>');

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
</script>
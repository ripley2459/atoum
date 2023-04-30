<?php

$contentType = EDataType::ACTOR;

?>

<h1>Actors</h1>
<div id="registerActor"></div>
<h2>Your actors</h2>
<div id="registeredActors"></div>
<div id="contentModal"></div>

<script>
    const registerForm = document.querySelector("#registerActor");
    const registeredActors = document.querySelector("#registeredActors");
    const contentModal = document.querySelector("#contentModal");

    document.addEventListener("DOMContentLoaded", function () {
        getRegisterForm();
        getActors();
    });

    const registerContent = () => {
        const request = new XMLHttpRequest();
        let from = new URL('<?= FUNCTIONS_URL . 'uploads/registerContent.php' ?>');

        from.searchParams.set("type", <?= $contentType->value ?>);
        from.searchParams.set("name", document.querySelector("#contentName").value);

        request.onreadystatechange = () => {
            if (request.readyState === 4 && request.status === 200) {
                getRegisterForm();
                getActors();
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

    const getActors = () => {
        const request = new XMLHttpRequest();
        let from = new URL('<?= FUNCTIONS_URL . 'actors/getActors.php' ?>');

        from.searchParams.set("type", <?= $contentType->value ?>);

        request.onreadystatechange = () => {
            if (request.readyState === 4 && request.status === 200) {
                registeredActors.innerHTML = request.responseText;
            }
        };

        request.open("GET", from);
        request.send();
        registeredActors.innerHTML = `<?= BlockSpinner0::echo() ?>`;
    }

    const openContentModal = (contentId) => {
        const request = new XMLHttpRequest();
        let from = new URL('<?= FUNCTIONS_URL . 'uploads/openContentModal.php' ?>');

        from.searchParams.set("contentId", contentId);

        request.onreadystatechange = () => {
            if (request.readyState === 4 && request.status === 200) {
                contentModal.innerHTML = request.responseText;
                toggleModal("contentModal".concat(contentId));
            }
        };

        request.open("GET", from);
        request.send();
    }
</script>
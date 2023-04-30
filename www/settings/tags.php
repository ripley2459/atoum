<?php

$contentType = EDataType::TAG;

?>

<h1>Tags</h1>
<div id="registerTag"></div>
<h2>Your tags</h2>
<div id="registeredTags"></div>
<div id="contentModal"></div>

<script>
    const registerForm = document.querySelector("#registerTag");
    const registeredTags = document.querySelector("#registeredTags");
    const contentModal = document.querySelector("#contentModal");

    document.addEventListener("DOMContentLoaded", function () {
        getRegisterForm();
        getTags();
    });

    const registerContent = () => {
        const request = new XMLHttpRequest();
        let from = new URL('<?= FUNCTIONS_URL . 'uploads/registerContent.php' ?>');

        from.searchParams.set("type", <?= $contentType->value ?>);
        from.searchParams.set("name", document.querySelector("#contentName").value);

        request.onreadystatechange = () => {
            if (request.readyState === 4 && request.status === 200) {
                getRegisterForm();
                getTags();
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

    const getTags = () => {
        const request = new XMLHttpRequest();
        let from = new URL('<?= FUNCTIONS_URL . 'tags/getTags.php' ?>');

        from.searchParams.set("type", <?= $contentType->value ?>);

        request.onreadystatechange = () => {
            if (request.readyState === 4 && request.status === 200) {
                registeredTags.innerHTML = request.responseText;
            }
        };

        request.open("GET", from);
        request.send();
        registeredTags.innerHTML = `<?= BlockSpinner0::echo() ?>`;
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
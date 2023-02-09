<?php

$contentType = EContentType::GALLERY;

?>

<h1>Galleries</h1>
<div id="registerContent"></div>
<div id="registeredContent"></div>

<script>
    const registerForm = document.querySelector("#registerContent");
    const registeredContent = document.querySelector("#registeredContent");
    const contentModal = document.querySelector("#contentModal");

    document.addEventListener("DOMContentLoaded", function () {
        getRegisterForm();
        listContent();
    });

    const registerContent = () => {
        const request = new XMLHttpRequest();
        let from = new URL('<?= FUNCTIONS_URL . 'registerContent.php' ?>');

        from.searchParams.set("type", <?= $contentType->value ?>);
        from.searchParams.set("name", document.querySelector("#contentName").value);

        request.onreadystatechange = () => {
            if (request.readyState === 4 && request.status === 200) {
                getRegisterForm();
                listContent();
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
        registerForm.innerHTML = `<?= BlockSpinner0::echoS() ?>`;
    }

    const listContent = () => {
        const request = new XMLHttpRequest();
        let from = new URL('<?= FUNCTIONS_URL . 'getUploadedFiles.php' ?>');

        from.searchParams.set("type", <?= $contentType->value ?>);

        request.onreadystatechange = () => {
            if (request.readyState === 4 && request.status === 200) {
                registeredContent.innerHTML = request.responseText;
            }
        };

        request.open("GET", from);
        request.send();
        registeredContent.innerHTML = `<?= BlockSpinner0::echoS() ?>`;
    }
</script>
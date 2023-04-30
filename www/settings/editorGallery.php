<?php

if (!isset($_GET['gallery'])) {
    header('Location: ' . URL . '/settings/index.php?page=galleries');
    die();
}

$gallery = new Gallery($_GET['gallery']);

$settings = new BlockSettings($gallery->getType(), $gallery->getId(), 'galleryRelations');

$settings->nameSection();
$settings->dateCreated();
$settings->dateModified();
$settings->liveSection('Add actors', EDataType::ACTOR);
$settings->liveSection('Add tags', EDataType::TAG);

?>

<h1><?= $gallery->getName() ?></h1>
<a href="<?= URL ?>/index.php?page=viewGallery&gallery=<?= $gallery->getId() ?>" target="_blank">View</a>
<?= $settings->display() ?>
<div class="row">
    <div class="column">
        <h2>Linked images</h2>
        <div id="linkedImages"></div>
    </div>
    <div class="column">
        <input type="text" id="filesSearcher" onkeyup="setURLParam('searchFor', value, getImages)"/>
        <h2>Your images</h2>
        <div id="registeredImages"></div>
    </div>
</div>

<script>
    const linkedImages = document.querySelector("#linkedImages");
    const registeredImages = document.querySelector("#registeredImages");

    document.addEventListener("DOMContentLoaded", function () {
        getImages();
        getLinkedImages();
    });

    const getImages = () => {
        const request = new XMLHttpRequest();
        const params = new URLSearchParams(new URL(document.URL).toString());
        let from = new URL('<?= FUNCTIONS_URL . 'galleries/getImages.php' ?>');

        bindPagination(params, from);
        from.searchParams.set("gallery", <?= $gallery->getId() ?>);
        from.searchParams.set("type", <?= EDataType::IMAGE->value ?>);
        from.searchParams.set("status", <?= EDataStatus::PUBLISHED->value ?>);

        request.onreadystatechange = () => {
            if (request.readyState === 4 && request.status === 200) {
                registeredImages.innerHTML = request.responseText;
            }
        };

        request.open("GET", from);
        request.send();
        registeredImages.innerHTML = `<?= BlockSpinner0::echo() ?>`;
    }

    const getLinkedImages = () => {
        const request = new XMLHttpRequest();
        const params = new URLSearchParams(new URL(document.URL).toString());
        let from = new URL('<?= FUNCTIONS_URL . 'galleries/getLinkedImages.php' ?>');

        bindPagination(params, from);
        from.searchParams.set("gallery", <?= $gallery->getId() ?>);
        from.searchParams.set("type", <?= EDataType::IMAGE->value ?>);
        from.searchParams.set("status", <?= EDataStatus::PUBLISHED->value ?>);

        request.onreadystatechange = () => {
            if (request.readyState === 4 && request.status === 200) {
                linkedImages.innerHTML = request.responseText;
            }
        };

        request.open("GET", from);
        request.send();
        linkedImages.innerHTML = `<?= BlockSpinner0::echo() ?>`;
    }

    let draggedImageId;
    const bindImage = (event, imageId) => {
        event.dataTransfer.setData("text", event.target.id);
        draggedImageId = imageId;
    }

    const addToGallery = (event, galleryId) => {
        event.preventDefault();
        let data = event.dataTransfer.getData("text");
        event.target.appendChild(document.getElementById(data));

        const request = new XMLHttpRequest();
        let from = new URL('<?= FUNCTIONS_URL . 'relations/createRelation.php' ?>');

        from.searchParams.set("childId", draggedImageId);
        from.searchParams.set("parentId", galleryId);
        from.searchParams.set("childType", <?= EDataType::IMAGE->value ?>);
        from.searchParams.set("parentType", <?= EDataType::GALLERY->value ?>);

        request.onreadystatechange = () => {
            if (request.readyState === 4 && request.status === 200) {
                // TODO
            }
        };

        request.open("GET", from);
        request.send();
    }

    const removeFromGallery = (event, galleryId) => {
        event.preventDefault();
        let data = event.dataTransfer.getData("text");
        event.target.appendChild(document.getElementById(data));

        const request = new XMLHttpRequest();
        let from = new URL('<?= FUNCTIONS_URL . 'relations/deleteRelation.php' ?>');

        from.searchParams.set("childId", draggedImageId);
        from.searchParams.set("parentId", galleryId);
        from.searchParams.set("childType", <?= EDataType::IMAGE->value ?>);
        from.searchParams.set("parentType", <?= EDataType::GALLERY->value ?>);

        request.onreadystatechange = () => {
            if (request.readyState === 4 && request.status === 200) {
                // TODO
            }
        };

        request.open("GET", from);
        request.send();
    }
</script>
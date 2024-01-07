<?php if (!Auth::isLoggedIn())
    App::redirect('home');

$content = new Content(R::getParameter('data')); ?>

<div class="container">

    <h1>Edit - <?php eDataTypeToString($content->getType()) ?></h1>

    <form id="editData" onsubmit="event.preventDefault();" onkeydown="return event.key !== 'Enter';">
        <div class="row">
            <div class="twelve columns">
                <label for="name">Name</label>
                <input class="u-full-width" type="text" placeholder="<?= $content->getName() ?>" value="<?= $content->getName() ?>" id="name" name="name">
            </div>
        </div>

        <div class="row">
            <div class="six columns">
                <label for="dateCreated">Upload date</label>
                <input class="u-full-width" type="datetime-local" value="<?= $content->getDateCreated()->format('Y-m-d\TH:i') ?>" id="dateCreated" name="dateCreated" readonly>
            </div>
            <div class="six columns">
                <label for="views">Views</label>
                <input class="u-full-width" type="number" id="views" name="views" min="0" value="<?= $content->getViews() ?>">
            </div>
        </div>

        <div class="row">
            <div class="six columns">
                <?php typeahead('actor', 'Actors', 'actors...', EDataType::ACTOR, $content) ?>
            </div>
            <div class="six columns">
                <?php typeahead('tag', 'Tags', 'tag...', EDataType::TAG, $content) ?>
            </div>
        </div>
        <div class="row">
            <button onclick="editData()">Apply</button>
            <?php if ($content->getType() == EDataType::VIDEO) { ?>
                <button onclick="setPreview()">Set preview</button>
                <a class="button button-primary" href="<?= App::getLink('video', 'video=' . $content->getId()) ?>">View</a>
                <canvas id="<?= $content->getSlug() ?>-canvas" class="thumbnail-canvas"></canvas>
            <?php } ?>
            <?php if ($content->getType() == EDataType::GALLERY) { ?>
                <a class="button button-primary" href="<?= App::getLink('gallery', 'gallery=' . $content->getId()) ?>">View</a>
            <?php } ?>
            <button class="u-pull-right" onclick="deleteData()">Delete</button>
        </div>
    </form>

    <?php if ($content->getType() == EDataType::IMAGE)
        image($content);

    if ($content->getType() == EDataType::VIDEO)
        videoPlayer($content);

    if ($content->getType() == EDataType::GALLERY) { ?>
        <button id="bind-images" class="collapse" onclick="toggleCollapse(this)">Bind images</button>
        <div id="bind-images-data" class="collapse-content">
            <div id="dataSearchForm">
                <div class="six columns">
                    <h3>Linked images</h3>
                    <div id="linkedImages" class="grid" style="column-count: 4"></div>
                </div>
                <div class="six columns">
                    <h3>Registered images</h3>
                    <div class="row">
                        <div class="twelve columns">
                            <label for="search">Search</label>
                            <input type="text" name="search" id="search" class="u-full-width" placeholder="search for..." onkeyup="setParam('search', value)">
                        </div>
                    </div>

                    <div class="row">
                        <div class="six columns">
                            <?php typeahead('actor-filter', 'With actors', 'actors...', EDataType::ACTOR) ?>
                        </div>

                        <div class="six columns">
                            <?php typeahead('tag-filter', 'With tags', 'tags...', EDataType::TAG) ?>
                        </div>
                    </div>

                    <?php pagination(false) ?>

                    <row class="u-full-width">
                        <button onclick="toggleBetweenParams('orderBy', 'name_ASC', 'name_DESC')" name="orderBy" id="orderBy-name">Name</button>
                        <button onclick="toggleBetweenParams('orderBy', 'dateCreated_ASC', 'dateCreated_DESC')" name="orderBy" id="orderBy-dateCreated">Date Created</button>
                    </row>

                    <div id="registeredImages" class="grid" style="column-count: 4"></div>

                </div>
            </div>
        </div>
    <?php } ?>
</div>

<script>
    <?php if ($content->getType() == EDataType::GALLERY) { ?>
    const SEARCH_PARAMS = ["displayMode", "type", "status", "orderBy", "limit", "offset", "search", "actors", "tags"];

    const getImagesNonLinked = () => {
        const destination = new URL(func("gallery/getImagesNonLinked").concat("&data=").concat(<?= $content->getId() ?>));
        const actual = new URLSearchParams(window.location.search);
        for (let x of SEARCH_PARAMS) {
            if (actual.has(x) && actual.get(x))
                destination.searchParams.set(x, actual.get(x));
        }

        putFrom(destination, "registeredImages");
        updatePagination();
    }

    const getImagesLinked = () => {
        const destination = new URL(func("gallery/getImagesLinked").concat("&data=").concat(<?= $content->getId() ?>));
        putFrom(destination, "linkedImages");
    }

    const linkImage = (button, imageId) => {
        createRelation(imageId, new URL(func('relation/createRelation')));
        button.onclick = () => unlinkImage(button, imageId);
        const linkedImages = document.querySelector("#linkedImages");
        const registeredImages = document.querySelector("#registeredImages");
        linkedImages.appendChild(button);
        registeredImages.removeChild(button);
    }

    const unlinkImage = (button, imageId) => {
        createRelation(imageId, new URL(func('relation/deleteRelation')));
        button.onclick = () => linkImage(button, imageId);
        const linkedImages = document.querySelector("#linkedImages");
        const registeredImages = document.querySelector("#registeredImages");
        registeredImages.appendChild(button);
        linkedImages.removeChild(button);
    }

    function createRelation(child, destination) {
        const request = new XMLHttpRequest();
        destination.searchParams.set("child", child);
        destination.searchParams.set("parent", <?= $content->getId() ?>);

        request.onreadystatechange = () => {
            if (request.readyState === 4 && request.status === 200)
                document.getElementById("notifications").innerHTML = request.responseText;
        }

        request.open("GET", destination);
        request.send();
    }

    document.addEventListener("DOMContentLoaded", getImagesLinked);
    document.addEventListener("DOMContentLoaded", getImagesNonLinked);
    ATOUM_EVENTS.addEventListener("onURLModified", getImagesNonLinked);
    <?php } ?>

    const deleteData = () => {
        if (confirm("Do you really want to delete this data?") === true) {
            const destination = func("data/deleteData").concat("&data=").concat(<?= $content->getId() ?>);
            sendRequest(destination, (request) => {
                if (request.responseText === "")
                    window.location.href = "<?= App::getLink('uploads') ?>";
                else document.getElementById("notifications").innerHTML = request.responseText;
            });
        }
    }

    const editData = () => {
        const destination = new URL(func("data/editData").concat("&data=").concat(<?= $content->getId() ?>));
        const formData = new FormData(document.querySelector("#editData"));
        const request = new XMLHttpRequest();

        formData.append("sections[]", 'actor');
        formData.append("sections[]", 'tag');

        request.onreadystatechange = () => {
            if (request.readyState === 4 && request.status === 200)
                document.getElementById("notifications").innerHTML = request.responseText;
        }

        request.open("POST", destination);
        request.send(formData);
    }

    <?php if ($content->getType() == EDataType::VIDEO) { ?>
    // Temporary function before implementing a real form to allow the user to download one or more previews
    function setPreview() {
        const video = document.getElementById('<?= $content->getSlug() ?>');
        const canvas = document.getElementById('<?= $content->getSlug() ?>'.concat("-canvas"));

        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        canvas.getContext("2d").drawImage(video, 0, 0, video.videoWidth, video.videoHeight);

        const url = new URL(func("data/setPreview&data=").concat(<?= $content->getId() ?>));
        const formData = new FormData();
        const request = new XMLHttpRequest();

        request.onreadystatechange = () => {
            if (request.readyState === 4 && request.status === 200)
                document.getElementById("notifications").innerHTML = request.responseText;
        }

        formData.set("id", <?= $content->getId() ?>);
        formData.set("image", canvas.toDataURL('image/png', 1));
        request.open("POST", url);
        request.send(formData);
    }
    <?php } ?>
</script>

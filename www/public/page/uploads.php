<?php

if (!Auth::isLoggedIn())
    App::redirect('home');

App::setTitle('Atoum - Uploads');
App::setDescription('Atoum - Uploads');

/*
<div id="side-menu">
    <button onclick="setParam('type', <?= EDataType::VIDEO->value ?>)" name="type" id="type-<?= EDataType::VIDEO->value ?>"><?= EDataType::VIDEO->name ?></button>
<button onclick="setParam('type', <?= EDataType::GALLERY->value ?>)" name="type" id="type-<?= EDataType::GALLERY->value ?>"><?= EDataType::GALLERY->name ?></button>
<button onclick="setParam('type', <?= EDataType::ACTOR->value ?>)" name="type" id="type-<?= EDataType::ACTOR->value ?>"><?= EDataType::ACTOR->name ?></button>
<button onclick="setParam('type', <?= EDataType::IMAGE->value ?>)" name="type" id="type-<?= EDataType::IMAGE->value ?>"><?= EDataType::IMAGE->name ?></button>
</div>
*/
?>

<div class="container settings">

    <h1>Uploads</h1>

    <div class="row u-padd-top">
        <div id="dataUploadForm" class="six columns">
            <label for="filesUploader">Upload</label>
            <input type="file" id="filesUploader" multiple required/>
            <button class="light" onclick="uploadData()">Upload!</button>
        </div>
        <div class="six columns">
            <label>Create</label>
            <a href="<?= App::getLink('create', 'data=' . EDataType::PLAYLIST->value) ?>" class="button light">Playlist</a>
            <a href="<?= App::getLink('create', 'data=' . EDataType::GALLERY->value) ?>" class="button light">Gallery</a>
        </div>
    </div>

    <div id="uploadsData" class="u-full-width"></div>

    <div id="dataSearchForm">

        <div class="row u-padd-top">
            <div class="twelve columns">
                <label for="search">Search</label>
                <input type="text" name="search" id="search" class="u-full-width" placeholder="search for..." onkeyup="setParam('search', value)">
            </div>
        </div>

        <div class="row u-padd-top">
            <div class="four columns">
                <?php typeahead('actor-filter', 'With actors', 'actors...', EDataType::ACTOR) ?>
            </div>

            <div class="four columns">
                <?php typeahead('tag-filter', 'With tags', 'tags...', EDataType::TAG) ?>
            </div>

            <div class="four columns">
                <label for="type">Type</label>
                <select name="type" id="type" class="u-full-width" onchange="toggleParam('type', value)">
                    <option value="" selected="selected">All</option>
                    <?php foreach (EDataType::cases() as $type) { ?>
                        <option <?php if ($type->value == R::getParameter('type', -1)) echo 'selected ' ?> value="<?= $type->value ?>"><?= ucfirst(strtolower($type->name)) ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <?php pagination(true) ?>

    </div>

    <table>
        <thead>
        <tr>
            <th>
                <button class="light" onclick="toggleBetweenParams('orderBy', 'name_ASC', 'name_DESC')" name="orderBy" id="orderBy-name">Name</button>
            </th>
            <th>
                <button class="light" onclick="toggleBetweenParams('orderBy', 'type_ASC', 'type_DESC')" name="orderBy" id="orderBy-type">Type</button>
            </th>
            <th>
                <button class="light" onclick="toggleBetweenParams('orderBy', 'dateCreated_ASC', 'dateCreated_DESC')" name="orderBy" id="orderBy-dateCreated">Date Created</button>
            </th>
            <th>Actions</th>
        </tr>
        </thead>

        <tbody id="feedbacks"></tbody>
    </table>

</div>

<script>

    const SEARCH_PARAMS = ["displayMode", "type", "status", "orderBy", "limit", "offset", "search", "actors", "tags"];

    const getUploads = () => {
        const destination = new URL(func("data/getData"));
        const actual = new URLSearchParams(window.location.search);
        for (let x of SEARCH_PARAMS) {
            if (actual.has(x) && actual.get(x))
                destination.searchParams.set(x, actual.get(x));
        }

        putFrom(destination, "feedbacks");
        updatePagination();
    }

    const filesUploader = document.querySelector("#filesUploader");
    const filesUploadInfos = document.querySelector("#uploadsData");
    const uploadDest = new URL(func("data/uploadData"));
    const fragSize = 1048576;
    let files;
    let file;
    let fileIndex;
    let fileSize;
    let fragAmount;
    let frag, start, end;
    let progress, totalProgress, totalMaxProgress;

    function uploadData() {
        files = filesUploader.files;
        fileIndex = 0;
        totalProgress = totalMaxProgress = 0;

        Array.from(files).forEach(f => {
            totalMaxProgress += Math.max(Math.ceil(f.size / fragSize), 1);
            let id = f.name.replace(/\s+/g, '_').toLowerCase().concat("-progress");
            filesUploadInfos.appendChild(createProgressBar(id, f.name, 100));
        })

        let totalProgressPercent = document.createElement("p");
        totalProgressPercent.id = "total-progress-percent";
        totalProgressPercent.value = "0%";
        let totalBar = createProgressBar("total-progress", "Total", totalMaxProgress);
        totalBar.appendChild(totalProgressPercent);

        filesUploadInfos.insertBefore(totalBar, filesUploadInfos.firstChild);

        upload();
    }

    function upload() {
        file = files[fileIndex];
        fileSize = file.size;
        frag = 1;
        fragAmount = Math.max(Math.ceil(fileSize / fragSize), 1);
        start = 0;
        end = Math.min(fileSize, fragSize);
        progress = 0;
        uploadFrag();
    }

    function uploadFrag() {
        const request = new XMLHttpRequest();
        const formData = new FormData();
        let chunk = file.slice(start, end);

        if (frag === 1)
            formData.append("newFile", "true");
        formData.append("file", chunk);
        formData.append("fileName", file.name);
        formData.append("fragAmount", fragAmount);
        formData.append("fragIndex", frag);

        request.onreadystatechange = () => {
            if (request.readyState === 4 && (request.status === 200 || request.status === 201 || request.status === 204)) {
                progress++;
                totalProgress++;

                let id = file.name.replace(/\s+/g, '_').toLowerCase().concat("-progress");
                document.getElementById(id).value = progress;
                document.getElementById(id).max = fragAmount;
                document.getElementById("total-progress").value = totalProgress;
                document.getElementById("total-progress").max = totalMaxProgress;
                document.getElementById("total-progress-percent").innerHTML = Math.trunc((totalProgress / totalMaxProgress * 100)) + "%";

                if (frag < fragAmount) {
                    start = end;
                    end = Math.min(fileSize, start + fragSize);
                    frag++;
                    uploadFrag();
                } else {
                    fileIndex++;
                    if (fileIndex >= files.length) {
                        filesUploadInfos.innerHTML = '';
                        getUploads();
                        return;
                    }
                    upload();
                }
            }
        };

        request.open("POST", uploadDest);
        request.setRequestHeader("Cache-Control", "no-cache");
        request.send(formData);
    }

    function createProgressBar(id, text, maxProgress) {
        let div = document.createElement("div");
        let label = document.createElement("label");
        label.htmlFor = id;
        label.innerHTML = text;
        let progress = document.createElement("progress");
        progress.id = id;
        progress.max = maxProgress;
        progress.value = 0;
        div.appendChild(label);
        div.appendChild(progress);
        return div;
    }

    document.addEventListener("DOMContentLoaded", getUploads);
    ATOUM_EVENTS.addEventListener("onURLModified", getUploads);

</script>
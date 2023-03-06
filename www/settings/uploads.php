<h1>Uploads</h1>
<h2>Upload</h2>
<input type="file" id="filesUploader" multiple required/>
<button onclick="uploadFiles()">Upload!</button>
<div id="informations"></div>
<div id="chunkInformations"></div>
<h2>Your uploads</h2>
<input type="text" <?= isset($_GET['searchFor']) ? 'value="' . $_GET['searchFor'] . '"' : '' ?>
       onkeyup="setURLParam('searchFor', value, listFiles)"/>
<input type="checkbox" <?= isset($_GET['displayContent']) ? 'checked' : '' ?>
       onclick="toggleURLParam('displayContent', value, listFiles)"/>
<div id="uploadedFiles"></div>
<div id="contentModal"></div>

<script>
    const filesUploader = document.querySelector("#filesUploader");
    const filesUploadInfos = document.querySelector("#informations");
    const uploadedFiles = document.querySelector("#uploadedFiles");
    const contentModal = document.querySelector("#contentModal");
    const urlParameters = new URLSearchParams(window.location.search);

    document.addEventListener("DOMContentLoaded", function () {
        listFiles();
    });

    const listFiles = () => {
        const request = new XMLHttpRequest();
        const params = new URLSearchParams(new URL(document.URL).toString());
        let from = new URL('<?= FUNCTIONS_URL . 'uploads/getUploadedFiles.php' ?>');

        bindPagination(params, from);

        request.onreadystatechange = () => {
            if (request.readyState === 4 && request.status === 200) {
                uploadedFiles.innerHTML = request.responseText;
            }
        };

        request.open("GET", from);
        request.send();
        uploadedFiles.innerHTML = `<?= BlockSpinner0::echo() ?>`;
    }

    const uploadDest = new URL('<?= FUNCTIONS_URL . 'uploads/uploadFiles.php' ?>');
    const chunkSize = 1048576; // La taille d'un blob en octets
    let files; // Liste des fichiers
    let fileIndex; // L'index du fichier actuellement traité
    let file; // Le fichier actuellement traité
    let fileSize; // La taille du fichier actuellement traité
    let frag, start, end; // Le début, la fin et l'index du blob actuellement traité
    let progress, totalProgress, totalMaxProgress; // Utilisé pour afficher une sorte de progression
    let chunkAmount; // Le nombre total de blobs qui seront envoyés

    const uploadFiles = () => {
        uploadedFiles.innerHTML = `<?= BlockSpinner0::echo() ?>`;

        files = filesUploader.files;
        fileIndex = 0;

        totalProgress = totalMaxProgress = 0;

        // Crée les barres de chargement
        Array.from(files).forEach(f => {
            totalMaxProgress += Math.max(Math.ceil(f.size / chunkSize), 1);
            let id = f.name.replace(/\s+/g, '_').toLowerCase().concat("Progress");
            filesUploadInfos.appendChild(createProgressBar(id, f.name, 100));
        })

        let totalProgressPercent = document.createElement("p");
        totalProgressPercent.id = "totalProgressPercent";
        totalProgressPercent.value = "0%";
        let totalBar = createProgressBar("totalProgress", "Total", totalMaxProgress);
        totalBar.appendChild(totalProgressPercent);

        filesUploadInfos.insertBefore(totalBar, filesUploadInfos.firstChild);

        uploadFile(); // Lancement de l'opération
    }

    const uploadFile = () => {
        file = files[fileIndex];
        fileSize = file.size;
        frag = 1; // Commencer le traitement au premier fragment
        chunkAmount = Math.max(Math.ceil(fileSize / chunkSize), 1);
        start = 0;
        end = Math.min(fileSize, chunkSize);
        progress = 0;

        uploadChunk();
    }

    const uploadChunk = () => {
        const request = new XMLHttpRequest();
        const formData = new FormData();
        let chunk = file.slice(start, end);

        if (frag === 1) formData.append("newFile", "true");
        formData.append("file", chunk); // Le bout de fichier
        formData.append("fileName", file.name); // Le nom du bout de fichier
        formData.append("chunkAmount", chunkAmount); // Le nombre total de bouts de fichier à recevoir
        formData.append("frag", frag); // L'index du bout de fichier actuellement traité

        request.onreadystatechange = () => {
            if (request.readyState === 4 && (request.status === 200 || request.status === 201 || request.status === 204)) {
                progress++;
                totalProgress++;

                // Feedbacks
                let id = file.name.replace(/\s+/g, '_').toLowerCase().concat("Progress");
                document.getElementById(id).value = progress;
                document.getElementById(id).max = chunkAmount;
                document.getElementById("totalProgress").value = totalProgress;
                document.getElementById("totalProgress").max = totalMaxProgress;
                document.getElementById("totalProgressPercent").innerHTML = Math.trunc((totalProgress / totalMaxProgress * 100)) + "%";

                if (frag < chunkAmount) {
                    start = end;
                    end = Math.min(fileSize, start + chunkSize);
                    frag++;
                    uploadChunk();
                } else {
                    fileIndex++;
                    if (fileIndex >= files.length) { // Tous les fichiers ont étés traités
                        filesUploadInfos.innerHTML = '';
                        listFiles();
                        return;
                    }
                    uploadFile();
                }
            }
        };

        request.open("POST", uploadDest);
        request.setRequestHeader("Cache-Control", "no-cache");
        request.send(formData);
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

    const deleteContent = () => {
        // TODO
    }

    const createProgressBar = (id, text, maxProgress) => {
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
</script>
<h1>Uploads</h1>
<h2>Upload</h2>
<input type="file" id="filesUploader" multiple required/>
<button onclick="uploadFiles()">Upload!</button>
<div id="informations"></div>
<div id="chunkInformations"></div>
<h2>Your uploads</h2>
<div id="uploadedFiles"></div>

<script>
    const filesUploader = document.querySelector("#filesUploader");
    const filesUploadInfos = document.querySelector("#informations");
    const uploadedFiles = document.querySelector("#uploadedFiles");
    const urlParameters = new URLSearchParams(window.location.search);

    document.addEventListener("DOMContentLoaded", function () {
        listFiles();
    });

    const listFiles = () => {
        const request = new XMLHttpRequest();
        const params = new URLSearchParams(new URL(document.URL).toString());
        let from = new URL('<?= SETTINGS_FUNCTIONS_URL . 'uploads/listFiles.php' ?>');

        if (params.has("type")) from.searchParams.set("type", params.get("type"));
        if (params.has("status")) from.searchParams.set("status", params.get("status"));
        if (params.has("orderBy")) from.searchParams.set("orderBy", params.get("orderBy"));
        if (params.has("limit")) from.searchParams.set("limit", params.get("limit"));
        if (params.has("currentPage")) from.searchParams.set("currentPage", params.get("currentPage"));

        request.onreadystatechange = () => {
            if (request.readyState === 4 && request.status === 200) {
                uploadedFiles.innerHTML = request.responseText;
            }
        };

        request.open('GET', from, true);
        request.send();
        uploadedFiles.innerHTML = `<?= block('spinner0') ?>`;
    }

    const setType = (newType) => {
        let newURL = new URL(document.URL);
        let searchParams = newURL.searchParams;
        if (searchParams.has("type")) {
            searchParams.delete("type");
        } else {
            searchParams.set("type", newType);
        }
        window.history.replaceState({id: "100"}, "type", newURL);
        listFiles();
    }

    const setStatus = (newStatus) => {
        let newURL = new URL(document.URL);
        let searchParams = newURL.searchParams;
        if (searchParams.has("status")) {
            searchParams.delete("status");
        } else {
            searchParams.set("status", newStatus);
        }
        window.history.replaceState({id: "100"}, "status", newURL);
        listFiles();
    }

    const setOrderBy = (newOrderBy) => {
        let newURL = new URL(document.URL);
        newURL.searchParams.set("orderBy", newOrderBy);
        window.history.replaceState({id: "100"}, "orderBy", newURL);
        listFiles();
    }

    const setLimit = (newLimit) => {
        let newURL = new URL(document.URL);
        newURL.searchParams.set("limit", newLimit);
        window.history.replaceState({id: "100"}, "limit", newURL);
        listFiles();
    }

    const setCurrentPage = (newCurrentPage) => {
        let newURL = new URL(document.URL);
        newURL.searchParams.set("currentPage", newCurrentPage);
        window.history.replaceState({id: "100"}, "currentPage", newURL);
        listFiles();
    }

    const uploadDest = new URL('<?= SETTINGS_FUNCTIONS_URL . 'uploads/uploadFiles.php' ?>');
    const chunkSize = 1048576; // La taille d'un blob en octets
    let files; // Liste des fichiers
    let fileIndex; // L'index du fichier actuellement traité
    let file; // Le fichier actuellement traité
    let fileSize; // La taille du fichier actuellement traité
    let frag, start, end; // Le début, la fin et l'index du blob actuellement traité
    let progress; // Utilisé pour afficher une sorte de progression
    let chunkAmount; // Le nombre total de blobs qui seront envoyés

    const uploadFiles = () => {
        uploadedFiles.innerHTML = `<?= block('spinner0') ?>`;

        files = filesUploader.files;
        fileIndex = 0;

        // Crée les barres de chargement
        Array.from(files).forEach(f => {
            let id = f.name.replace(/\s+/g, '_').toLowerCase();

            let container = document.createElement('div');
            let bar = document.createElement('div');
            let innerBar = document.createElement('div');

            bar.className = 'progressBar';
            innerBar.id = id.concat('_inner_progressBar');
            innerBar.className = 'inner_progressBar';

            let p = document.createElement('p');
            p.innerHTML = f.name;

            container.appendChild(p);
            bar.appendChild(innerBar);
            container.appendChild(bar);

            filesUploadInfos.appendChild(container);
        })

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
                let id = file.name.replace(/\s+/g, '_').toLowerCase().concat("_inner_progressBar");
                let progressValue = (progress / chunkAmount) * 100;
                document.getElementById(id).style.width = progressValue + "%";

                if (frag < chunkAmount) {
                    start = end;
                    end = Math.min(fileSize, start + chunkSize);
                    frag++;
                    uploadChunk();
                } else /*if (request.responseText.includes('fileUploaded'))*/ {
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
</script>
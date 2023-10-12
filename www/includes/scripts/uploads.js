document.addEventListener("DOMContentLoaded", getUploads);
atoumEvents.addEventListener("onURLModified", getUploads);
atoumEvents.addEventListener("onTypeaheadModify", bindActorsAndTagsInURL);

function bindActorsAndTagsInURL(field) {
    if (field === "actor-filter" || field === "tag-filter") {
        let actors = [];
        let inputs = document.querySelectorAll('input[name=\"' + "actor-filter[]" + '\"]');
        inputs.forEach(function (input) {
            actors.push(input.value);
        });
        let tags = [];
        inputs = document.querySelectorAll('input[name=\"' + "tag-filter[]" + '\"]');
        inputs.forEach(function (input) {
            tags.push(input.value);
        });

        setArray("actors", actors);
        setArray("tags", tags);
    }
}

function getUploads() {
    let where = new URL(window.location.origin.concat("/includes/functions/getUploads.php"));
    bindParams(where);
    putFrom(where, "uploads-content");
    updatePagination("pagination");
}

const filesUploader = document.querySelector("#filesUploader");
const filesUploadInfos = document.querySelector("#informations");
const uploadedFiles = document.querySelector("#uploadedFiles");
const contentModal = document.querySelector("#contentModal");
const urlParameters = new URLSearchParams(window.location.search);
const uploadDest = window.location.origin.concat("/includes/functions/uploadFiles.php");
const chunkSize = 1048576; // La taille d'un blob en octets
let files; // Liste des fichiers
let fileIndex; // L'index du fichier actuellement traité
let file; // Le fichier actuellement traité
let fileSize; // La taille du fichier actuellement traité
let frag, start, end; // Le début, la fin et l'index du blob actuellement traité
let progress, totalProgress, totalMaxProgress; // Utilisé pour afficher une sorte de progression
let chunkAmount; // Le nombre total de blobs qui seront envoyés

function uploadFiles() {
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

function uploadFile() {
    file = files[fileIndex];
    fileSize = file.size;
    frag = 1; // Commencer le traitement au premier fragment
    chunkAmount = Math.max(Math.ceil(fileSize / chunkSize), 1);
    start = 0;
    end = Math.min(fileSize, chunkSize);
    progress = 0;

    uploadChunk();
}

function uploadChunk() {
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
                    getUploads();
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

function unregister(id, type) {
    function refresh() {
        closeEdit();
        getUploads();
    }

    if (confirm("Are you sure?")) sendRequest(window.location.origin.concat("/includes/functions/unregister.php?id=" + id + "&type=" + type), refresh);
}
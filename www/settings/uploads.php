<h1>Uploads</h1>
<h2>Upload</h2>
<input type="file" id="filesUploader" multiple required/>
<button onclick="uploadFiles()">Upload!</button>
<h2>Your uploads</h2>
<div id="uploadedFiles"></div>

<script>
    const filesUploader = document.querySelector("#filesUploader");
    const uploadedFiles = document.querySelector("#uploadedFiles");
    const urlParameters = new URLSearchParams(window.location.search);

    document.addEventListener("DOMContentLoaded", function () {
        listFiles();
    });

    const uploadFiles = () => {
        const request = new XMLHttpRequest();
        const formData = new FormData();

        Array.from(filesUploader.files).forEach(f => formData.append('files[]', f));

        request.onreadystatechange = () => {
            if (request.readyState === 4 && request.status === 200) {
                listFiles();
            }
        };

        request.open('POST', '<?= SETTINGS_FUNCTIONS_URL . 'uploads/uploadFiles.php' ?>', true);
        request.send(formData);
        uploadedFiles.innerHTML = `<?= block('spinner0') ?>`;
    };

    const listFiles = () => {
        const request = new XMLHttpRequest();
        const params = new URLSearchParams(new URL(document.URL).toString());
        let from = new URL('<?= SETTINGS_FUNCTIONS_URL . 'uploads/listFiles.php' ?>');

        if (params.has('type')) from.searchParams.set('type', params.get('type'));
        if (params.has('status')) from.searchParams.set('status', params.get('status'));
        if (params.has('orderBy')) from.searchParams.set('orderBy', params.get('orderBy'));
        if (params.has('limit')) from.searchParams.set('limit', params.get('limit'));
        if (params.has('currentPage')) from.searchParams.set('currentPage', params.get('currentPage'));

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
        if (searchParams.has('type')) {
            searchParams.delete('type');
        } else {
            searchParams.set('type', newType);
        }
        window.history.replaceState({id: '100'}, 'type', newURL);
        listFiles();
    }

    const setStatus = (newStatus) => {
        let newURL = new URL(document.URL);
        let searchParams = newURL.searchParams;
        if (searchParams.has('status')) {
            searchParams.delete('status');
        } else {
            searchParams.set('status', newStatus);
        }
        window.history.replaceState({id: '100'}, 'status', newURL);
        listFiles();
    }

    const setOrderBy = (newOrderBy) => {
        let newURL = new URL(document.URL);
        newURL.searchParams.set('orderBy', newOrderBy);
        window.history.replaceState({id: '100'}, 'orderBy', newURL);
        listFiles();
    }

    const setLimit = (newLimit) => {
        let newURL = new URL(document.URL);
        newURL.searchParams.set('limit', newLimit);
        window.history.replaceState({id: '100'}, 'limit', newURL);
        listFiles();
    }

    const setCurrentPage = (newCurrentPage) => {
        let newURL = new URL(document.URL);
        newURL.searchParams.set('currentPage', newCurrentPage);
        window.history.replaceState({id: '100'}, 'currentPage', newURL);
        listFiles();
    }
</script>
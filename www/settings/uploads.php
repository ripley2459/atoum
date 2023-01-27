<h1>Uploads</h1>
<h2>Upload</h2>
<input type="file" id="filesUploader" multiple required/>
<h2>Your uploads</h2>
<div id="uploadedFiles"></div>

<script>
    const filesUploader = document.querySelector("#filesUploader");
    const uploadedFiles = document.querySelector("#uploadedFiles");
    const urlParameters = new URLSearchParams(window.location.search);

    filesUploader.addEventListener('change', event => {
        uploadFile(filesUploader.files);
    });

    const uploadFile = (files) => {
        const request = new XMLHttpRequest();
        const formData = new FormData();

        Array.from(files).forEach(f => formData.append('files[]', f));

        request.onreadystatechange = () => {
            if (request.readyState === 4 && request.status === 200) {
                listFiles();
            }
        };

        request.open('POST', '<?= SETTINGS_FUNCTIONS_URL . 'uploads/uploadFiles.php' ?>', true);
        request.send(formData);
    };

    const listFiles = () => {
        const request = new XMLHttpRequest();
        const orderBy = urlParameters.get('orderBy');
        const type = urlParameters.get('type');

        let functionUrl = '<?= SETTINGS_FUNCTIONS_URL . 'uploads/listFiles.php?' ?>';

        if (orderBy != null) functionUrl = functionUrl.concat('&orderBy=').concat(orderBy);
        if (type != null) functionUrl = functionUrl.concat('&type=').concat(type);

        console.log(functionUrl);

        request.onreadystatechange = () => {
            if (request.readyState === 4 && request.status === 200) {
                uploadedFiles.innerHTML = request.responseText;
            }
        };

        request.open('GET', functionUrl, true);
        request.send();
    }
</script>
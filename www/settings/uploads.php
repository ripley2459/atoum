<h1>Uploads</h1>
<h2>Upload</h2>
<input type="file" id="filesUploader" multiple required/>
<h2>Your uploads</h2>
<div id="uploadedFiles"></div>

<script>
    const filesUploader = document.querySelector("#filesUploader");
    const uploadedFiles = document.querySelector("#uploadedFiles");

    filesUploader.addEventListener('change', event => {
        uploadFile(filesUploader.files);
    });

    const uploadFile = (files) => {
        const request = new XMLHttpRequest();
        const formData = new FormData();

        Array.from(files).forEach(f => formData.append('files[]', f));

        request.onreadystatechange = () => {
            if (request.readyState === 4 && request.status === 200) {
                uploadedFiles.innerHTML = request.responseText;
            }
        };

        request.open('POST', '<?= SETTINGS_FUNCTIONS_URL . 'uploads/uploadFiles.php' ?>', true);
        request.send(formData);
    };
</script>
<div class="container">

    <h1>Logout</h1>

    <form id="formLogout">
        <button type="submit" name="logout">Logout</button>
    </form>

</div>

<div id="feedbacks"></div>

<script>

    const form = document.getElementById("formLogout");

    form.addEventListener("submit", (event) => {
        event.preventDefault();

        const request = new XMLHttpRequest();

        request.onreadystatechange = () => {
            if (request.readyState === 4 && request.status === 200) {
                document.getElementById("feedbacks").innerHTML = request.responseText;
            }
        };

        const formData = new FormData(form);
        request.open("POST", "<?= App::getFunction('auth/logout') ?>");
        request.send(formData);
    });

</script>
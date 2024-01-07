<div class="container">
    <h1>Login</h1>
    <form id="formLogin">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" required/>
        <label for="password">Password</label>
        <input type="password" id="password" name="password" required/>
        <button type="submit" name="login">Login</button>
    </form>
    <a href="<?= App::getLink('register') ?>">You don't have an account?</a>
</div>

<div id="feedbacks"></div>

<script>

    const form = document.getElementById("formLogin");

    form.addEventListener("submit", (event) => {
        event.preventDefault();

        const request = new XMLHttpRequest();

        request.onreadystatechange = () => {
            if (request.readyState === 4 && request.status === 200) {
                document.getElementById("feedbacks").innerHTML = request.responseText;
            }
        };

        const formData = new FormData(form);
        request.open("POST", "<?= App::getFunction('auth/login') ?>");
        request.send(formData);
    });

</script>
<div class="container">

    <h1>Create an account</h1>

    <form id="formRegister">

        <?= Auth::getTokenField() ?>

        <label for="username">Username</label>
        <input type="text" id="username" name="username" placeholder="Your unique name" required/>

        <label for="name">Name</label>
        <input type="text" id="name" name="name" placeholder="Your displayed name" required/>

        <label for="password">Password</label>
        <input type="password" id="password" name="password" required/>

        <label for="confirmPassword">Confirm password</label>
        <input type="password" id="confirmPassword" name="confirmPassword" required/>

        <button type="submit" name="register">Create account</button>

    </form>

</div>

<div class="container">

    <div id="feedbacks"></div>

</div>

<script>

    const form = document.getElementById('formRegister');

    form.addEventListener('submit', (event) => {
        event.preventDefault();

        const request = new XMLHttpRequest();

        request.onreadystatechange = () => {
            if (request.readyState === 4 && request.status === 200) {
                document.getElementById('feedbacks').innerHTML = request.responseText;
            }
        };

        const formData = new FormData(form);
        request.open('POST', '<?= App::getFunction('auth/register') ?>');
        request.send(formData);
    });

</script>
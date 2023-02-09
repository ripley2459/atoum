<?php

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Atoum's installation process</title>
</head>
<body>
<header>
    <nav id="topnav">
    </nav>
</header>
<div id="content">
    <h1>Atoum's installation process</h1>
    <form action="install.php" method="post">
        <h2>Installation informations</h2>
        <label for="host">Host</label>
        <input name="host" type="text" required/>
        <br/>
        <label for="dbname">Database name</label>
        <input name="dbname" type="text" required/>
        <br/>
        <label for="prefix">Tables prefix</label>
        <input name="prefix" type="text" required/>
        <br/>
        <label for="dbusername">Database access's username</label>
        <input name="dbusername" type="text" required/>
        <br/>
        <label for="dbpassword">Database access's password</label>
        <input name="dbpassword" type="password" required/>
        <h2>Website owner informations</h2>
        <label for="username">Website owner's username</label>
        <input name="username" type="text" required/>
        <br/>
        <label for="password">Website owner's password</label>
        <input name="password" type="password" required/>
        <br/>
        <button type="submit" value="Submit">Submit</button>
    </form>
</div>
<footer>
    <div id="bottomnav">
    </div>
</footer>
</body>
</html>
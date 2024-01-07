<?php

$gallery = new Content(R::getParameter('gallery'));

?>

<div class="container">

    <?php gallery($gallery) ?>

</div>
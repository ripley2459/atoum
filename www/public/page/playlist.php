<?php

$playlist = new Content(R::getParameter('playlist'));

App::setTitle('Atoum - Playlist');
App::setDescription('Atoum - Playlist'); ?>

<?php playlist($playlist) ?>
<?php dataInfo($playlist);

?>

<?php

/*
 * Serves ajax requests to installer.php
 */

// Get the options from the selected module
$option = $_POST['option'];
$JSON = file_get_contents('https://raw.github.com/James-Dunn/framework/master/db/' . $option);
$decodedJSON = json_decode($JSON);
$encodedJSON = json_encode($decodedJSON->options);

echo $encodedJSON;

?>

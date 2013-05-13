<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$url = 'http://github.com/' . $_POST['module'];
$json = file_get_contents($url);
$module = json_decode($json);
$name = $module->name;
$description = $module->description;
$install = $module->install;
$uninstall = $module->uninstall;

if($_POST['command'] === 'install')
    $command = $install;
else if($_POST['command'] === 'uninstall')
    $command = $uninstall;

$stmt = $pdo->prepare($command);
$stmt->execute();

echo "<h2>$name Successfully Installed</h2>";

?>

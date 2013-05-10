<?php

/*
 * Route URLs easily
 */

// Config data
$host = 'localhost';
$dbName = ''; // Database name
$username = '';
$password = '';
$viewsPath = '/web/'; // Path to the view folder
$appPath = '/app/'; // Path to the app folder

$pdo = new PDO("mysql:host=$host;dbname=$dbName", $username, $password);
$requestURI = $_SERVER['REQUEST_URI'];

// Get matching URL view and app
$stmt = $pdo->prepare('SELECT * FROM urls WHERE uri=?');
$data = array($requestURI);
$stmt->execute($data);
$stmt->setFetchMode(PDO::FETCH_ASSOC);
$row = $stmt->fetch();
$theme = $viewsPath . $row['view'];
$app = $appPath . $row['app'];

// Route the URL if it is valid
if(!empty($stmt->rowCount()))
{
    include $app;
    include $theme;
}
else # 404 error
{
    include '404.html';
}

?>

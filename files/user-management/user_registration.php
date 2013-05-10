<?php

/*
 * User registration
 * Requires 'users' database file
 */

$example_body = '';

if(!empty($_POST))
{
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare('INSERT INTO users (username, password) VALUES (?,?)');
    $data = array($username, $password);
    $stmt->execute($data);
}

$user_registration['full'] = '
    <form action="" method="POST">
        Username: <input type="text" name="username"><br />
        Password: <input type="text" name="password"><br />
        <input type="submit"><br />
    </form>';

?>

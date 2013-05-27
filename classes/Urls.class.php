<?php

/*
 * URLs
 * Create user-friendly URLs in your app.
 */

class Urls {

    /**
     * Insert a new url record into the database
     * @param PDO $pdo
     * @param string $uri The URI called from $_SERVER['REQUEST_URI']
     * @param string $app The file in the app folder that serves the request
     * @param string $theme The file that is the template for your page
     * @return INT Returns the id of the url record
     */
    public static function createURL($pdo, $uri, $app, $theme)
    {
        $stmt = $pdo->prepare('INSERT INTO urls (uri,app,theme) VALUES (?,?,?)');
        $data = array($uri, $app, $theme);
        $stmt->execute($data);
        return $pdo->lastInsertId();
    }
    
    /**
     * Prints out a form to manually add another URL
     * @param PDO $pdo
     * @param array $_POST
     * @return string Form to input the url info
     */
    public function form($pdo)
    {
        if($_POST)
        {
            static::createURL($pdo, $_POST['uri'], $_POST['app'], $_POST['theme']);
        }
        $form = '<h2>Create a URL Alias</h2>
            <table><form action="" method="POST">
                <tr><td>URI:</td><td><input type="text" name="uri"> e.g. /blog </td></tr>
                <tr><td>App:</td><td><input type="text" name="app"> e.g. blog.php </td></tr>
                <tr><td>Theme:</td><td><input type="text" name="theme"> e.g. blog-theme.php </td></tr>
                <tr><td></td><td><input type="submit" value="Submit"></td></tr>
            </form></table>';
        
        return $form;
    }
    
    /**
     * Creates a table allowing you to easily manage your URL aliases
     * @param PDO $pdo PHP Data Object
     * @return string
     */
    public static function manageURLs($pdo)
    {
        $table = ''; # prepare output
        
        // Make edits
        if($_GET['edit'])
        {
            $stmt = $pdo->prepare('SELECT * FROM urls WHERE id=?');
            $data = array($_GET['edit']);
            $stmt->execute($data);
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $row = $stmt->fetch();
            
            $table .= '<h2>Edit URL Alias</h2><table><form action="" method="GET">
                <tr><td>URI:</td><td><input type="text" name="uri" value="' . $row['uri'] . '"></td></tr>
                <tr><td>App:</td><td><input type="text" name="app" value="' . $row['app'] . '"></td></tr>
                <tr><td>Theme:</td><td><input type="text" name="theme" value="' . $row['theme'] . '"></td></tr>
                <tr><td><input type="hidden" name="id" value="' . $row['id'] . '"></td><td><input type="submit" value="Submit"></td></tr></table>';
        }
        
        // Complete requested edits
        if($_GET['uri'])
        {
            $stmt = $pdo->prepare('UPDATE urls SET uri=?, app=?, theme=? WHERE id=?');
            $data = array($_GET['uri'], $_GET['app'], $_GET['theme'], $_GET['id']);
            $stmt->execute($data);
            $table .= '<h3>URL has been edited</h3>';
        }
        
        // Delete records
        if($_GET['delete'])
        {
            $stmt = $pdo->prepare('DELETE FROM urls WHERE id=?');
            $data = array($_GET['delete']);
            $stmt->execute($data);
            $table .= '<h3>URL has been deleted</h3>';
        }
        
        // Get all existing records
        $stmt = $pdo->prepare('SELECT * FROM urls');
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        
        // Create the table for viewing all current URLs
        $table .= '<h2>Manage URLs</h2><table>
            <tr><td>URI</td><td>App</td><td>Theme</td><td>Edit</td><td>Delete</td></tr>';
        while($row = $stmt->fetch())
        {
            $table .= '<tr><td>' . $row['uri'] . '</td><td>' . $row['app'] . '</td><td>' . $row['theme'] . '</td>
                <td><a href="?edit=' . $row['id'] . '">edit</a></td><td><a href="?delete=' . $row['id'] . '">Delete</a></td></tr>';
        }
        $table .= '</table>';
        
        return $table;
    }
}

?>

<?php

/*
 * User registration
 * Requires 'users' database file
 */

class UserRegistration {

    public static function form($pdo, $_POST) {

        if(!empty($_POST))
        {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $dbNames = 'username, password';
            $dbVals = '?,?';
            $dbInsertVals = array($username, $password);
            
            // Get options
            foreach($_POST as $name=>$val)
            {
                switch($name)
                {
                    case 'firstName':
                    case 'lastName':
                    case 'phone':
                    case 'address':
                    case 'zip':
                        $dbNames .= ", $name";
                        $dbVals .= ',?';
                        $dbInsertVals[] = $val;
                        break;

                    default:
                        break;
                }
            }

            $stmt = $pdo->prepare("INSERT INTO users ($dbNames) VALUES ($dbVals)");
            $stmt->execute($dbInsertVals);
        }

        // Check options
        $stmt = $pdo->prepare("SELECT * FROM modules WHERE module='users'");
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $formOptions = '';
        while($row = $stmt->fetch())
        {
            $option = $row['option'];
            switch($option)
            {
                case 'firstName':
                    $formOptions .= 'First Name: <input type="text" name="firstName"><br />';
                    break;

                case 'lastName':
                    $formOptions .= 'Last Name: <input type="text" name="lastName"><br />';
                    break;

                case 'phone':
                    $formOptions .= 'Phone: <input type="text" name="phone"><br />';
                    break;

                case 'address':
                    $formOptions .= 'Address: <texarea name="address"></textarea><br />';
                    break;

                case 'zip':
                    $formOptions .= 'Zip: <input type="text" name="zip"><br />';
                    break;

                default:
                    break;
            }
        }

        $body = "
            <form action='' method='POST'>
                Username: <input type='text' name='username'><br />
                Password: <input type='text' name='password'><br />
                $formOptions
                <input type='submit'>
            </form>";
        return $body;
    }
}
?>

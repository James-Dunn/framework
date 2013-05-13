<?php

/*
 * Install database tables
 */

// See if the user entered the correct username/password
if($_POST['username'] === $adminUsername && $_POST['password'] === $adminPassword) #  && !empty($adminPassword)
{
    $_SESSION['logged'] = 'y';
}

// User is logged in
if($_SESSION['logged'] === 'y')
{
    if(!empty($_POST['module'])) # User wants to install a module
    {
        // Get the module's contents
        $url = 'https://raw.github.com/James-Dunn/framework/master/db/' . $_POST['module'];
        $json = file_get_contents($url);
        $module = json_decode($json);
        $name = $module->name;
        $description = $module->description;
        $install = $module->install;
        $uninstall = $module->uninstall;
        $optionsArr = $module->options;

        // Does the user want to install or uninstall?
        if($_POST['command'] === 'install')
            $command = $install;
        else if($_POST['command'] === 'uninstall')
            $command = $uninstall;

        // Install the basic table
        $stmt = $pdo->prepare($command);
        $stmt->execute();
        
        // Go through all the options and install additional columns
        foreach($_POST['option'] as $option)
        {
            $stmt = $pdo->prepare($optionsArr->$option);
            $stmt->execute();
        }

        echo "<h2>$name Successfully Installed</h2>";
    }
    
    # Create form to select module
    $json = file_get_contents('https://raw.github.com/James-Dunn/framework/master/db/master.json');
    $masterList = json_decode($json,true);
    $moduleLI = '';
    foreach($masterList as $key=>$val)
    {
        // Get all optional db rows
        $json = file_get_contents('https://raw.github.com/James-Dunn/framework/master/db/' . $val);
        $moduleLI .= "<input type='radio' name='module' value='$val' class='module'>$key<br />";
        
    }
    
    echo "<form action='' method='POST'>
            <h3>Select Database Table to Install:</h3>
            $moduleLI
            <div id='options'></div><br />
            <input type='submit' value='Install'>
          </form>";
}
else # User isn't logged in
{
    echo "<form action='' method='POST'>
            Username: <input type='text' name='username'><br />
            Password: <input type='text' name='password'><br />
            <input type='submit' value='Submit'>
        </form>";
}

?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script>
    $(function(){
        $('.module').click(function(){
            var option = $(this).val();
            $.post('options.ajax.php', { 'option': option }, function(results){
                $.each(results, function(optionItem){
                    $("#options").append("<input type='checkbox' name='option[]' value='" + optionItem + "'>" + optionItem + "<br />");
                });
            }, 'JSON');
        });
    });
</script>

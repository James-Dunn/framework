<?php

/*
 * Create contact table
 * Columns:
 * - id
 * - firstName
 * - lastName
 * - age
 */

$output['name'] = 'Contact';
$output['description'] = 'Creates a contact table';
$options = array('lastName CHAR(15),');
$output['install'] = "CREATE TABLE contact (
id INT NOT NULL AUTO_INCREMENT, 
PRIMARY KEY(id),
$options
firstName CHAR(15),
age INT
)";
$output['uninstall'] = 'DROP TABLE contact';
$output['requirements'] = 'none';

echo json_encode($output);

?>

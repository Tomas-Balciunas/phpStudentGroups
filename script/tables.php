<?php 

$conn = mysqli_connect('localhost', 'root', '', 'nfq');

$query = "CREATE table projects (
    id INT( 11 ) AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR( 255 ) NOT NULL, 
    `groups` INT( 11 ) NOT NULL,
    students_per_group INT( 11 ) NOT NULL);
    
    CREATE table students (
    id INT( 11 ) AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR( 255 ) NOT NULL, 
    `project` INT( 11 ) NOT NULL,
    `group` INT( 11 ));";

if(mysqli_multi_query($conn, $query)){
    echo "Tables created";
} else{
    echo "Error in creating tables: $query. " . mysqli_error($conn);
}

mysqli_close($conn);   
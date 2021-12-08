<?php

use NFQ\DB;
use NFQ\Tasks;
use NFQ\Validation;

if (isset($_POST['submit'])) {
    $connection = DB::connect();
    $validation = Validation::project($_POST);

    if (empty(implode('', $validation))) {
        $task = new Tasks($connection);
        $task->createProject($_POST);
    } else {
        foreach ($validation as $error) {
            echo '<p>' . $error . '</p>';
        }
    }
}

// $showProjects = new Tasks($connection);
// $projects = $showProjects->listProjects();

// $showStudents = new Tasks($connection);
// $students = $showStudents->listStudents();

// $groups = Tasks::groups($projects, $students);

require "view/pages/home.view.php";

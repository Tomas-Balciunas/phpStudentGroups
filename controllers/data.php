<?php

use NFQ\DB;
use NFQ\Tasks;

header("Content-Type:application/json");

$connection = DB::connect();

$showProjects = new Tasks($connection);
$projects = $showProjects->listProjects();

$showStudents = new Tasks($connection);
$students = $showStudents->listStudents();

$groups = Tasks::groups($projects, $students);

$data['projects'] = $projects;
$data['students'] = $students;
$data['groups'] = $groups;

echo json_encode($data);
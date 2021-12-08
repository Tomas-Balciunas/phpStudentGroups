<?php

use NFQ\DB;
use NFQ\Tasks;
use NFQ\Request;
use NFQ\Validation;

$validation = Validation::newStudent($_POST);
$id = intval(basename(Request::uri()));
$connection = DB::connect();

if (empty(implode('', $validation))) {
    $task = new Tasks($connection);
    $msg = $task->addStudent($id, $_POST);
    echo json_encode($msg);
} else {
    echo json_encode($validation['student']);
}

// if (isset($_POST['newStudent'])) {
//     $validation = Validation::newStudent($_POST);
//     $id = intval(basename(Request::uri()));
//     $connection = DB::connect();
//     if (empty(implode('', $validation))) {
//         $task = new Tasks($connection);
//         $task->addStudent($id, $_POST);
//     } else {
//         foreach ($validation as $error) {
//             echo '<p>' . $error . '</p>';
//         }
//     }
// }

// header('Location:/nfq/');

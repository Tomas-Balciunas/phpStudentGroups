<?php

use NFQ\DB;
use NFQ\Tasks;
use NFQ\Request;

// if (isset($_POST['newStudent'])) {
    $id = intval(basename(Request::uri()));
    $connection = DB::connect();
    $task = new Tasks($connection);
    $task->addStudent($id, $_POST);
// }

// header('Location:/nfq/');

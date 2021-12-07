<?php

use NFQ\DB;
use NFQ\Tasks;
use NFQ\Request;

// if (isset($_POST['deleteStudent'])) {
    $id = intval(basename(Request::uri()));
    $connection = DB::connect();
    $task = new Tasks($connection);
    $task->deleteStudent($id);
// }

// header('Location:/nfq/');

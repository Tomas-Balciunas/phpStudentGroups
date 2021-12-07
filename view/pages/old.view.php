<!DOCTYPE html>
<html>
<?php require "view/_partials/head.view.php"; ?>

<body>

    <!--------------------------------------------------------- CREATE PROJECT ---------------------------------------------------------->

    <div class="container d-flex justify-content-center">
        <form class="col-sm-4 mt-3" method="POST">
            <div class="row">
                <div class="mb-2 col text-center">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" class="form-control  form-control-sm" id="title" name="title">
                </div>
            </div>
            <div class="row">
                <div class="mb-2 col text-center">
                    <label for="groups" class="form-label">Number of groups</label>
                    <input type="text" class="form-control  form-control-sm" id="groups" name="groups">
                </div>
                <div class="mb-2 col text-center">
                    <label for="studentsPerGroup" class="form-label">Students per group</label>
                    <input type="text" class="form-control  form-control-sm" id="studentsPerGroup" name="studentsPerGroup">
                </div>
            </div>
            <div class="row justify-content-center">
                <button type="submit" class="btn btn-primary col-sm-2" name="submit">Submit</button>
            </div>
        </form>
    </div>

    <!------------------------------------------------------- PROJECT INFO ------------------------------------------------------------>

    <?php foreach ($projects as $project) : ?>
        <hr />
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-sm-3 text-center">
                    <h4>Project <i><?= $project['title']; ?></i></h4>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-sm-2 text-center">
                    <span>Groups: <b><?= $project['groups']; ?></b></span>
                </div>
                <div class="col-sm-2 text-center">
                    <span>Students per group: <b><?= $project['students_per_group']; ?></b></span>
                </div>
            </div>

            <!------------------------------------------------------- STUDENT LIST ------------------------------------------------------------>

            <div class="row">
                <table class="table table-bordered">
                    <tr>
                        <th>Name</th>
                        <th>Group</th>
                        <th></th>
                        <th></th>
                    </tr>
                    <?php foreach ($students as $student) : ?>
                        <?php if ($student['project'] == $project['id']) : ?>
                            <tr>
                                <td><?= $student['name']; ?></td>
                                <form method="POST" action="update-student/<?= $student['id']; ?>">
                                    <td>
                                        <select name="studentGroup" class="form-control  form-control-sm">
                                            <option value="0" <?= $student['group'] == 0 ? 'selected="selected"' : ''; ?>>None</option>
                                            <?php for ($i = 1; $i <= $project['groups']; $i++) : ?>
                                                <option value="<?= $i; ?>" <?= $student['group'] == $i ? 'selected="selected"' : ''; ?>>Group <?= $i; ?></option>
                                            <?php endfor; ?>
                                        </select>
                                    </td>
                                    <input type="hidden" name="projectId" value="<?= $project['id']; ?>">
                                    <td>
                                        <button type="submit" class="btn btn-success" name="updateStudent">Update</button>
                                    </td>
                                </form>
                                <td>
                                    <form method="POST" action="delete-student/<?= $student['id']; ?>">
                                        <button type="submit" class="btn btn-danger" name="deleteStudent">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </table>

                <!------------------------------------------------------- ADD STUDENT ------------------------------------------------------------>

                <form method="POST" action="add-student/<?= $project['id']; ?>">
                    <input type="text" name="student" class="form-control  form-control-sm">
                    <select name="studentGroup" class="form-control  form-control-sm">
                        <option value="0" selected="selected">None</option>
                        <?php for ($i = 0; $i < $project['groups']; $i++) : ?>
                            <option value="<?= $i + 1; ?>">Group <?= $i + 1; ?></option>
                        <?php endfor; ?>
                    </select>
                    <button type="submit" class="btn btn-success" name="newStudent">Add New Student</button>
                </form>
            </div>

            <!------------------------------------------------------- GROUP LIST ------------------------------------------------------------>

            <div class="row justify-content-center">
                <?php for ($i = 1; $i <= $project['groups']; $i++) : ?>
                    <div class="col-sm-1">
                        <table class="table table-bordered">
                            <tr>
                                <th>Group <?= $i; ?></th>
                            </tr>
                            <?php for ($k = 0; $k < $project['students_per_group']; $k++) : ?>
                                <tr>
                                    <?php echo isset($groups[$project['id']]['groups'][$i][$k]) ? '<td class="text-success">' . $groups[$project['id']]['groups'][$i][$k] . '</td>' : '<td class="text-secondary">' . 'Empty' . '</td>'; ?>
                                </tr>
                            <?php endfor; ?>
                        </table>
                    </div>
                <?php endfor; ?>
            </div>

        </div>
    <?php endforeach; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>
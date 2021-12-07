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
                <button type="submit" class="btn btn-primary col-sm-3" name="submit">Submit</button>
            </div>
        </form>
    </div>

    <!------------------------------------------------------- PROJECT INFO ------------------------------------------------------------>

    <div id="app">
        <template v-for="(e, index) in data.projects">
            <hr />
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-sm-3 text-center">
                        <h4>Project <i>{{e.title}}</i></h4>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-sm-2 text-center">
                        <span>Groups: <b>{{e.groups}}</b></span>
                    </div>
                    <div class="col-sm-2 text-center">
                        <span>Students per group: <b>{{e.students_per_group}}</b></span>
                    </div>
                </div>

                <!------------------------------------------------------- STUDENT LIST ------------------------------------------------------------>

                <div class="row">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Group</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <template v-for="(stud, index) in data.students">
                                <template v-if="e.id == stud.project">
                                    <tr>
                                        <td>{{stud.name}}</td>
                                        <td>
                                            <select name="studentGroup" class="form-control form-control-sm" :form="'updateStud'+stud.id">
                                                <option value="0" v-if="stud.group == 0" selected="selected">None</option>
                                                <option value="0" v-else>None</option>
                                                <option v-for="index in parseInt(e.groups)" :selected="stud.group == index" :value="index">Group {{index}}</option>
                                            </select>
                                        </td>
                                        <input type="hidden" name="projectId" :value="e.id" :form="'updateStud'+stud.id">
                                        <td>
                                            <form @submit.prevent="updateStudent(stud.id)" :id="'updateStud'+stud.id">
                                                <button type="submit" class="btn btn-success" name="updateStudent">Update</button>
                                            </form>
                                        </td>
                                        <td>
                                            <form :id="'deleteStud'+stud.id" @submit.prevent="deleteStudent(stud.id)">
                                                <button type="submit" class="btn btn-danger" name="deleteStudent">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                </template>
                            </template>
                        </tbody>
                    </table>

                    <!------------------------------------------------------- ADD STUDENT ------------------------------------------------------------>

                    <form :id="'addStud'+e.id" @submit.prevent="addStudent(e.id)">
                        <input type="text" name="student" class="form-control  form-control-sm">
                        <select name="studentGroup" class="form-control form-control-sm">
                            <option value="0" selected="selected">None</option>
                            <option v-for="index in parseInt(e.groups)" v-bind:value="index">Group {{index}}</option>
                        </select>
                        <button type="submit" class="btn btn-success" name="newStudent">Add New Student</button>
                    </form>
                </div>

                <!------------------------------------------------------- GROUP LIST ------------------------------------------------------------>

                <div class="row justify-content-center">
                    <template v-for="index in parseInt(e.groups)">
                        <div class="col-sm-1">
                            <table class="table table-bordered">
                                <tr>
                                    <th>Group {{index}}</th>
                                </tr>
                                <tr v-for="i in parseInt(e.students_per_group)">
                                    <td class="text-success" v-if="data.groups[e.id]['groups'][index][i-1] != null">{{data.groups[e.id]['groups'][index][i-1]}}</td>
                                    <td v-else>empty</td>
                                </tr>
                            </table>
                        </div>
                    </template>
                </div>

            </div>
        </template>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script type="module" src="view/script/script.js"></script>
</body>

</html>
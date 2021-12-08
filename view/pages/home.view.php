<!DOCTYPE html>
<html>
<?php require "view/_partials/head.view.php"; ?>

<body>

    <!--------------------------------------------------------- CREATE PROJECT ---------------------------------------------------------->

    <div class="container d-flex justify-content-center mb-4 mt-5">
        <form class="col-sm-4" method="POST">
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
        <div class="alert alert-info fixed-top text-center" v-if="info">
            <span>{{info}}</span>
        </div>

        <template v-for="(e, index) in data.projects">
            <div class="container border rounded border-secondary mb-4">
                <div class="row justify-content-center">
                    <div class="col-sm-3 text-center mt-4 mb-2">
                        <h4>Project <i>{{e.title}}</i></h4>
                    </div>
                </div>
                <div class="row justify-content-center mb-3">
                    <div class="col-sm-2 text-center">
                        <span>Groups: <b>{{e.groups}}</b></span>
                    </div>
                    <div class="col-sm-2 text-center">
                        <span>Students per group: <b>{{e.students_per_group}}</b></span>
                    </div>
                </div>

                <!------------------------------------------------------- STUDENT LIST ------------------------------------------------------------>

                <div class="row justify-content-center">
                    <div class="col-xl-7 col-sm">
                        <table class="table table-bordered table-sm table-responsive table-hover">
                            <thead class="table-dark">
                                <tr class="text-center">
                                    <th scope="col" class="col-3">Name</th>
                                    <th scope="col" class="col-2">Group</th>
                                    <th scope="col" class="col-1"></th>
                                    <th scope="col" class="col-1"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <template v-for="(stud, index) in data.students">
                                    <template v-if="e.id == stud.project">
                                        <tr class="table-secondary">
                                            <td class="align-middle px-2">{{stud.name}}</td>
                                            <td>
                                                <select name="studentGroup" class="form-control form-control-sm" :form="'updateStud'+stud.id">
                                                    <option value="0" v-if="stud.group == 0" selected="selected">None</option>
                                                    <option value="0" v-else>None</option>
                                                    <option v-for="index in parseInt(e.groups)" :selected="stud.group == index" :value="index">Group {{index}}</option>
                                                </select>
                                            </td>
                                            <input type="hidden" name="projectId" :value="e.id" :form="'updateStud'+stud.id">
                                            <td class="text-center">
                                                <form @submit.prevent="updateStudent(stud.id)" :id="'updateStud'+stud.id">
                                                    <button type="submit" class="btn btn-success btn-sm" name="updateStudent">Update</button>
                                                </form>
                                            </td>
                                            <td class="text-center">
                                                <form :id="'deleteStud'+stud.id" @submit.prevent="deleteStudent(stud.id)">
                                                    <button type="submit" class="btn btn-danger btn-sm" name="deleteStudent">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    </template>
                                </template>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!------------------------------------------------------- ADD STUDENT ------------------------------------------------------------>
                <div class="row justify-content-center mb-5">
                    <form :id="'addStud'+e.id" @submit.prevent="addStudent(e.id)" class="col-5">
                        <div class="row border rounded bg-light pt-2 pb-2">
                            <div class="col">
                                <input type="text" name="student" class="form-control  form-control-sm" placeholder="Student Name">
                            </div>
                            <div class="col">
                                <select name="studentGroup" class="form-control form-control-sm">
                                    <option value="0" selected="selected">None</option>
                                    <option v-for="index in parseInt(e.groups)" v-bind:value="index">Group {{index}}</option>
                                </select>
                            </div>
                            <div class="col">
                                <button type="submit" class="btn btn-success btn-sm" name="newStudent">Add New Student</button>
                            </div>
                        </div>
                    </form>
                </div>

                <!------------------------------------------------------- GROUP LIST ------------------------------------------------------------>

                <div class="row justify-content-center mb-3">
                    <template v-for="index in parseInt(e.groups)">
                        <div class="col-auto">
                            <table class="table table-bordered table-responsive text-nowrap">
                                <tr>
                                    <th scope="col" class="col-auto text-center">Group {{index}}</th>
                                </tr>
                                <tr v-for="i in parseInt(e.students_per_group)">
                                    <td class="text-success" v-if="data.groups[e.id]['groups'][index][i-1] != null">{{data.groups[e.id]['groups'][index][i-1]}}</td>
                                    <td v-else>Empty</td>
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
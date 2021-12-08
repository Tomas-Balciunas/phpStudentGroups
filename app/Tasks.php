<?php

namespace NFQ;

use PDO;
use PDOException;

class Tasks
{
    protected $pdo;
    private $title;
    private $groups;
    private $students;
    private $studentName;
    private $studentGroup;
    private $studentProject;
    private $updateGroup;
    private $studentId;
    private $deleteId;
    private $validationId;
    private $validationGroup;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    //------------------------------------------------- CREATE PROJECT ----------------------------------------------------

    public function createProject($post)
    {
        $this->title = htmlspecialchars(strip_tags($post['title']));
        $this->groups = htmlspecialchars(strip_tags($post['groups']));
        $this->students = htmlspecialchars(strip_tags($post['studentsPerGroup']));
        $this->execCreateProject();
    }

    public function execCreateProject()
    {
        try {
            $query = "INSERT INTO nfq.projects (`title`, `groups`, `students_per_group`) VALUES (:title, :groups, :students)";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':title', $this->title, PDO::PARAM_STR);
            $stmt->bindParam(':groups', $this->groups, PDO::PARAM_INT);
            $stmt->bindParam(':students', $this->students, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $msg) {
            throw $msg;
        }
    }

    //------------------------------------------------- STUDENT PROJECT LIST ----------------------------------------------------

    public function listProjects()
    {
        try {
            $query = "SELECT * FROM nfq.projects";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $msg) {
            throw $msg;
        }
    }

    //------------------------------------------------- STUDENT LIST ----------------------------------------------------

    public function listStudents()
    {
        try {
            $query = "SELECT * FROM nfq.students";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $msg) {
            throw $msg;
        }
    }

    //------------------------------------------------- ADD STUDENT TO A LIST ----------------------------------------------------

    public function addStudent($id, $post)
    {
        $this->studentName = htmlspecialchars(strip_tags($post['student']));
        $post['studentGroup'] == 0 ? $this->studentGroup = null : $this->studentGroup = htmlspecialchars(strip_tags($post['studentGroup']));
        $this->studentProject = $id;

        if ($this->freeGroup($id, $post['studentGroup'])) {
            $this->execAddStudent();
            return $msg['msg'] = "Student ".$this->studentName." added";
        } else {
            return $msg['msg'] = 'Selected group is full';
        }
    }

    public function execAddStudent()
    {
        try {
            $query = "INSERT INTO nfq.students (`name`, `project`, `group`) VALUES (:name, :project, :group)";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':name', $this->studentName, PDO::PARAM_STR);
            $stmt->bindParam(':project', $this->studentProject, PDO::PARAM_INT);
            $stmt->bindParam(':group', $this->studentGroup, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $msg) {
            throw $msg;
        }
    }

    //------------------------------------------------- STUDENT UPDATE ----------------------------------------------------

    public function updateStudent($id, $post)
    {
        $msg = [];
        $this->studentId = $id;
        $post['studentGroup'] == 0 ? $this->updateGroup = null : $this->updateGroup = htmlspecialchars(strip_tags($post['studentGroup']));

        if ($this->updateGroup == null) {
            $this->execUpdateStudent();
        } else {
            if ($this->freeGroup($post['projectId'], $post['studentGroup'])) {
                $this->execUpdateStudent();
                return $msg['msg'] = "Group changed";
            } else {
                return $msg['msg'] = 'Selected group is full';
            }
        }
    }

    public function execUpdateStudent()
    {
        try {
            $query = "UPDATE nfq.students SET `group` = :group WHERE id = :id";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':group', $this->updateGroup, PDO::PARAM_INT);
            $stmt->bindParam(':id', $this->studentId, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $msg) {
            throw $msg;
        }
    }

    //------------------------------------------------- DELETE STUDENT FROM THE LIST ----------------------------------------------------

    public function deleteStudent($id)
    {
        try {
            $this->deleteId = $id;
            $query = "DELETE FROM nfq.students WHERE id = :id";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':id', $this->deleteId, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $msg) {
            throw $msg;
        }
    }

    //------------------------------------------------- ARRAY THAT SORTS GROUPS ----------------------------------------------------

    public static function groups($pr, $st)
    {
        $array = [];

        foreach ($pr as $e) {
            $students = [];

            foreach ($st as $student) {
                if ($student['project'] == $e['id']) {
                    $students[] = ['name' => $student['name'], 'group' => $student['group']];
                }
            }

            for ($i = 1; $i <= $e['groups']; $i++) {
                $array[$e['id']]['groups'][$i] = [];
            }

            foreach ($students as $item) {
                if ($item['group'] != null) {
                    array_push($array[$e['id']]['groups'][$item['group']], $item['name']);
                }
            }
        }

        return $array;
    }

    //------------------------------------------------- CHECKS IF THE GROUP IS FREE ----------------------------------------------------

    public function freeGroup($project, $group)
    {
        $arr = [];
        $this->validationId = htmlspecialchars(strip_tags($project));
        $this->validationGroup = htmlspecialchars(strip_tags($group));
        $query = "SELECT students_per_group FROM nfq.projects WHERE id = :id; SELECT * FROM nfq.students WHERE project = :id AND `group` = :group";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $this->validationId, PDO::PARAM_INT);
        $stmt->bindParam(':group', $this->validationGroup, PDO::PARAM_INT);
        $stmt->execute();
        $arr['count'] = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->nextRowset();
        $arr['list'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (sizeof($arr['list']) < $arr['count']['students_per_group']) {
            return true;
        } else {
            return false;
        }
    }
}

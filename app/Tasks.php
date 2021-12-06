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

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    public function createProject($post)
    {
        $this->title = $post['title'];
        $this->groups = $post['groups'];
        $this->students = $post['studentsPerGroup'];
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

    public function addStudent($id, $post)
    {
        $this->studentName = $post['student'];
        if ($post['studentGroup'] == 0) {
            $this->studentGroup = null;
        } else {
            $this->studentGroup = $post['studentGroup'];
        }
        $this->studentProject = $id;
        $this->execAddStudent();
    }

    public function execAddStudent () {
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

    public function updateStudent($id, $post)
    {
        $this->studentId = $id;
        if ($post['studentGroup'] == 0) {
            $this->updateGroup = null;
        } else {
            $this->updateGroup = $post['studentGroup'];
        }
        $this->execUpdateStudent();
    }

    public function execUpdateStudent () {
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

    public static function groups ($pr, $st) {
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
}

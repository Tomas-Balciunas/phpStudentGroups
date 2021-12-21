<?php

namespace NFQ;

class Validation
{

    private static $errors = [];

    public static function project($post)
    {
        self::title($post['title']);
        self::groups($post['groups']);
        self::studentsPerGroup($post['studentsPerGroup']);

        return self::$errors;
    }

    public static function newStudent($post) {
        self::student($post['student']);

        return self::$errors;
    }

    private static function title($e)
    {
        $val = preg_match('/^[a-zA-ZąčęėįšųūžĄČĘĖĮŠŲŪŽ0-9 ]{3,25}$/', $e);

        if (empty($e)) {
            Validation::$errors['name'] = 'Title field is empty';
        } elseif (!$val) {
            Validation::$errors['name'] = 'Title can only contain letters and numbers';
        } else {
            Validation::$errors['name'] = '';
        }
    }

    private static function groups($e)
    {
        $val = preg_match('/^(?:[1-9]|[1-2][0-9]|30)$/', $e);

        if (empty($e)) {
            Validation::$errors['groups'] = 'Groups field is empty';
        } elseif (!$val) {
            Validation::$errors['groups'] = 'Groups can only contain numbers from 1 to 30';
        } else {
            Validation::$errors['groups'] = '';
        }
    }

    private static function studentsPerGroup($e)
    {
        $val = preg_match('/^(?:[1-9]|[1-2][0-9]|30)$/', $e);

        if (empty($e)) {
            Validation::$errors['stpergroup'] = 'Students per group field is empty';
        } elseif (!$val) {
            Validation::$errors['stpergroup'] = 'Students per group can only contain numbers from 1 to 30';
        } else {
            Validation::$errors['stpergroup'] = '';
        }
    }

    private static function student ($e) {
        $val = preg_match('/^[a-zA-ZąčęėįšųūžĄČĘĖĮŠŲŪŽ ]{3,50}$/', $e);

        if (empty($e)) {
            Validation::$errors['student'] = 'Name field is empty';
        } elseif (!$val) {
            Validation::$errors['student'] = 'Name can only contain letters';
        } else {
            Validation::$errors['student'] = '';
        }
    }
}

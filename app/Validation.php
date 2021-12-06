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

    private static function title($e)
    {
        $val = preg_match('/^[a-zA-ZąčęėįšųūžĄČĘĖĮŠŲŪŽ0-9 ]{3,50}$/', $e);

        if (!$val) {
            Validation::$errors['name'] = 'Title can only contain letters and numbers';
        } else {
            Validation::$errors['name'] = '';
        }
    }

    private static function groups($e)
    {
        $val = preg_match('/^[0-9]{1,3}$/', $e);

        if (!$val) {
            Validation::$errors['phone'] = 'Groups can only contain numbers';
        } else {
            Validation::$errors['phone'] = '';
        }
    }

    private static function studentsPerGroup($e)
    {
        $val = preg_match('/^[0-9]{1,3}$/', $e);

        if (!$val) {
            Validation::$errors['phone'] = 'Students per group can only contain numbers';
        } else {
            Validation::$errors['phone'] = '';
        }
    }
}

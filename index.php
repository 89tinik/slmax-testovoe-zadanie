<?php

use App\ListUser;
use App\User;

require_once('vendor/autoload.php');
ini_set('display_errors', 1);
try {
    //создание пользователя
    $user = new User([
        'name' => 'firstname',
        'lastname' => 'lastname',
        'dob' => '1989-06-07',
        'sex' => '1',
        'city' => 'London'
    ]);

    ////получение пользователя
    //$user = new User(1);

    ////изменение данных и сохранение
    //$user->name = 'newName';
    //    $user->save();

    ////удаление пользователя
    //$user->deleteUser();

    //отформатированные данные
    $formatObject = $user->userFormater();

    //создание списка пользователей
    $users = new ListUser(10, '>');

    //массив пользователей
    var_dump($users->getUsers());

    $users->deleteUsers();

} catch (Exception $e) {
    echo $e->getMessage();
}

<?php

namespace App;

class ListUser
{
    /**
     * @var PDO
     */
    protected $db;
    /**
     * @var sting
     */
    protected $table = 'user';
    /**
     * @var array
     */
    protected array $userIds = [];

    /**
     * @param int $operand
     * @param string $operator
     * @throws \Exception
     */
    public function __construct(int $operand, string $operator)
    {
        if (!class_exists('App\User')){
            throw new \Exception('Класс User не найден!');
        }
        if (!in_array($operator, ['>', '<', '!='])){
            throw new \Exception('Operator not in [>, <, !=]');
        }
        $this->db = new DB();
        $data = $this->db->selectByListId($this->table, $operand, $operator);
        foreach ($data as $arr){
            $this->userIds[] = $arr['id'];
        }
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function getUsers()
    {
        $userArr = [];
        foreach ($this->userIds as $id){
            $userArr[] = new User($id);
        }
        return $userArr;
    }

    /**
     * @return void
     * @throws \Exception
     */
    public function deleteUsers()
    {
        foreach ($this->userIds as $id){
            $user = new User($id);
            $user->deleteUser();
        }
    }
}
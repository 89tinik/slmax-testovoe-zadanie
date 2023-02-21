<?php

namespace App;

use Exception;
use PDO;

class DB
{
    /**
     * @var PDO
     */
    protected $db;

    public function __construct()
    {
        $this->db = new PDO('mysql:host=db;dbname=magento;charset=utf8', 'magento', 'magento');

    }

    /**
     * @param string $table
     * @param int $id
     * @return mixed
     */
    public function selectById(string $table, int $id)
    {
        $sql = 'SELECT * FROM ' . $table . ' WHERE id = :id';
        $sth = $this->db->prepare($sql);
        $sth->execute(['id' => $id]);
        return $sth->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * @param string $table
     * @param array $data
     * @return false|string
     * @throws Exception
     */
    public function create(string $table, array $data)
    {
        $sql = 'INSERT INTO `' . $table . '` (' . implode(', ', array_keys($data)) . ') VALUE (:' . implode(', :', array_keys($data)) . ')';
        $sth = $this->db->prepare($sql);
        if ($sth->execute($data)) {
            return $this->db->lastInsertId();
        } else {
            throw new Exception("Error create!");
        }
    }

    /**
     * @param string $table
     * @param array $data
     * @return void
     * @throws Exception
     */
    public function updateData(string $table, array $data)
    {
        $sqlArr = [];
        $insertData = [];
        foreach ($data as $k => $v) {
            $sqlArr[] = '`' . $k . '`=:' . $k;
            $insertData[$k] = $v;
        }
        $sth = $this->db->prepare('UPDATE `' . $table . '` SET ' . implode(',', $sqlArr) . ' WHERE `id`=:id');
        if (!$sth->execute($insertData)) {
            throw new Exception("Error update!");
        }
    }

    /**
     * @param string $table
     * @param int $id
     * @return void
     */
    public function deleteById(string $table, int $id)
    {
        $sth = $this->db->prepare('DELETE FROM ' . $table . ' WHERE `id`=:user_id');
        $sth->execute(['user_id' => $id]);
    }


    /**
     * @param string $table
     * @param int $id
     * @param string $operator
     * @return array|false
     */
    public function selectByListId(string $table, int $id, string $operator)
    {
        $sql = 'SELECT id FROM ' . $table . ' WHERE id '.$operator.' :id';
        $sth = $this->db->prepare($sql);
        $sth->execute(['id' => $id]);
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
}
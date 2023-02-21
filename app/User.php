<?php

namespace App;

use Exception;

class User
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
     * @var int
     */
    protected $id;
    /**
     * @var string
     */
    public $name;
    /**
     * @var string
     */
    public $lastname;
    /**
     * @var string
     */
    public $dob;
    /**
     * @var int
     */
    public $sex;
    /**
     * @var string
     */
    public $city;

    /**
     * @param int | array $data
     * @throws Exception
     */
    public function __construct($data)
    {
        $this->db = new DB();
        if (is_array($data)) {
            if ($this->validate($data)) {
                $this->created($data);
            }
        } else {
            $this->findById($data);
        }

    }

    /**
     * @param array $data
     * @return void
     * @throws Exception
     */
    protected function created(array $data)
    {
        if ($this->validate($data)) {
            $data['id'] = $this->db->create($this->table, $data);
            $this->setData($data);
        }
    }

    /**
     * @return void
     * @throws Exception
     */
    public function save()
    {
        $data = $this->userDataToArray();
        $this->db->updateData($this->table, $data);
    }

    /**
     * @return void
     */
    public function deleteUser()
    {
        $this->db->deleteById($this->table, $this->id);
    }

    /**
     * @return object
     */
    public function userFormater()
    {
        $data = $this->userDataToArray();
        $data['sex'] = self::sexToText($this->sex);
        $data['dob'] = self::calculateAge($this->dob);
        return (object) $data;
    }

    /**
     * @param string $date
     * @return int
     */
    public static function calculateAge(string $date)
    {
        $birthday_timestamp = strtotime($date);
        $age = date('Y') - date('Y', $birthday_timestamp);
        if (date('md', $birthday_timestamp) > date('md')) {
            $age--;
        }
        return $age;
    }

    /**
     * @param int $sex
     * @return string
     */
    public static function sexToText(int $sex)
    {
        return ($sex) ? 'муж.' : 'жен.';
    }

    /**
     * @param array $data
     * @return void
     */
    protected function setData(array $data)
    {
        $this->id = $data['id'];
        $this->name = $data['name'];
        $this->lastname = $data['lastname'];
        $this->dob = $data['dob'];
        $this->sex = $data['sex'];
        $this->city = $data['city'];
    }

    /**
     * @param int $id
     * @return void
     */
    protected function findById(int $id)
    {
        $data = $this->db->selectById($this->table, $id);
        if (!empty($data)) {
            $this->setData($data);
        }
    }

    /**
     * @param array $data
     * @return true
     * @throws Exception
     */
    protected function validate(array $data)
    {
        if (!empty($data['name']) && !ctype_alpha($data['name'])) {
            throw new Exception('Имя должно содержать только буквы.');
        }
        if (!empty($data['lastname']) && !ctype_alpha($data['lastname'])) {
            throw new Exception('Фамилия должна содержать только буквы.');
        }
        if (!in_array($data['sex'], [0, 1])) {
            throw new Exception('Пол может быть только 0 или 1');
        }
        return true;
    }

    /**
     * @return array
     */
    protected function userDataToArray()
    {
        $data = get_object_vars($this);
        unset($data['db']);
        unset($data['table']);
        return $data;
    }
}
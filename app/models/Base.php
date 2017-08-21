<?php
/**
 * Created by PhpStorm.
 * User: alcorrius
 * Date: 20.08.17
 * Time: 17:15
 */

namespace models;
use core\Database;

abstract class Base
{
    protected $table = null;

    public function getItem($id = null) {
        $db = Database::DB();
        $sql = "SELECT * from {$this->table} where id= :id)";
        $s = $db->prepare($sql);
        $s->bindValue(':id', intval($id), \PDO::PARAM_INT);
        $result = $s->fetch();

        return $result;
    }
}
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
	function __construct()
	{
		$this->db = Database::DB();
	}

	protected $table = null;

    private function checkItem($name)
	{
		$s = $this->db->prepare("SELECT * FROM {$this->table} WHERE name= :name");
		$s->bindValue(':name', strval($name), \PDO::PARAM_STR);
		$s->execute();
		$row = $s->fetch();

		return $row;
	}

    public function getItem($id = null) {
        $sql = "SELECT * from {$this->table} where id= :id";
        $s = $this->db->prepare($sql);
        $s->bindValue(':id', intval($id), \PDO::PARAM_INT);
        $result = $s->fetch();

        return $result;
    }

	public function addItem($item)
	{
		$checkItem = $this->checkItem($item);
		if($checkItem){
			return $checkItem['id'];
		}

		$sql = "INSERT INTO {$this->table}(id, name) VALUES (null, :name)";
		$s = $this->db->prepare($sql);
		$s->bindValue(':name', strval($item), \PDO::PARAM_STR);
		$result = $s->execute();

		return $result == true ? $this->db->lastInsertId() : null;
	}
}
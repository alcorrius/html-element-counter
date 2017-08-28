<?php
/**
 * Created by PhpStorm.
 * User: alcorrius
 * Date: 20.08.17
 * Time: 17:11
 */

namespace models;

use core\Database;


class Request extends Base
{
	protected $table = 'request';

	public function addItem($domain_id, $url_id = null, $element_id = null, $count=null, $time = null, $duration = null)
	{
		$db = Database::DB();
		$sql = "INSERT INTO {$this->table}(id, domain_id, url_id, element_id, count, time, duration) VALUES (null, :domain_id, :url_id, :element_id, :count, :time, :duration)";
		$s = $db->prepare($sql);
		$s->bindValue(':domain_id', intval($domain_id), \PDO::PARAM_INT);
		$s->bindValue(':url_id', intval($url_id), \PDO::PARAM_STR);
		$s->bindValue(':element_id', intval($element_id), \PDO::PARAM_INT);
		$s->bindValue(':count', intval($count), \PDO::PARAM_INT);
		$s->bindValue(':time', $time);
		$s->bindValue(':duration', strval($duration), \PDO::PARAM_STR);
		$result = $s->execute();

		return $result;
	}

	public function getLastRequest($url_id, $element_id)
	{
		$db = Database::DB();
		$sql = "SELECT request.*, url.name as url_name, element.name as element_name from {$this->table} join url on url.id = request.url_id join element on element.id = request.element_id where url_id= :url_id and element_id= :element_id ORDER BY id DESC LIMIT 1";
		$s = $db->prepare($sql);
		$s->bindValue(':url_id', intval($url_id), \PDO::PARAM_INT);
		$s->bindValue(':element_id', intval($element_id), \PDO::PARAM_INT);
		$s->execute();
		$result = $s->fetch();

		return $result;
	}

	public function getTotalUrlByDomainId($domain_id)
	{
		$db = Database::DB();
		$sql = "SELECT count(distinct url_id) as count from {$this->table} where domain_id= :domain_id";
		$s = $db->prepare($sql);
		$s->bindValue(':domain_id', intval($domain_id), \PDO::PARAM_INT);
		$s->execute();
		$result = $s->fetch();

		return $result;
	}

	public function getAvgFetchTimeByDomainId24h($domain_id)
	{
		$time = new \DateTime();
		$time->sub(new \DateInterval('P1D'));
		$db = Database::DB();
		$sql = "SELECT avg(duration) as avg from {$this->table} where domain_id= :domain_id and time > :time";
		$s = $db->prepare($sql);
		$s->bindValue(':domain_id', intval($domain_id), \PDO::PARAM_INT);
		$s->bindValue(':time', $time->format('Y-m-d H:i'));
		$s->execute();
		$result = $s->fetch();

		return $result;
	}

	public function getTotalElementByDomainId($domain_id, $element_id)
	{
		$db = Database::DB();
		$sql = "SELECT sum(count) as sum from (select * from {$this->table} where domain_id= :domain_id and element_id= :element_id group by url_id, element_id) as t1";
		$s = $db->prepare($sql);
		$s->bindValue(':domain_id', intval($domain_id), \PDO::PARAM_INT);
		$s->bindValue(':element_id', intval($element_id), \PDO::PARAM_INT);
		$s->execute();
		$result = $s->fetch();

		return $result;
	}

	public function getTotalElement($element_id)
	{
		$db = Database::DB();
		$sql = "SELECT sum(count) as sum from (select * from {$this->table} where element_id= :element_id group by url_id, element_id) as t1";
		$s = $db->prepare($sql);
		$s->bindValue(':element_id', intval($element_id), \PDO::PARAM_INT);
		$s->execute();
		$result = $s->fetch();

		return $result;
	}
}
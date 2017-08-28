<?php
/**
 * Created by PhpStorm.
 * User: alcorrius
 * Date: 20.08.17
 * Time: 11:01
 */

namespace controllers;

use core\Parser;
use models\Request;
use models\Url;
use models\Element;
use models\Domain;

class CounterController
{
	function __construct() {
		$this->request = new Request();
	}

    public function count() {
        $url_name = isset($_GET['url']) ? $_GET['url'] : null;
        $element_name = isset($_GET['element']) ? $_GET['element'] : null;

        if($url_name && $element_name) {
			$parsed_url = parse_url($url_name);
			if (empty($parsed_url['scheme'])) {
				$url_name = 'http://' . ltrim($url_name, '/');
			}
			$parsed_url = parse_url($url_name);
			$domain = isset($parsed_url['host']) ? $parsed_url['host'] : '';

			$domainModel = new Domain();
			$domainID = $domainModel->addItem($domain);

			$urlModel = new Url();
			$urlID = $urlModel->addItem($url_name);

			$elementModel = new Element();
			$elementID = $elementModel->addItem($element_name);

			$lastRequest = $this->request->getLastRequest($urlID, $elementID);

			if(!isset($lastRequest['time']) || (strtotime($lastRequest['time']) < strtotime("-5 minutes"))) {
				$parser = new Parser();

				if($parser->checkUrl($url_name)) {
					$response = $parser->getPageContent($url_name);

					$dom = new \DOMDocument('1.0', 'UTF-8');

					// set error level
					$internalErrors = libxml_use_internal_errors(true);
					$dom->loadHTML($response['content']);
					libxml_use_internal_errors($internalErrors);

					$elements = $dom->getElementsByTagName($element_name);

					$count = $elements->length;
					$date = date("Y-m-d H:i");
					$response_time = isset($response['header']['total_time']) ? $response['header']['total_time'] : null;

					$this->request->addItem($domainID, $urlID, $elementID, $count, $date, $response_time);
				} else {
					echo json_encode(array('success' => false, 'message' => 'Wrong URL'));
					die();
				}
			} else {
				$date = $lastRequest['time'];
				$response_time = $lastRequest['duration'];
				$count = $lastRequest['count'];
			}

			$statistic = $this->getGeneralStatistic($domainID, $elementID);
			$result = compact('count', 'url_name', 'element_name', 'date', 'response_time', 'statistic', 'domain');

			echo json_encode($result);
			die();
        }

        echo json_encode(array('success' => false, 'message' => 'Empty parameters'));
        die();
    }

    private function getGeneralStatistic($domain_id = null, $element_id = null)
	{
		$totalUrlRequest = $this->request->getTotalUrlByDomainId($domain_id);
		$totalUrl = isset($totalUrlRequest['count']) ? $totalUrlRequest['count'] : null;

		$avgTimeRequest = $this->request->getAvgFetchTimeByDomainId24h($domain_id);
		$avgTime = isset($avgTimeRequest['avg']) ? $avgTimeRequest['avg'] : null;

		$totalElementRequest = $this->request->getTotalElementByDomainId($domain_id, $element_id);
		$totalElement = isset($totalElementRequest['sum']) ? $totalElementRequest['sum'] : null;

		$totalElementByIdRequest = $this->request->getTotalElement($element_id);
		$totalElementById = isset($totalElementByIdRequest['sum']) ? $totalElementByIdRequest['sum'] : null;

		return compact('totalUrl', 'avgTime', 'totalElement', 'totalElementById');
	}
}
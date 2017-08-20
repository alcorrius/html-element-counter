<?php
/**
 * Created by PhpStorm.
 * User: alcorrius
 * Date: 20.08.17
 * Time: 11:01
 */

namespace controllers;

use core\Parser;

class CounterController
{
    public function count() {

        $url = isset($_GET['url']) ? $_GET['url'] : null;
        $element = isset($_GET['element']) ? $_GET['element'] : null;

        if($url && $element) {
            $parser = new Parser();

            if($parser->checkUrl($url)) {
                $response = $parser->getPageContent($url);

                $dom = new \DOMDocument('1.0', 'UTF-8');

                // set error level
                $internalErrors = libxml_use_internal_errors(true);
                $dom->loadHTML($response['content']);
                libxml_use_internal_errors($internalErrors);

                $elements = $dom->getElementsByTagName($element);

                $count = $elements->length;
                $date = date("d/m/Y H:i");
                $response_time = isset($response['header']['total_time']) ? $response['header']['total_time'] : null;

                $result = compact('count', 'url', 'element', 'date', 'response_time');

                echo json_encode($result);
            }

            return "fuck2";
        }

        return "fuck1";
    }
}
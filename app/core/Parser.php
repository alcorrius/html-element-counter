<?php
/**
 * Created by PhpStorm.
 * User: alcorrius
 * Date: 20.08.17
 * Time: 10:58
 */

namespace core;


class Parser
{
    protected $userAgent = 'Mozilla/5.0 (Windows NT 6.1; rv:8.0) Gecko/20100101 Firefox/8.0';

    function checkUrl($url)
    {
        $options = array(
            CURLOPT_USERAGENT      => $this->userAgent, //set user agent
            CURLOPT_HEADER         => true,    // return headers
            CURLOPT_NOBODY         => true,    // don't need body
            CURLOPT_RETURNTRANSFER => true,    //
            CURLOPT_CONNECTTIMEOUT => 60,     // timeout on connect
            CURLOPT_TIMEOUT        => 60,     // timeout on response
        );

        $curlHandle = curl_init($url);

        curl_setopt_array($curlHandle, $options);

        curl_exec($curlHandle);
        $response = curl_getinfo($curlHandle, CURLINFO_HTTP_CODE);
        curl_close($curlHandle);

        return ($response >= 200 && $response < 400) ? true : false;
    }

    function getPageContent($url)
    {
        $options = array(
            CURLOPT_CUSTOMREQUEST  =>"GET",        //set request type post or get
            CURLOPT_POST           =>false,        //set to GET
            CURLOPT_USERAGENT      => $this->userAgent, //set user agent
            CURLOPT_COOKIEFILE     =>"cookie.txt", //set cookie file
            CURLOPT_COOKIEJAR      =>"cookie.txt", //set cookie jar
            CURLOPT_RETURNTRANSFER => true,     // return web page
            CURLOPT_HEADER         => false,    // don't return headers
            CURLOPT_FOLLOWLOCATION => true,     // follow redirects
            CURLOPT_ENCODING       => "",       // handle all encodings
            CURLOPT_AUTOREFERER    => true,     // set referer on redirect
            CURLOPT_CONNECTTIMEOUT => 60,      // timeout on connect
            CURLOPT_TIMEOUT        => 60,      // timeout on response
            CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
        );

        $ch = curl_init($url);
        curl_setopt_array($ch, $options);
        $content = curl_exec($ch);
        $header = curl_getinfo($ch);
        curl_close($ch);

        return array('content' => $content,
                     'header' => $header);
    }
}
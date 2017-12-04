<?php
/**
 * This file is part of the Compos Mentis Inc.
 * PHP version 7+ (c) 2017 CMI
 *
 * Copyright and license information can be found at LICENSE
 * distributed with this package.
 *
 * @category Class
 * @package  Update
 * @author   Joussyd Calupig <joussydmcalupig@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */
namespace Lethia\Solr;

class Update extends Base
{
    /* Constants
    ---------------------------------------------*/
    const CACHE_CONTROL = 'Cache-Control: no-cache';
    const CONTENT_TYPE  = 'content-type: application/json';
    const UPDATE_URL    = '/solr/%s/update/%s/docs?commit=true';
    const USER_AGENT    = '';

    /* Protected Properties
    ---------------------------------------------*/
    protected $dataType = 'json';

    /* Private Properties
    ---------------------------------------------*/
    /* Constructor
    ---------------------------------------------*/
    /* Magic Methods
    ---------------------------------------------*/
    /* Public Methods
    ---------------------------------------------*/
    /**
    * Execute
    *
    * @return _execute method
    */
    public function execute()
    {
        return $this->_execute();
    }

    /* Protected Methods
    ---------------------------------------------*/
    /* Private Methods
    ---------------------------------------------*/
    /**
    * _execute
    *
    * @return json $response Response
    */
    private function _execute()
    {
        //convert data into json
        $data = json_encode($this->data);

        //build url
        $url = $this->host . ':' . $this->port . sprintf(self::UPDATE_URL, $this->core, $this->dataType);

        //initialize curl request
        $ch = curl_init();

        //set request url
        curl_setopt($ch, CURLOPT_URL, $url);

        //set to return the result on success and 'false' on failure
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        //set request's post data
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        //set the request type to HTTP POST
        curl_setopt($ch, CURLOPT_POST, 1);

        //build headers
        $headers = array();
        $headers[] = "Cache-Control: no-cache";
        $headers[] = "Content-Type: application/json";
        //set http headers
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // decode curl response to json
        $response = json_decode(curl_exec($ch), true);

        // get the request's return code
        $http_code = curl_getinfo($ch,CURLINFO_HTTP_CODE);

        // check if the return code is OK
        if($http_code != 200) {
            throw new \Exception('Error: Failed to recieve response from ' . $url);
        }

        // close the connection
        curl_close($ch);

        // return response
        return $response;
    }
}
<?php
/**
 * This file is part of the Compos Mentis Inc.
 * PHP version 7+ (c) 2017 CMI
 *
 * Copyright and license information can be found at LICENSE
 * distributed with this package.
 *
 * @category Class
 * @package  Search
 * @author   Joussyd Calupig <joussydmcalupig@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */
namespace Lethia\Solr;

class Search extends Base
{
    /* Constants
    ---------------------------------------------*/
    const UPDATE_URL    = '/solr/%s/select';

    /* Protected Properties
    ---------------------------------------------*/
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
        //get query strings
        $queryString = $this->_buildQuery();
        //get filters
        $filterQuery = $queryString['fqs'];
        //unset filters in the query srings
        unset($queryString['fqs']);

        $filters = '';
        foreach ($filterQuery as $value) {
            $filters .= 'fq' . '=' . $value;
        }

        //convert data into json
        $data = json_encode($this->data);
        //build url
        $url = $this->host . ':' . $this->port   . sprintf(self::UPDATE_URL, $this->core);
        //append query strings in the url
        $url = $url . '?' . http_build_query($queryString);
        //initialize curl request
        $ch = curl_init();
        //set request url
        curl_setopt($ch, CURLOPT_URL, $url);
        //set to return the result on success and 'false' on failure
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //set GET HTTP Request
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        //build headers
        $headers = array();
        //set header cache control
        $headers[] = $this->cacheControl;
        //set header content type
        $headers[] = $this->contentType;
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


    /**
    * Build Query
    *
    * @return array $queryString Query String
    */
    private function _buildQuery()
    {
        $queryString = array();
        //set query
        $q = $this->query;
        //set definition type
        $defType = $this->defType;
        //set field list
        $fl = implode(' ', $this->fieldList);
        //set filters
        $fqs = $this->filterQuery;
        //define  queryfield
        $qf = '';
        //set sort
        $sort = implode(' ', $this->sort[0]);
        //set pagination
        $start = $this->start;
        //set results per page
        $rows = $this->rows;
        //set Query Fields
        foreach ($this->queryField as $key => $value) {
            $qf .= $key . '^' . $value . ' ';
        }

        //set query strings
        $queryString['q']       = $q;
        $queryString['defType'] = $defType;
        $queryString['fl']      = $fl;
        $queryString['qf']      = $qf;
        $queryString['fqs']     = $fqs;
        $queryString['sort']    = $sort;
        $queryString['start']   = $start;
        $queryString['rows']    = $rows;
        //return Query String
        return $queryString;
    }
}
<?php
/**
 * This file is part of the Compos Mentis Inc.
 * PHP version 7+ (c) 2017 CMI
 *
 * Copyright and license information can be found at LICENSE
 * distributed with this package.
 *
 * @category Class
 * @package  Base
 * @author   Joussyd Calupig <joussydmcalupig@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */
namespace Lethia\Solr;
use Lethia\Solr\Factory;

class Base
{
    /* Constants
    ---------------------------------------------*/
    /* Protected Properties
    ---------------------------------------------*/
    protected $core = null;
    protected $data = array();
    protected $host = null;
    protected $user = null;
    protected $pass = null;
    protected $port = null;

    //Search criteria
    protected $defType     = null;
    protected $fieldList   = null;
    protected $filterQuery = array();
    protected $query       = null;
    protected $queryField  = null;
    protected $sort        = null;
    protected $start       = null;
    protected $rows        = null;

    /* Private Properties
    ---------------------------------------------*/
    /* Constructor
    ---------------------------------------------*/
    public function __construct($host, $user, $pass, $port)
    {
        //set the host
        $this->host = $host;

        //set the user
        $this->user = $user;

        //set the password
        $this->pass = $pass;

        //set the port
        $this->port = $port;
    }

    /* Magic Methods
    ---------------------------------------------*/
    public function __call($name, $args)
    {
        //check if the method called is 'setField'
        if ($name == 'setField') {
            //set the parameters in data
            $this->data[$args[0]] = $args[1];
        }
        //check if the method called is 'filterQueryBy'
        if ($name == 'filterQueryBy') {
            //set query parameters
            $this->filterQuery[] = $args[0] . ':\'' . $args[1] . '\'';
        }
        //check if the method called is 'onField'
        if ($name == 'onField') {
            $this->queryField[$args[0]] = $args[1];
        }
        //check if the method called is 'sort'
        if ($name == 'sort') {
            $this->sort[] = $args;
        }
        //check if the method called is 'return Field'
        if ($name == 'returnField') {
            $this->fieldList[] = $args[0];
        }
        
        return $this;
    }

    /* Public Methods
    ---------------------------------------------*/
    /**
    * SetData 
    *
    * @param  array $data  Data
    */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
    * Set Core
    *
    * @param  string $core Solr Core
    * @return $this
    */
    public function setCore($core)
    {
        $this->core = $core;

        return $this;
    }

     /**
    * Set Query
    *
    * @param  string $q Search Query
    * @return $this
    */
    public function setQuery($q)
    {
        $this->query = $q;

        return $this;
    }

     /**
    * Set Start
    *
    * @param  integer $start Number the result will start (page)
    * @return $this
    */
    public function setStart($start)
    {
        $this->start = $start;

        return $this;
    }

     /**
    * Set Rows
    *
    * @param  integer $rows Number of result per page
    * @return $this
    */
    public function setRows($rows)
    {
        $this->rows = $rows;

        return $this;
    }

     /**
    * Definition Type
    *
    * @param  string $type Definition Type
    * @return $this
    */
    public function defType($type)
    {
        $this->defType = $type;

        return $this;
    }


    /* Protected Methods
    ---------------------------------------------*/
    /* Private Methods
    ---------------------------------------------*/
}
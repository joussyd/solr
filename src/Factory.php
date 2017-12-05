<?php
/**
 * This file is part of the Compos Mentis Inc.
 * PHP version 7+ (c) 2017 CMI
 *
 * Copyright and license information can be found at LICENSE
 * distributed with this package.
 *
 * @category Class
 * @package  Factory
 * @author   Joussyd Calupig <joussydmcalupig@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */
namespace Lethia\Solr;
use Lethia\Solr\Search;
use Lethia\Solr\Update;

class Factory
{
    /* Constants
    ---------------------------------------------*/
    /* Protected Properties
    ---------------------------------------------*/
    //solr conection
    protected $host = 'http://localhost';
    protected $user = '';
    protected $pass = '';
    protected $port = '8983';

    /* Private Properties
    ---------------------------------------------*/
    /* Constructor
    ---------------------------------------------*/
    /**
    * Factory constructor
    *
    */
    public function __construct()
    {
        //get the arguments
        $args = func_get_args();

        //set the host
        $this->host = isset($args[0]) ? $args[0] : $this->host;

        //set the user
        $this->user = isset($args[1]) ? $args[1] : $this->user;

        //set the pass
        $this->pass = isset($args[2]) ? $args[2] : $this->pass;

        //set the port
        $this->port = isset($args[3]) ? $args[3] : $this->port;
    }

    /* Public Methods
    ---------------------------------------------*/
    /**
    * Update Core
    *
    * @param  array $data  Data
    * @return Update class
    */
    public function update($data = array())
    {
        //initialize the update class
        $update = new Update($this->host, $this->user, $this->pass, $this->port);
        //if the data is not empty
        if(!empty($data)) {
            //set the data
            $update->setData($data);
        }

        return $update;
    }

    /**
    * Delete doc
    *
    * @param  array $data  Data
    * @return Delete class
    */
    public function delete($data = array())
    {
        //initialize the update class
        $delete = new Delete($this->host, $this->user, $this->pass, $this->port);
        //if the data is not empty
        if(!empty($data)) {
            //set the data
            $delete->setData($data);
        }

        return $delete;
    }

    /**
    * Search doc
    *
    * @param  string $data Search query
    * @return Search class
    */
    public function search($data = null)
    {
        //initialize the search class
        $search = new Search($this->host, $this->user, $this->pass, $this->port);
        //if the data is not empty
        if($data) {
            //set the data
            $search->setQuery($data);
        }

        return $search;
    }


    /* Protected Methods
    ---------------------------------------------*/
    /* Private Methods
    ---------------------------------------------*/
}
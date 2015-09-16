<?php
/**
 * Created by PhpStorm.
 * User: taminev
 * Date: 21.03.2015
 * Time: 10:47
 */

class Article extends Publication{

    private $journal;

    private $number;

    private $pages;

    public function __construct($author,$title,$year,$journal){
        parent::__construct($author,$title,$year);
        $this->setJournal($journal);
    }

    /**
     * @return mixed
     */
    public function getJournal()
    {
        return $this->journal;
    }

    /**
     * @param mixed $journal
     */
    public function setJournal($journal)
    {
        $this->journal = $journal;
    }

    /**
     * @return mixed
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @param mixed $number
     */
    public function setNumber($number)
    {
        $this->number = $number;
    }

    /**
     * @return mixed
     */
    public function getPages()
    {
        return $this->pages;
    }

    /**
     * @param mixed $pages
     */
    public function setPages($pages)
    {
        $this->pages = $pages;
    }



}
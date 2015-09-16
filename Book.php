<?php
/**
 * Created by PhpStorm.
 * User: taminev
 * Date: 21.03.2015
 * Time: 10:51
 */

class Book extends Publication{
    private $publisher;

    public function __construct($author,$title,$year,$publisher){
        parent::__construct($author,$title,$year);
        $this->setPublisher($publisher);
    }

    /**
     * @return mixed
     */
    public function getPublisher()
    {
        return $this->publisher;
    }

    /**
     * @param mixed $publisher
     */
    public function setPublisher($publisher)
    {
        $this->publisher = $publisher;
    }


}
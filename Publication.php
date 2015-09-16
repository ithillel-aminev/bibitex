<?php
/**
 * Created by PhpStorm.
 * User: taminev
 * Date: 21.03.2015
 * Time: 10:53
 */

abstract class Publication {
    protected $author;

    protected $title;

    protected $year;

    protected $volume;

    public function __construct($author,$title,$year){
        $this->setAuthor($author);
        $this->setTitle($title);
        $this->setYear($year);
    }

    public function getClass(){
        return get_called_class();
    }

    /**
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param mixed $authorData
     */
    public function setAuthor($authorData)
    {
        $authorStrings = array_filter(preg_split("/and/",$authorData));
        $authors = array();
        foreach($authorStrings as $authorStr){
            $author = array_filter(preg_split("/[\s]+/",$authorStr));
            array_unshift($author,array_pop($author));
            $authors[] = $author;
        }
        usort($authors,'Publication::compareAuthors');

        foreach($authors as $key=>$author){
            $author = array_values($author);
            $val = $author[0];
            for($i=1;$i<count($author);$i++){
                $val .= ' '.substr($author[$i],0,1).'.';
            }
            $authors[$key] = $val;
        }

        $this->author = implode(", ",$authors);
    }

    public static function compareAuthors($a,$b){
        $a = array_values($a);
        $b = array_values($b);
        $aCount = count($a);
        $bCount = count($b);
        $max = ($aCount<$bCount)  ? $aCount : $bCount;

        for($i=0; $i<$max; $i++){
            $res = strcmp($a[$i],$b[$i]);
            if($res != 0){
                return $res;
            }
        }
        return 0;
    }

    public static function isValidAuthor($authorStr){
        if( !(strlen($authorStr)<201 && preg_match("/^[a-zA-Z\s]+$/",$authorStr)) ){
            return false;
        }
        $authors = array_filter(preg_split("/and/",$authorStr));
        foreach($authors as $author){
            $nameParts = Publication::getWords($author);
            $count = count($nameParts);
            if( !($count>0 && $count<12) ){
                return false;
            }
        }

        return true;
    }

    public static function isValidTitle($title)
    {
        if( !(strlen($title)<201 && preg_match('/^[a-zA-Z0-9\s\p{P}]+$/',$title)) ){
            return false;
        }
        return true;
    }

    public static function isValidYear($year)
    {
        if( !($year >= 1500 && $year <= 2008) ){
            return false;
        }
        return true;
    }

    public static function isValidPublisher($publisher)
    {
        if( !(strlen($publisher)<201 && preg_match('/^[a-zA-Z0-9\s\p{P}]+$/',$publisher)) ){
            return false;
        }
        return true;
    }

    public static function getWords($str){
        if(is_string($str)){
            return array_filter(preg_split("/[\s]+/",$str));
        }
        return false;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * @param mixed $year
     */
    public function setYear($year)
    {
        $this->year = $year;
    }

    /**
     * @return mixed
     */
    public function getVolume()
    {
        return $this->volume;
    }

    /**
     * @param mixed $volume
     */
    public function setVolume($volume)
    {
        $this->volume = $volume;
    }




}
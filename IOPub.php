<?php
/**
 * Created by PhpStorm.
 * User: taminev
 * Date: 21.03.2015
 * Time: 12:12
 */


class IOPub {
    private $references = array();

    public function __construct($inputFilename){
        $this->parseInput($inputFilename);
        usort($this->references,'IOPub::compareRefs');
    }

    private function parseInput($inputFilename){
        $dataStr = file_get_contents($inputFilename);
        preg_match_all("/@(\w+)\s*({[\w\s=\"\-,0-9]+})/",$dataStr,$matches);
        foreach($matches[1] as $key=>$typeStr){
            preg_match_all("/(\w+)\s+=\s+\"([\w\s\-,0-9]+)\"/",$matches[2][$key],$fieldsMatches);

            $props = array_combine($fieldsMatches[1],$fieldsMatches[2]);

            $type = false;
            $publisher = '';
            switch($typeStr){
                case "book":
                    $type = PublicationFactory::BOOK;
                    $publisher = $props['publisher'];
                    break;
                case "article":
                    $type = PublicationFactory::ARTICLE;
                    $publisher = $props['journal'];
                    break;
            }

            if($type !== false){
                $reference = PublicationFactory::create($type,$props['author'],$props['title'],$props['year'],$publisher);
                if($reference){
                    if(array_key_exists('volume',$props)){
                        $reference->setVolume($props['volume']);
                    }
                    if(array_key_exists('number',$props)){
                        $reference->setNumber($props['number']);
                    }
                    if(array_key_exists('pages',$props)){
                        $reference->setPages($props['pages']);
                    }
                    $references[] = $reference;
                    $this->references[] = $reference;
                }
            }

        }

    }


    /**
     * @param Publication $a
     * @param Publication $b
     * @return int
     */
    public static function compareRefs($a,$b){
        if($res = strcmp($a->getAuthor(),$b->getAuthor()))
            return $res;
        if($res = strcmp($a->getTitle(),$b->getTitle()))
            return $res;
        if($res = strcmp($a->getVolume(),$b->getVolume()))
            return $res;
        return 0;
    }

    public function output($filename){
        file_put_contents($filename,'');
        $i = 1;
        foreach($this->getReferences() as $reference){
            $str = "[$i] ";
            if($reference->getClass() == 'Book'){
                $str .= $reference->getAuthor() . ' ' . $reference->getTitle();
                if($reference->getVolume()){
                    $str .= ', Vol. ' . $reference->getVolume();
                }
                $str .= ' -- ' . $reference->getPublisher() . ', ' . $reference->getYear();

            }elseif($reference->getClass() == 'Article'){
                $str .= $reference->getAuthor() .' '.$reference->getTitle().' // '. $reference->getJournal();
                if($reference->getVolume()){
                    $str .= ', '. $reference->getVolume();
                }
                if($reference->getNumber()){
                    $str .= ' ('. $reference->getNumber().')';
                }
                $str .= ' -- '.$reference->getYear();
                if($reference->getPages()){
                    $num = (int)$reference->getPages();
                    if($num == 1){
                        $prefix = ' -- p.';
                    }else{
                        $prefix = ' -- pp.';

                    }
                    $str .= $prefix.' '.$reference->getPages();
                }
            }
            file_put_contents($filename,$str.PHP_EOL,FILE_APPEND);
            $str = '';
            $i++;
        }

    }


    /**
     * @return Publication[]
     */
    public function getReferences()
    {
        return $this->references;
    }

    /**
     * @param array $references
     */
    public function setReferences($references)
    {
        $this->references = $references;
    }




}
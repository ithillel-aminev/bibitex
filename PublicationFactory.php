<?php
/**
 * Created by PhpStorm.
 * User: taminev
 * Date: 21.03.2015
 * Time: 11:32
 */

class PublicationFactory {
    const ARTICLE = 0;

    const BOOK = 1;

    public static function create($type,$author,$title,$year,$publisher){
        if(Publication::isValidAuthor($author) && Publication::isValidTitle($title)
            && Publication::isValidYear($year) && Publication::isValidPublisher($year)){
            switch($type){
                case PublicationFactory::ARTICLE:
                    return new Article($author,$title,$year,$publisher);
                    break;
                case PublicationFactory::BOOK:
                    return new Book($author,$title,$year,$publisher);
                    break;

            }
        }
        return false;
    }


}
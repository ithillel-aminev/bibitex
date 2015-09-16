<?php
/**
 * Created by PhpStorm.
 * User: taminev
 * Date: 21.03.2015
 * Time: 11:05
 */

require 'Publication.php';
require 'Book.php';
require 'Article.php';
require 'PublicationFactory.php';
require 'IOPub.php';

$io = new IOPub('bibitex.in');
$io->output('bibitex.out');
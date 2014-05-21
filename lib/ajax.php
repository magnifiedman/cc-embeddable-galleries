<?php
require_once('config.inc.php');
require_once(ROOT_PATH . 'lib/db.inc.php'); 
require_once(ROOT_PATH . 'lib/classes/gallery.class.php'); 


/**
 * Add slide to gallery - AJAX
 * @var int Gallery ID
 */
$r = mysql_query("
	INSERT into " . GALLERIES_TABLE . "
	(code,description,gallery_id)
	VALUES
	('','','". $_GET['gid'] ."'))";
	

echo $return['code'];
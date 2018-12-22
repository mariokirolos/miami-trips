<?php 

/**
 *
 *
 *      @Package Miami Trips
 *
 *
 */

namespace MiamiTrips\Base;

use MiamiTrips\Base\BaseController;

class Database extends BaseController{

	public function register(){
		
	}

	public function createTable(){
	
	$charset_collate = $this->wpdb->get_charset_collate();

	$sql = "CREATE TABLE IF NOT EXISTS $this->base_table_name (
		id mediumint(3) NOT NULL AUTO_INCREMENT,
		name varchar(55) DEFAULT '' NOT NULL,
		date_created timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  		ip_address varchar(20) NOT NULL ,
		PRIMARY KEY  (id)
	) $charset_collate; ";

	$sql .= "CREATE TABLE  IF NOT EXISTS  $this->base_OCR_table (
		  id mediumint(3) NOT NULL AUTO_INCREMENT,
		  file_id mediumint(3) NOT NULL,
		  blog_id mediumint(3) NOT NULL,
		  thumb_image_src varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
		  full_image_src varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
		  convertedText text COLLATE utf8mb4_unicode_ci NOT NULL , 
		  date_created timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  		  ip_address varchar(20) NOT NULL ,
  		  PRIMARY KEY  (id)
		)  $charset_collate; ";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );
	}


	public function removeTable(){
     $sql = "DROP TABLE IF EXISTS $this->base_table_name ;";
     $sql .= "DROP TABLE IF EXISTS $this->base_OCR_table ;";
     $this->wpdb->query($sql);
     delete_option("my_plugin_db_version");
	}


	public function getList($orderBy =  'date_created'){
		$sql = "SELECT `id`,`name`,`date_created` ,`ip_address` FROM $this->base_table_name ORDER BY $orderBy DESC";

		return $this->wpdb->get_results($sql);
	}

	public function getOCRList($orderBy = 'date_created'){
		$sql = "SELECT `id`,`thumb_image_src`,`full_image_src`,`convertedText`,`date_created` ,`ip_address` FROM $this->base_OCR_table ORDER BY $orderBy DESC";

		return $this->wpdb->get_results($sql);
	}


}
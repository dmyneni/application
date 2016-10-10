<?php

//CONFIGURATION for SmartAdmin UI

//ribbon breadcrumbs config
//array("Display Name" => "URL");

/*if (isset($_SESSION['user_id'])) {
$breadcrumbs = array(
	"$current_menu_name" => $base_url
);
} else {
	$breadcrumbs=array();
}*/

/*navigation array config

ex:
"dashboard" => array(
	"title" => "Display Title",
	"url" => "http://yoururl.com",
	"url_target" => "_self",
	"icon" => "fa-home",
	"label_htm" => "<span>Add your custom label/badge html here</span>",
	"sub" => array() //contains array of sub items with the same format as the parent
)

*/
//configuration variables
$page_css = array();
$no_main_header = false; //set true for lock.php and login.php
$page_body_prop = array(); //optional properties for <body>
$page_html_prop = array(); //optional properties for <html>

/*include ('database.php');
$repo=conn_repo_db();
$page_nav=get_menu($repo);
*/

?>
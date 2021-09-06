<?php 
require_once 'core/init.php';


if(Session::varmi(Main::config("session/session_ismi"))){
	Session::sil(Main::config("session/session_ismi"));
	session_destroy();
}

Main::yon("login.php");



?>
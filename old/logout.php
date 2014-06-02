<?php
session_start();
if(session_destroy())
{
	echo "You are now logged out!";
}
?>
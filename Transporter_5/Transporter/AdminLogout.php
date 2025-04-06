<?php
session_start();
if(session_destroy())
{
  
  header("Location: ./Customer_5/index.php");

}
?>
<?php
session_start();
include('conection.php');

$time = time();
$res = mysqli_query($conn, "select * from truck_driver");

?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta name="robots" content="noindex, nofollow">
      <title>User Status Dashboard</title>
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
      <style type="text/css">
         body {
            margin: 0;
            padding: 0;
            background-color: #17a2b8;
            height: 100vh;
         }
         .container  {
            margin-top: 100px;
            border: 1px solid #9C9C9C;
            background-color: #fff;
            padding:30px;
         }    
         .container h2{
            margin-bottom:25px;
         }
         .text-info {
            color: #000 !important;
         }
      </style>
      <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
      <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
   </head>
   <body>
      <div class="container">
         <h2 class="text-center text-info">User Status Dashboard</h2>
         <h5 class="text-center text-info"><a href="logout.php">Logout</a></h5>
         <table class="table table-striped table-bordered">
            <thead>
               <tr>
                  <th width="5%">#</th>
                  <th width="80%">Name</th>
                  <th width="15%">Status</th>
               </tr>
            </thead>
            <tbody id="user_grid">
               <?php 
               $i = 1;
               while($row = mysqli_fetch_assoc($res)){
                  $status = 'Offline';
                  $class = "btn-danger";
                  if($row['last_login'] > $time) {
                     $status = 'Online';
                     $class = "btn-success";
                  }
               ?>  
               <tr>
                  <th scope="row"><?php echo $i?></th>
                  <td><?php echo $row['driver_fullname']?></td>
                  <td><button type="button" class="btn <?php echo $class?>"><?php echo $status?></button></td>
               </tr>
               <?php 
               $i++;
               } ?>
            </tbody>
         </table>
      </div>
      <script>
         function updateUserStatus(){
            jQuery.ajax({
               url:'update_user_status.php',
               success:function(){
               }
            });
         }
         
         function getUserStatus(){
            jQuery.ajax({
               url:'get_user_status.php',
               success:function(result){
                  jQuery('#user_grid').html(result);
               }
            });
         }
         
         setInterval(function(){
            updateUserStatus();
         },3000);
         
         setInterval(function(){
            getUserStatus();
         },7000);
      </script>
   </body>
</html>

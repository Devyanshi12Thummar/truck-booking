<?php
session_start();
include('conection.php');
$uid = $_SESSION['UID'];
$time = time();
$res = mysqli_query($conn, "select * from truck_driver");
$i = 1;
$html = '';

while($row = mysqli_fetch_assoc($res)){
   $status = 'Offline';
   $class = "btn-danger";
   if($row['last_login'] > $time){
      $status = 'Online';
      $class = "btn-success";
   }
   $html .= '<tr>
                  <th scope="row">'.$i.'</th>
                  <td>'.$row['driver_fullname'].'</td>
                  <td><button type="button" class="btn '.$class.'">'.$status.'</button></td>
               </tr>';
   $i++;
}
echo $html;
?>

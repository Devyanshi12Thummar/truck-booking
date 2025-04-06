<?php
error_reporting(0);
                    $sql = "select * from user_master";
                    $userresult = $conn->query($sql);
                    // $sql1 = mysqli_query($conn, "select * from truck_detials");
                    // $truckresult = mysqli_num_rows($sql1);
                    // $sql2 = mysqli_query($conn, "select * from truck_booking");
                    // $bookingresult = mysqli_num_rows($sql2);
                if($userresult->num_rows > 0){
                    while($row = $userresult->fetch_assoc()){
                        $arr=array(
                            'name' => $row['name'],
                            'data' => array_wap('intval',explode(',',$row['data']))
                        );
                        $series_array[]=$arr;
                    }
                    return json_encode($series_array);
                }
                else{
                    echo "0 result";
                }
?>
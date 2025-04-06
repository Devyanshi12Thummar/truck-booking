<?php
require('conection.php');

session_start();

$pik_add = $_SESSION['piadd'];
$dro_add = $_SESSION['dradd'];
$goodweight = $_SESSION['goodweight'];
$goodtype = $_SESSION['goodtype'];
$pidate = $_SESSION["pick"];
$dropdate = $_SESSION["drop"];
$custid = $_SESSION['cust_id'];
$truckid = $_SESSION['tid'];

$sql = "SELECT * FROM `truck_detials` WHERE truck_id = $truckid LIMIT 1";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

$hour=$row['hour_rate'];
$hour=$row['day_rate'];
$hour=$row['fule_rate'];



$sql1 = "SELECT * FROM `goods` WHERE goods_id = $goodtype LIMIT 1";
$result1 = mysqli_query($conn, $sql1);
$row1 = mysqli_fetch_assoc($result1);



// if (isset($_POST['confirm'])) {

//     $sql = "INSERT INTO truck_booking (`booking_id`, `booking_date`, `pickup_date`, `drop_date`, `pickup_address`, `drop_address`, `goods_weight`, `user_id`, `truck_id`, `goods_id`) VALUES (`booking_id`,NOW(),'$pidate','$dropdate','$pik_add','$dro_add','$goodweight','$custid','$truckid','$goodtype')";
//     $oo = mysqli_query($conn, $sql);
//     echo '<script>alert("SuccessFully ADD")</script>';

//     // unset($_SESSION['pick']);
//     // unset($_SESSION['drop']);
//     // unset($_SESSION['tid']);
  
//     header('location: booking_history.php');
// }

?>

<html>

<head>
    <link rel="stylesheet" href="css/payment_style.css">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css ">

</head>

<body>
    <div class="card">
        <div class="card-top border-bottom text-center">
            <a href="booking.php"> Back</a>
            <span id="logo">Your Booking is Almost Done</span>
        </div>
        <div class="card-body">

            <div class="row">
                <!-- <div class="col-md-7">
                    <div class="left border">
                        <div class="row">
                            &emsp;<span class="header">Payment</span>
                            <div class="icons">
                                <img src="https://img.icons8.com/color/48/000000/visa.png" />
                                <img src="https://img.icons8.com/color/48/000000/mastercard-logo.png" />
                                <img src="https://img.icons8.com/color/48/000000/maestro.png" />
                            </div>
                        </div>
                        <form action="checkout.php">
                            <span>Cardholder's name:</span>
                            <input type="text" name="n" placeholder="Linda Williams">
                            <span>Card Number:</span>
                            <input type="text" name="na " placeholder="0125 6780 4567 9909">
                            <div class="row"> &emsp;
                                <div class="col-4"><span>Expiry date:</span>
                                    <input type="text" name="ex" placeholder="YY/MM">
                                </div>
                                <div class="col-4"><span>CVV:</span>
                                    <input type="text" name="cvv" id="cvv">
                                </div>
                            </div>
                            <input type="checkbox" id="save_card" class="align-left">
                            <label for="save_card">Save card details to wallet</label>

                            <div class="col text-left"> <input type="submit" name="payment" class="btn btn-outline-success" value="Payment" /></div>

                        </form>
                    </div>
                </div> -->
                <div class="col-md-12">
                    <div class="right border">
                        <div class="header">Truck Summary</div>
                        <br>
                        <div class="row item">
                            <div class="col-4 align-self-center"><img class="img-fluid" src="<?php echo $row['truck_image1']; ?>"></div>
                            <div class="col-8">
                                <div class="row"><b><?php echo $row['truck_name']; ?></b></div>
                                <div class="row text-muted"><b>PickUp Date : </b> <?php echo $pidate ?></div>
                                <div class="row text-muted"><b>DropDate Date : </b> <?php echo $dropdate ?></div>
                                <div class="row text-muted"><b>Goods :</b><?php echo $row1['goods_type']; ?></div>

                            </div>

                        </div>

                        <hr>
                        <div class="row lower">
                            <div class="col text-left">Subtotal</div>
                            <div class="col text-right">₹ <?php echo"{$_SESSION["totalamount"]}"?></div>
                        </div>
                        <div class="row lower">
                            <div class="col text-left">Driver</div>
                            <div class="col text-right">Free</div>
                        </div>
                        <div class="row lower">
                            <div class="col text-left"><b>Total to pay</b></div>
                            <div class="col text-right"><b>₹ <?php echo"{$_SESSION["totalamount"]}"?></b></div>
                        </div>
                        <form method="post" action="payment/pay.php">
                            <div class="row lower">

                                <div class="col text-left"> <input type="submit" name="confirm" class="btn btn-outline-success" value="Pay Now" /></div>
                                <div class="col text-left"> <input type="submit" class="btn btn-outline-warning" value="Request Call Back" /></div>
                        </form>
                    </div>
                    <p class="text-muted text-center">Complimentary Shipping & Returns</p>
                </div>
            </div>
        </div>
    </div>

    <div>
    </div>
    </div>
</body>

</html>
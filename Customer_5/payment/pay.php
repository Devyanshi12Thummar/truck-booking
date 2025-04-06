
            <?php
            require('conection.php');
            require('config.php');
            require('razorpay-php/Razorpay.php');

            session_start();

            $custid = $_SESSION['cust_id'];
            $truckid = $_SESSION['tid'];

            $sql = "select * from user_master";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);


            $email = $row["user_email"];
            $mobile = $row["user_contactno_primary"];
            $fullname = $row["user_fullname"];
            $address = $row["user_address"];
            $amount = $_SESSION['pay_amount'];


            $webtitle = "Truck Booking System";
            $title = "Truck";

            use Razorpay\Api\Api;

            $api = new Api($keyId, $keySecret);
            $imageurl = 'https://technosmarter.com/assets/images/Avatar.png'; //change logo from here
            $orderData = [
                'receipt'         => 3456,
                'amount'          => $amount * 100,
                'currency'        => "INR",
                'payment_capture' => 1
            ];
            $razorpayOrder = $api->order->create($orderData);
            $razorpayOrderId = $razorpayOrder['id'];
            $_SESSION['razorpay_order_id'] = $razorpayOrderId;
            $displayAmount = $amount = $orderData['amount'];
            if ($displayCurrency !== 'INR') {
                $url = "https://api.fixer.io/latest?symbols=$displayCurrency&base=INR";
                $exchange = json_decode(file_get_contents($url), true);

                $displayAmount = $exchange['rates'][$displayCurrency] * $amount / 100;
            }
            $data = [
                "key"               => $keyId,
                "amount"            => $amount,
                "name"              => $webtitle,
                "description"       => $title,
                "image"             => $imageurl,
                "prefill"           => [
                    "name"              => $fullname,
                    "email"             => $email,
                    "contact"           => $mobile,
                ],
                "notes"             => [
                    "address"           => $address,
                    "merchant_order_id" => "12312321",
                ],
                "theme"             => [
                    "color"             => "#F37254"
                ],
                "order_id"          => $razorpayOrderId,
            ];

            if ($displayCurrency !== 'INR') {
                $data['display_currency']  = $displayCurrency;
                $data['display_amount']    = $displayAmount;
            }

            $json = json_encode($data);


            require("checkout/manual.php");

            
            ?>
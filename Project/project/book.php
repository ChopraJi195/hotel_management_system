<?php
$link = mysqli_connect("localhost", "root", "", "hotel_management");

if ($link === false) {
    die("ERROR: could not connect. " . mysqli_connect_error());
}

$sql0 = "SELECT * FROM customers";
$result0 = mysqli_query($link, $sql0);
$flag = 0;

if ($result0) {
    while ($row0 = mysqli_fetch_assoc($result0)) {
        if ($row0['custemail'] == $_POST['email']) {
            $flag = 1;
            echo "reached";
        }
    }
}

if ($flag == 0) {
    $sql1 = "INSERT INTO customers(Custadd, custemail, cusname, cusmobile, noofguest)
             VALUES ('{$_POST['Address']}', '{$_POST['email']}', '{$_POST['Name']}', '{$_POST['mobile']}', '{$_POST['noofgu']}')";
    mysqli_query($link, $sql1);
}

$sql3 = "SELECT cusid FROM customers WHERE custemail='{$_POST['email']}'";
$result = mysqli_query($link, $sql3);
$row = mysqli_fetch_row($result);

if (strtotime($_POST['checkin']) < strtotime($_POST['checkout']) &&
    strtotime($_POST['checkin']) > strtotime(date("Y/m/d"))) {

    $sql2 = "INSERT INTO bookings(custid, checkin, checkout, roomtype) 
             VALUES ('$row[0]', '{$_POST['checkin']}', '{$_POST['checkout']}', '{$_POST['roomtype']}')";

    if (mysqli_query($link, $sql2)) {
        echo "<script>alert('Your booking request is successful. We will inform you about the status soon.');</script>";
        header('Location: http://localhost/Hotel-Management-services-using-MYSQL-and-php-master/project/status.php');
        exit();
    } else {
        echo "Error: " . mysqli_error($link);
    }
}

mysqli_close($link);
?>

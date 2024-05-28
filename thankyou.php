<?php

/*******w******** 
    
    Name: Finn Stuchbery
    Date: may 24th 2024
    Description: I am making a invoice page that comes after completing the form correctly.

****************/

$prices = ['1' => 1899.99,'2' => 79.99, '3' => 179.99, '4' => 249.99, '5' => 119.99];
$amounts_of_products = ['1' => 0,'2' =>0, '3' => 0, '4' => 0, '5' => 0];
$descriptions = ['1' => 'Macbook','2' => 'Razer Mouse', '3' => 'Portable Hardrive', '4' => 'Google Nexus 7', '5' => 'DD-45'];


    
    
    
function my_filter_function() {

    $email = filter_input(INPUT_POST,'email', FILTER_VALIDATE_EMAIL);
    $pattern = "/^[A-Za-z0-9]{6,}$/";
    $namery = $_POST["cardname"];
    $len = $_POST['cardnumber'];
    $word = (string)$len;
    $length_of_word = strlen($word);
    $month_Num = $_POST['month'];
    $currentYear = date('Y');
    $currentYearPlusFive = date('Y', strtotime('+5 years'));
    $yearEntered = $_POST['year'];
    $addy = $_POST['address'];
    $citayy = $_POST['city'];
    $province = $_POST['province'];
    
    
    $isValid = true;
    // works
    
    if($email == false) {
        $isValid = false;
    }

    // works
    
    $postalCode = filter_input(INPUT_POST, 'postal', FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=> $pattern)));
    if($postalCode == false) {
        $isValid = false;
    }

    
    if(is_numeric($namery) || $namery  == "" || $addy == "" || $citayy == "" ) {
        $isValid = false;
    }

    if($province != 'MB' && $province != 'AB' && $province != 'NB' && $province != 'NL'
     && $province != 'NS' && $province != 'ON' && $province != 'PE' && $province != 'QC'
      && $province != 'SK' && $province != 'NT' && $province != 'NU' && $province != 'YT'
      && $province != 'BC') {

        $isValid = false;
    }

    if($month_Num < 1 || $month_Num > 12) {
        $isValid = false;
    }
    // works
    
    if($length_of_word != 10) {
        $isValid = false;
    }
    // WORKs
    for($i = 1; $i <= 5; $i++) {
        $var2 = $_POST['qty' . $i];
        if(!is_numeric($var2) && $var2 != "") {
            $isValid = false;
            break;
        }
    }

    if($yearEntered < $currentYear || $yearEntered > $currentYearPlusFive) {
        $isValid = false;
    }

    if (isset($_POST['cardtype'])) {
        $cardtype = $_POST['cardtype'];
    } else {
        $cardtype = '';
    }
    if(!($cardtype == 'on')){
        $isValid = false;
    }
    return $isValid;
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type = "text/css" href="main.css">
    <title>Thanks for your order!</title>
</head>
<body>
    <!-- Remember that alternative syntax is good and html inside php is bad -->
    <?php if(my_filter_function() == true) :   ?>
       
        <?php
         $quantity = 0;
        $total_amount = 0;
        $count = 0;
        for($i = 1; $i <= 5; $i++) {
            $var = $_POST['qty' . $i];
            if($var != "") {
                $amounts_of_products[$i] = $var;
                $quantity += $amounts_of_products[$i];
                $total_amount += $var*$prices[$i];
                $count++;
            }
        }
    ?>
        <?php 
            $addy2  = $_POST['address'];;
            $citayy2 = $_POST['city'];
            $province2 = $_POST['province'];
            $postall = $_POST['postal'];
            $emaill = $_POST['email'];
        ?>


        <div id = "mainDiv">
        <h1>Address Information</h1>
        <table id = "table1">
            
        <tr>
            <td>Address:</td>
            <td><?php echo $addy2 ?></td>
            <td>City:</td>
            <td><?php echo $citayy2 ?></td>
            
        </tr>

        <tr>
            <td>Province:</td>
            <td><?php echo $province2 ?></td>
            <td>Postal Code:</td>
            <td><?php echo $postall ?></td>
        </tr>
        <tr>
            
            <td>Email:</td>
            <td><?php echo $emaill ?></td>
            <td></td>
            <td></td>


        </tr>
        </table>
        <h1>Order Information </h1>
        <table id ="pap">
        
        <tr> 
            <th>Quantity</th>
            <th>Description</th>
            <th>Cost</th>
        </tr>

        <?php
        for($i = 1; $i <= 5;$i++){
            if($amounts_of_products[$i] != 0){
                echo "<tr>";
                echo "<td>" . $amounts_of_products[$i] . "</td>";
                echo "<td>" . $descriptions[$i] . "</td>";
                echo "<td>" . $amounts_of_products[$i]*$prices[$i] . "</td>";
                echo "</tr>";
            }
         }
                echo "<tr>" ;
                echo "<td>" . $quantity .  "</td>";
                echo "<td>" . "Totals:" . "</td>";
                echo "<td>" . $total_amount . "</td>";
                echo "</tr>";
        ?> 
        </table>



        </div>
       
        <?php else: ?>
            <h1>oops! There was an error present in your form.</h1>
        <?php endif ?>
</body>
</html>
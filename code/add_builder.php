<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
//Including connection file
include 'conn.php';
// define variables and set to empty values
$nameErr = $emailErr = $mobilenoErr = $addressErr = $cityErr = $pincodeErr = $stateErr = "";
$name = $email = $mobileno = $address = $city = $pincode = $state = "";

$status = true;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["name"])) {
    $nameErr = "Name is required";
    $status = false;
  } else {
    $name = test_input($_POST["name"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z-' ]*$/",$name)) {
      $nameErr = "Only letters and white space allowed";
      $status = false;
    }
  }

  if (empty($_POST["mobileno"])) {
    $mobilenoErr = "Mobile number is required";
    $status = false;
  } else {
    $mobileno = test_input($_POST["mobileno"]);
    // check if name only contains letters and whitespace
    if (!preg_match('/^[0-9]{10}+$/', $mobileno)) {
      $mobilenoErr = "Enter mobile number with proper format.";
      $status = false;
    }
  }
  
  if (empty($_POST["email"])) {
    $emailErr = "Email is required";
    $status = false;
  } else {
    $email = test_input($_POST["email"]);
    // check if e-mail address is well-formed
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $emailErr = "Invalid email format";
      $status = false;
    }
  }

  if (empty($_POST["address"])) {
    $addressErr = "Address is required";
    $status = false;
  } else {
    $address = test_input($_POST["address"]);
  }

  if (empty($_POST["city"])) {
    $cityErr = "City is required";
    $status = false;
  } else {
    $city = test_input($_POST["city"]);
  }

  if (empty($_POST["pincode"])) {
    $pincodeErr = "Pincode is required";
    $status = false;
  } else {
    $pincode = test_input($_POST["pincode"]);
    
    if (strlen($pincode)<6) {
        $pincodeErr = "Pincode should be of 6 characters";
        $status = false;
     }
  }

  if (empty($_POST["state"])) {
    $stateErr = "State is required";
    $status = false;
  } else {
    $state = test_input($_POST["city"]);
  }

  if($status){
    $query = "INSERT INTO builders(name,mobileno,email,address,city,pincode,state) VALUES('$name','$mobileno','$email','$address','$city','$pincode','$state')";
    $result = mysqli_query($conn,$query);
  }
  
  if($result){
      echo "Success";
  }else{
      echo "failure";
  }
    
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>

<h2>Add operation</h2>
<p><span class="error">* required field</span></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
  Name: <input type="text" name="name" value="<?php echo $name;?>">
  <span class="error">* <?php echo $nameErr;?></span>
  <br><br>

  Mobile number: <input type="text" name="mobileno" value="<?php echo $mobileno;?>">
  <span class="error">* <?php echo $mobilenoErr;?></span>
  <br><br>

  E-mail: <input type="text" name="email" value="<?php echo $email;?>">
  <span class="error">* <?php echo $emailErr;?></span>
  <br><br>

  Address: <input type="text" name="address" value="<?php echo $address;?>">
  <span class="error">* <?php echo $addressErr;?></span>
  <br><br>

  City: <input type="text" name="city" value="<?php echo $city;?>">
  <span class="error">* <?php echo $cityErr;?></span>
  <br><br>

  Pincode: <input type="text" name="pincode" value="<?php echo $pincode;?>">
  <span class="error">* <?php echo $pincodeErr;?></span>
  <br><br>

  State: <input type="text" name="state" value="<?php echo $state;?>">
  <span class="error">* <?php echo $stateErr;?></span>
  <br><br>
  
  <button type="submit" name="submit">Submit</button>
    
</form>

</body>
</html>
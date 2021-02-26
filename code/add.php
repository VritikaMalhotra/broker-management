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
$nameErr = $emailErr = $mobilenoErr = $passwordErr = "";
$name = $email = $mobileno = $password = $filename = $filetmpname = $server_loc = "";
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

  if (empty($_POST["password"])) {
    $passwordErr = "Password is required";
    $status = false;
  } else {
    $password = test_input($_POST["password"]);
    
    if (strlen($password)<8) {
        $passwordErr = "Password should contain atleast 8 characters";
        $status = false;
     }
  }

  if(isset($_POST['submit'])&&isset($_FILES['my_image'])){
     $filename = $_FILES['my_image']['name'];
     $filetmpname = $_FILES['my_image']['tmp_name'];
     $folder = 'imagesuploaded/';
     $server_loc = $folder.$filename;
     echo $_FILES['my_image'];
     echo "filename : $filename<br>";
     echo "filetmpname : $filetmpname<br>";
     echo "folder : $folder";
     echo "server loc : $server_loc";
     move_uploaded_file($filetmpname,$folder.$filename);
     
  }else{
      echo "nothing obtained";
  }

  if($status){
    $query = "INSERT INTO brokers(name,mobileno,email,image,password) VALUES('$name','$mobileno','$email','$server_loc','$password')";
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
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">  
  Name: <input type="text" name="name" value="<?php echo $name;?>">
  <span class="error">* <?php echo $nameErr;?></span>
  <br><br>

  Mobile number: <input type="text" name="mobileno" value="<?php echo $mobileno;?>">
  <span class="error">* <?php echo $mobilenoErr;?></span>
  <br><br>

  E-mail: <input type="text" name="email" value="<?php echo $email;?>">
  <span class="error">* <?php echo $emailErr;?></span>
  <br><br>

  Password: <input type="password" name="password" value="<?php echo $password;?>">
  <span class="error">* <?php echo $passwordErr;?></span>
  <br><br>

  Select image to upload: <input type="file" name="my_image">

  <button type="submit" name="submit">Submit</button>
    
</form>

</body>
</html>
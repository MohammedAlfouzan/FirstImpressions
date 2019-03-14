<html>
<?php

if(isset($_POST["name"])){
  $user_name = "root";
  $password = "12345";
  $server = "heidi.com"; // rechecking server later

  $conn = mysqli_connect($server, $user_name, $password, "root");

  if($conn->connect_error){
    die("Connection failed " . mysqli_connect_error());
  }

/* profile tbl*/
  $name = $_POST["name"];
  $email = $_POST["email"];
  $password = $_POST["password"];
 
  $add = "INSERT INTO profile_tbl (name, email, password) VALUES ('$name', '$email','$password')";
  
  if($conn->query($add) === TRUE)
  {
    echo "<h1> thanks for submitting! </h1>";
  }
  $conn->close();
  
  /* comments tbl */
  
  /* trophy tbl */
  
  /* earns tbl */
  
  /* messages tbl */
  
  /* type of account tbl */
  
  /* Post */
  
  /* favorites */ 
  }
  
?>

<form name="myform" action = "sql.php" method = "POST">
    Name: <input type = "text" name = "name">
    email: <input type = "text" name = "email">
    password: <input type = "text" name = "password">
    <button type = "submit" name = "submit" id = "Submit_btn">Submit</button>

  </form>
</html>

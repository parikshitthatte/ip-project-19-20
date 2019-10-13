<?php
  session_start();
  $reminder = $recurrence = $alertdate = $alertamount = $user_id = "";
  if ($_SERVER["REQUEST_METHOD"] == "POST"){
    if (empty($_POST["reminder"]))
    {
      $_SESSION["reminerErr"] = "* Reminder Title is required";
    }
    else
    {
      $reminder= test_input($_POST["reminder"]);
    }

    if (empty($_POST["recurrence"]))
    {
      $_SESSION["recurrErr"] = "* recurrence is required";
    }
    else
    {
      $recurrence = test_input($_POST["recurrence"]);
    }
    if (empty($_POST["alertdate"]))
    {
      $_SESSION["alertdateErr"] = "* alert date is required";
    }
    else
    {
      $alertdate = test_input($_POST["alertdate"]);
    }

    if (empty($_POST["alertamount"]))
    {
      $_SESSION["alertamtErr"] = "* Alert amount is required";
    }
    else
    {
      $alertamount = test_input($_POST["alertamount"]);
    }
  }

  function test_input($data)
  {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "ip-project";

  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);
  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: ".$conn->connect_error);
  }
  $username = $_SESSION['currentUser'];
  $sql = "select id from users where username='$username'";
  $result = $conn->query($sql);
  $r = $result->fetch_array();
  $user_id = $r['id'];

  $sql = "INSERT INTO alerts(reminder,recurrence,alertdate,alertamount,user_id) VALUES('$reminder','$recurrence','$alertdate','$alertamount','$user_id')";
  if ($conn->query($sql) === TRUE) {
      $_SESSION['successMsg'] = "New record created successfully";
  } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
  }

  $conn->close();
  $_SESSION['load'] = 'abcd';
  header("Location: ../userDashboard.php");

?>
<?php

session_start();
if(!isset($_COOKIE['email'])){
  header("Location:index.php");
}


include "connection.php";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//...........................................

/* this is the line to generate random 6 digit alpha numeric code*/

//end here

//............................................
$table_name = $_SESSION['tablecode'];

if (isset($_POST["add"])) {
  unset($_POST["add"]);
  $name = $_POST["name"];
  $code = $_POST["code"];
  trim($name);
  trim($code);
  echo $code;

  $select = $conn->query("SELECT `code` FROM `login` WHERE `code` = '{$code}'") or die($conn->error);
  if ($select->num_rows) {
    $sql = "INSERT INTO `".$table_name."`(`name`,`code`) VALUES('{$name}','{$code}')";
    if ($conn->query($sql)) {
      echo "success";
    }
    echo $conn->error;
  } else {
    echo "user code not found";
  }
}

if (isset($_POST["creategroup"])) {
  unset($_POST['creategroup']);
  $select = $conn->query("SELECT * FROM `".$table_name."`") or die($conn->error);
  if ($select->num_rows > 1) {
    header("Location:journey.php");
  } else {
    echo "please add more than one person";
  }
}
if (isset($_POST['logout'])) {
  unset($_POST['logout']);
  setcookie("email",$email,time()-5*60*60);
  setcookie("pass",$pass,time()-5*60*60);
  unset($_SESSION['email']);
  $del = "DROP TABLE  `" . $table_name . "`";
  if ($conn->query($del)) {
    echo "table destroyed";
  } else {
    echo $conn->error;
  }
  header("Location:index.php");
}


?>
<!doctype html>
<html lang="en">

<head>
  <title>creategroup</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <style> 

        table { 

            margin: 0 auto; 

            font-size: large; 

            border: 1px solid black; 

        } 

  

        h1 { 

            text-align: center; 

            color: #006600; 

            font-size: xx-large; 

            font-family: 'Gill Sans', 'Gill Sans MT',  

            ' Calibri', 'Trebuchet MS', 'sans-serif'; 

        } 

  

        td { 

            background-color: #E4F5D4; 

            border: 1px solid black; 

        } 

  

        th, 

        td { 

            font-weight: bold; 

            border: 1px solid black; 

            padding: 10px; 

            text-align: center; 

        } 

  

        td { 

            font-weight: lighter; 

        } 

    </style> 

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
  <h1><?php echo $table_name;?></h1>
  <table>
    <tr>
      <th>Name</th>
      <th>Code</th>
    </tr>
    <!-- PHP CODE TO FETCH DATA FROM ROWS-->
    <?php   // LOOP TILL END OF DATA 
    $result = $conn->query("SELECT `name`,`code` FROM `".$table_name."`") or die($conn->error);
    while ($rows = $result->fetch_assoc()) {
    ?>
      <tr>
        <!--FETCHING DATA FROM EACH 
                    ROW OF EVERY COLUMN-->
        <td><?php echo $rows['name']; ?></td>
        <td><?php echo $rows['code']; ?></td>
      </tr>
    <?php
    }
    ?>
  </table>

  <div>
    ADD MEMEBERS!
    <form method="post">
      <input type="text" name="name">
      <input type="text" name="code">
      <button type="submit" name="add">add</button>

    </form>
  </div>
  <div>
    <form action="" method="post">
      <button name="creategroup">creategroup</button>
      <button name="logout">logout</button>
    </form>
  </div>



  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>

</html>
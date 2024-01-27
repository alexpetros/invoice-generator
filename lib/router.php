<?php
$uri = $_SERVER["REQUEST_URI"];
$path_info = pathinfo($uri);

if ($uri == "/") {
  return false;
} else if (file_exists("./public/$uri")) {
  return false;
} else if (file_exists("./public/$uri.php")) {
  include("./public/$uri.php");
} else {
  http_response_code(404);
  echo '<h1>404 NOT FOUND</h1>';
}

?>



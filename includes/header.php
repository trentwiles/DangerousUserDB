<?php
/*======================================================================
Copyright 2020, Riverside Rocks and the DUDB Authors

Licensed under the the Apache License v2.0 (the "License")

You may get a copy at
https://apache.org/licenses/LICENSE-2.0.txt

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.
========================================================================*/
session_start();

require 'vendor/autoload.php';
/*
require 'Stylus.php';
*/
// IMPORTANT CONFIGURATION!!!!!

$location = "/var/www/discord/"; // Replace this with your document root.
$font_awesome_kit = '<script src="https://kit.fontawesome.com/281a5c53f1.js" crossorigin="anonymous"></script>';
/*
$stylus = new Stylus();
$stylus->setReadDir('read');
$stylus->setWriteDir('write');
$stylus->setImportDir('import');
$stylus->fromFile("/stl/main.styl")->toFile("/out/main.css");
$stylus->parseFiles();
*/


function xss($text) {
  return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}

function createTitleFromURI($uri){
  $first_letter = $uri[0];
  $cap = strtoupper($first_letter);
  return $cap . substr($uri, 1);
}

?>
<!DOCTYPE html>
<head>
<?php
echo $font_awesome_kit;
  echo "<title>" . createTitleFromURI($_SERVER['REQUEST_URI']) . " - Dangerous User Database</title>";
  ?>
<link href="https://cdn.jsdelivr.net/npm/halfmoon@1.1.0/css/halfmoon-variables.min.css" rel="stylesheet" />
<link href="https://cdn.riverside.rocks/static/flags.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/halfmoon@1.1.0/js/halfmoon.min.js"></script>
<meta name="description" content=" Report + Check Dangerous Users on Discord with ease. ">
<meta name="keywords" content="discord, database">
<meta name="robots" content="index, follow">
<meta name="language" content="EN">
</head>
<?php
if(!isset($_COOKIE["bot"])){
  echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>';
  echo '<script src="/src/bot.js"></script>';
  $onload = "alertBot()";
  $cookie_name = "bot";
  $cookie_value = "seen";
  setcookie($cookie_name, $cookie_value, time() + (864000 * 30), "/");
}else{
  $onload = "halfmoon.toggleDarkMode()";
}
echo "<body onload='${onload}'>";
?>

<center>
<div class="page-wrapper with-navbar">
    <!-- Navbar (immediate child of the page wrapper) -->
    <nav class="navbar">
      <!-- Navbar brand -->
      <a href="/" class="navbar-brand">
        <img src="https://images.fineartamerica.com/images-medium-large/international-biohazard-symbol-.jpg" />
        Dangerous Discord User Database
      </a>
      <ul class="navbar-nav d-none d-md-flex"> <!-- d-none = display: none, d-md-flex = display: flex on medium screens and up (width > 768px) -->
        <?php
        $file = __FILE__;
        $path = $location . $file;
        if($path == $location . "report.php"){
            echo '<li class="nav-item active">';
        }else{
            echo '<li class="nav-item">';
        }
        ?>
          <a href="/report" class="nav-link">Report User</a>
        </li>
        <?php
            if($path == $location . "about.php"){
                echo '<li class="nav-item active">';
            }else{
                echo '<li class="nav-item">';
            }
        ?>
          <a href="/about" class="nav-link">About Us</a>
        </li>
        <li class="nav-item">
            <a href="/docs/index.php" class="nav-link">API Docs</a>
        </li>
        <li class="nav-item">
            <a href="//riverside.rocks/discord" class="nav-link">Community</a>
        </li>
      </ul>
      <form class="form-inline d-none d-md-flex ml-auto" action="/check" method="get"> <!-- d-none = display: none, d-md-flex = display: flex on medium screens and up (width > 768px), ml-auto = margin-left: auto -->
        <input type="text" id="id" name="id" class="form-control" placeholder="1234..." required="required">
        <button class="btn btn-primary" type="submit">Check ID</button>
      </form>
      <!-- Navbar content (with the dropdown menu) -->
      <div class="navbar-content d-md-none ml-auto"> <!-- d-md-none = display: none on medium screens and up (width > 768px), ml-auto = margin-left: auto -->
        <div class="dropdown with-arrow">
          <button class="btn" data-toggle="dropdown" type="button" id="navbar-dropdown-toggle-btn-1">
            Menu
            <i class="fa fa-angle-down" aria-hidden="true"></i>
          </button>
          <div class="dropdown-menu dropdown-menu-right w-200" aria-labelledby="navbar-dropdown-toggle-btn-1"> <!-- w-200 = width: 20rem (200px) -->
            <a href="/report" class="dropdown-item">Report</a>
            <a href="/about" class="dropdown-item">About Us</a>
            <a href="/docs/index.php" class="dropdown-item">API Docs</a>
            <a href="//riverside.rocks/discord" class="dropdown-item">Community</a>
            <div class="dropdown-divider"></div>
            <div class="dropdown-content">
              <form action="/check" method="get">
                <div class="form-group">
                  <input type="text" id="id" name="id" class="form-control" placeholder="1234..." required="required">
                </div>
                <button class="btn btn-primary btn-block" type="submit">Check ID</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </nav>

    <!-- Content wrapper, the rest of the pages content should go under here -->
    <div class="content-wrapper">

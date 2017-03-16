<?php
session_start();
date_default_timezone_set('America/Sao_Paulo');
header("Content-type: text/html; charset=utf-8");

$DR = $_SERVER['DOCUMENT_ROOT'];
$DS = DIRECTORY_SEPARATOR;

define("APP_ROOT", "{$DR}{$DS}admin{$DS}");

define("APP_LOG",     APP_ROOT . "webservice{$DS}_logs{$DS}");
define("APP_PATH",    APP_ROOT . "webservice{$DS}app{$DS}");
define("APP_SYSTEM",  APP_ROOT . "webservice{$DS}system{$DS}");

//define("APP_LIBS", "/bnet/feedback/_libs/");
//define("APP_IMGS", "/bnet/feedback/img/");
//define("APP_CSS", "/bnet/feedback/css/");
//define("APP_JS", "/bnet/feedback/js/");

ini_set('display_errors', 1);
//ini_set('error_reporting', E_ALL);
ini_set('error_reporting', E_ERROR);

ini_set('log_errors', 1);
ini_set('error_log', APP_LOG . "php_error_".date('Y_m_d').".log");

function exception_handler($exception) {

  if ($exception instanceof PDOException) {
    new AppPDOException($exception, IS_DEBUG);
  } 
  else {
    new AppException($exception, IS_DEBUG);
  }
}

set_exception_handler('exception_handler');

if (!function_exists("__autoload")) {
  
  function __autoload($classe) {
    $DR = $_SERVER['DOCUMENT_ROOT'];
    $DS = DIRECTORY_SEPARATOR;
    
    $possibilidades = array();
    
    $possibilidades[] = APP_SYSTEM . "{$classe}.abstract.php";
    $possibilidades[] = APP_SYSTEM . "{$classe}.class.php";

    $possibilidades[] = APP_SYSTEM . "_util{$DS}{$classe}.abstract.php";
    $possibilidades[] = APP_SYSTEM . "_util{$DS}{$classe}.class.php";

    $possibilidades[] = APP_SYSTEM . "controller{$DS}{$classe}.abstract.php";
    $possibilidades[] = APP_SYSTEM . "controller{$DS}{$classe}.class.php";

    $possibilidades[] = APP_SYSTEM . "exception{$DS}{$classe}.abstract.php";
    $possibilidades[] = APP_SYSTEM . "exception{$DS}{$classe}.class.php";

    $possibilidades[] = APP_SYSTEM . "model{$DS}{$classe}.abstract.php";
    $possibilidades[] = APP_SYSTEM . "model{$DS}{$classe}.class.php";
    
    $possibilidades[] = APP_SYSTEM . "mysql{$DS}{$classe}.abstract.php";
    $possibilidades[] = APP_SYSTEM . "mysql{$DS}{$classe}.class.php";
    
    $possibilidades[] = APP_PATH . "{$classe}.class.php";
    $possibilidades[] = APP_PATH . "model{$DS}{$classe}.class.php";
    $possibilidades[] = APP_PATH . "controller{$DS}{$classe}.class.php";
    $possibilidades[] = APP_PATH . "dao{$DS}{$classe}.class.php";

    foreach ($possibilidades as $file) {      
      if (file_exists($file)) {
        require_once($file);
        return;
      }
    }
  }
  
}


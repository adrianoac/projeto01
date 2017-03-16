<?php
/**
 * Description of AppPDOException
 *
 * @author adriano
 */
class AppPDOException {

  public function __construct($exception, $debug = false) {

    if ($debug) {
      echo "AppPDOException<br/>";
      if ( !empty($exception->xdebug_message) ) {
        echo "<table>{$exception->xdebug_message}</table>";
      }
      var_dump($exception);
      die();
    }
    else {
      self::tratar($exception);
    }
  }
  
  private function tratar(PDOException $exception) {
    die("[{$exception->getCode()}]<br>Erro na consulta ao banco de dados!");
  }

}

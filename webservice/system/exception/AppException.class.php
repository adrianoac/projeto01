<?php
/**
 * Description of AppException
 *
 * @author adriano
 */
class AppException {

  public function __construct($exception, $debug=false) {
    
    if ($debug){
      echo "AppException<br/>";
      if ( !empty($exception->xdebug_message) ){
        echo "<table>{$exception->xdebug_message}</table>";
      }
      var_dump($exception);
      die();
    }
    else {
      self::tratar($exception);
    }
  }
  
  private static function tratar($exception) {
    $aRetorno = array();
    $aRetorno['success'] = false;
    $aRetorno['msg'] = $exception->getMessage();
    die(json_encode($aRetorno));
  }

}

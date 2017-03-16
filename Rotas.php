<?php 
header("Content-type: text/x-json'");

final class Rotas {

  const WEBSERVICE = 'webservice/webservice.php?';

  private static $rotas=array();

  private static function setRotas() {

    self::$rotas['login'] = array(
      "logar"  => self::WEBSERVICE . "c=ControllerLogin&m=logar",
    );

    self::$rotas['lista'] = array(
      "create" => self::WEBSERVICE . "c=ControllerLista&m=create",
      "read" => self::WEBSERVICE . "c=ControllerLista&m=read",
      "update" => self::WEBSERVICE . "c=ControllerLista&m=update",
      "destroy" => self::WEBSERVICE . "c=ControllerLista&m=delete"
    );

    self::$rotas['carros'] = array(
      "create" => self::WEBSERVICE . "c=ControllerCarro&m=create",
      "read" => self::WEBSERVICE . "c=ControllerCarro&m=read",
      "update" => self::WEBSERVICE . "c=ControllerCarro&m=update",
      "destroy" => self::WEBSERVICE . "c=ControllerCarro&m=delete",
      
      "ativar" => self::WEBSERVICE . "c=ControllerCarro&m=ativarDesativar",
      "desativar" => self::WEBSERVICE . "c=ControllerCarro&m=ativarDesativar"
    );

    self::$rotas['marcas'] = array(
      "create" => self::WEBSERVICE . "c=ControllerMarca&m=create",
      "read" => self::WEBSERVICE . "c=ControllerMarca&m=read",
      "update" => self::WEBSERVICE . "c=ControllerMarca&m=update",
      "destroy" => self::WEBSERVICE . "c=ControllerMarca&m=delete"
    );

    self::$rotas['modelos'] = array(
      "create" => self::WEBSERVICE . "c=ControllerModelo&m=create",
      "read" => self::WEBSERVICE . "c=ControllerModelo&m=read",
      "update" => self::WEBSERVICE . "c=ControllerModelo&m=update",
      "destroy" => self::WEBSERVICE . "c=ControllerModelo&m=delete"
    );

    self::$rotas['imagem'] = array(
      "create" => self::WEBSERVICE . "c=ControllerGaleriaDeImagens&m=create",
      "read" => self::WEBSERVICE . "c=ControllerGaleriaDeImagens&m=read",
      "update" => self::WEBSERVICE . "c=ControllerGaleriaDeImagens&m=update",
      "destroy" => self::WEBSERVICE . "c=ControllerGaleriaDeImagens&m=delete",
      "definirImgPrincipal" => self::WEBSERVICE . "c=ControllerGaleriaDeImagens&m=definirImagemPrincipal"
    );

  }

  public static function getRotas() {
    self::setRotas();
    $jsonRotas = json_encode( self::$rotas );

    return $jsonRotas;
  }
}
?>

var Rotas = <?php echo Rotas::getRotas(); ?>;
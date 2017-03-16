<?php
/**
 * Description of ModelLista
 *
 * @author adriano
 */
class ModelLista extends Model {
  
  public function __construct() {
    self::$TABELA = "marcas";
    self::$TABELA_ALIAS = "mar";
    
    self::$CAMPOS = array("id");
    self::$ORDEM_INICIAL = "id";

    parent::__construct();
  }
  
  
}
<?php
/**
 * Description of ModelModelo
 *
 * @author adriano
 */
class ModelModelo extends Model {
  
  public function __construct() {
    
    self::$TABELA = "modelos";
    self::$TABELA_ALIAS = "m";

    self::$CAMPOS = array(
      'id', 
      'marca_id',
      'modelo_nome', 
      'modelo_imagem'
    );
    
    self::$ORDEM_INICIAL = "modelo_nome";

    parent::__construct();
  }
}
<?php
/**
 * Description of ModelModelo
 *
 * @author adriano
 */
class ModelMarca extends Model {
  
  public function __construct() {
    
    self::$TABELA = "marcas";
    self::$TABELA_ALIAS = "m";

    self::$CAMPOS = array(
      'id', 
      'marca_nome',
      'marca_imagem'
    );
    
    self::$ORDEM_INICIAL = "marca_nome";

    parent::__construct();
  }
}
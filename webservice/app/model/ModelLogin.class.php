<?php
/**
 * Description of ModelLogin
 *
 * @author adriano
 */
class ModelLogin extends Model {
  
  public function __construct() {
    self::$TABELA = "users";
    self::$TABELA_ALIAS = "u";
    self::$CAMPOS = array('id', 'username', 'password', 'role', 'created', 'modified');
    self::$ORDEM_INICIAL = "id";

    parent::__construct();
  }
  
  
}
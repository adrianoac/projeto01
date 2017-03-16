<?php
/**
 * Description of Select
 *
 * @author adriano
 */
class MySqlSelect extends MySqlManager {
  
  private $sqlPadrao=null;


  public function __construct($tabela, $sqlPadrao) {
    parent::__construct($tabela);
    
    $this->sqlPadrao = $sqlPadrao;
  }
  
  public function getInstruction(){
   
    return $this->sqlPadrao;
   
  }
  
  public function run($sql=null) {
    
    if (is_null($sql) ) {
      $sql = $this->sqlPadrao;
    }
    
    $retorno = parent::run($sql);
    
    return $retorno;
  }
  
}

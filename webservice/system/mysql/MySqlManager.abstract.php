<?php
/**
 * Description of MySqlManager
 *
 * @author adriano
 */
abstract class MySqlManager extends SqlManager {
  
  protected $tabela = null;
  protected $campos = array();
  
  protected $condicoes = array();

  public function __construct($tabela) {
    $this->tabela = $tabela;
  }

  public function __set($name, $value) {

    if ($name == "condicoes") {
      $this->condicoes[] = $value;
    }
    else {
      $this->campos[$name] = $value;
    }
    
  }

  public function run($sql=null) {
    
    if (is_null($sql)) {
      $sql = $this->getInstruction();
    }
    
    $retorno = $this->sqlExec($sql);
    
    return $retorno;
  }
  
  abstract public function getInstruction();
}
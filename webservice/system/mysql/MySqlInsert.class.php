<?php
/**
 * Description of Insert
 *
 * @author adriano
 */
class MySqlInsert extends MySqlManager {
  
  public function getInstruction() {
    $aCampos  = array();
    $aValores = array();
    
    foreach ($this->campos as $campo =>  $valor) {
      $aCampos[]  = $campo;
      $aValores[] = ($valor != 0 and (empty($valor) or strtolower($valor) == 'null') ) ? "NULL" : utf8_decode( "'{$valor}'" );
    }
    
    $campos  = implode(",", $aCampos);
    $valores = implode(",", $aValores);
    
    $sql= "INSERT INTO {$this->tabela} ({$campos}) VALUES ({$valores})";
    
    return $sql;
  }
  
}

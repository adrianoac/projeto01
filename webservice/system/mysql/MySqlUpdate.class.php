<?php
/**
 * Description of Update
 *
 * @author adriano
 */
class MySqlUpdate extends MySqlManager {
  
  public function getInstruction() {
    $aSets  = array();
    
    foreach ($this->campos as $campo =>  $valor) {
      $vlr = ( empty($valor) or strtolower($valor) == 'null' ) ? "NULL" : utf8_decode("'{$valor}'");
      $aSets[] = "{$campo} = {$vlr}"; 
    }
    
    $sets = implode(",", $aSets);
    
    $condicoes = implode(" AND ", $this->condicoes);
    
    $sql= "UPDATE {$this->tabela} SET $sets WHERE $condicoes;";
    
    return $sql;
  }
  
}

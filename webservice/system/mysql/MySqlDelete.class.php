<?php
/**
 * Description of Delete
 *
 * @author adriano
 */
class MySqlDelete extends MySqlManager {
  
  public function getInstruction() {
    
    $condicoes = implode(" AND ", $this->condicoes);
    
    $sql= "DELETE FROM {$this->tabela} WHERE $condicoes;";
    
    return $sql;
  }
  
}

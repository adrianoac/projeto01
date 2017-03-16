<?php
/**
 * Description of Model
 *
 * @author adriano
 */
abstract class Model {

  protected static $TABELA = null;
  protected static $TABELA_ALIAS = null;
  protected static $CAMPOS = array();
  protected static $ORDEM_INICIAL = array();

  private static $SQL_PADRAO = null;

  public $insert = null;
  public $update = null;
  public $delete = null;
  public $select = null;
  
  public function __construct() {
    $this->montarSelectPadrao();
    
    $this->insert = new MySqlInsert(self::$TABELA);
    $this->update = new MySqlUpdate(self::$TABELA);
    $this->delete = new MySqlDelete(self::$TABELA);
    
    $this->select = new MySqlSelect(self::$TABELA, self::$SQL_PADRAO);
  }
  
  public function getArrayDeCampos() {
    return self::$CAMPOS;
  }
  
  private function montarSelectPadrao() {
    $tabela = self::$TABELA;
    $tabelaAlias = self::$TABELA_ALIAS;
    $aCampos = array();
    
    foreach (self::$CAMPOS as $campo) {
      $aCampos[] = "{$tabelaAlias}.{$campo}";
    }
    
    $campos = join(", ", $aCampos);
    $ordemInicial = self::$ORDEM_INICIAL;
    $sql = "SELECT {$campos} FROM {$tabela} {$tabelaAlias} ORDER BY {$tabelaAlias}.{$ordemInicial}";
    
    self::$SQL_PADRAO = $sql;
  }
  
  protected function insert() {
    $retorno = $this->insert->run();
    
    return $retorno;
  }
  
  protected function update() {
    $retorno = $this->update->run();
    
    return $retorno;
  }
  
  protected function delete() {
    $retorno = $this->delete->run();
    
    return $retorno;
  }
  
  protected function select($sql=null) {
    
    $retorno = $this->select->run($sql);
    
    return $retorno;
  }
}

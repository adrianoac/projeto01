<?php
/**
 * Description of ControllerLista
 *
 * @author adriano
 */
final class ControllerLista extends Controller {
  
  public function __construct($postData) {
    parent::__construct(new ModelLista(), $postData);    
  }
  
  public function create() {
    return false;
  }
  
  private function insert(MySqlInsert $insert,array  $data) {
    return false;
  }

  public function delete() {
    return false;
  }

  public function read() {
    $aSQL = array();
    
    $aSQL[] = "SELECT";
    $aSQL[] =   "mar.id AS 'marca_id', mar.marca_nome, mdl.modelo_nome, mdl.id AS 'modelo_id',";
    $aSQL[] =   "(";
    $aSQL[] =     "SELECT COUNT(m.id)";
    $aSQL[] =     "FROM produtos p";
    $aSQL[] =       "INNER JOIN modelos mdl ON ( p.modelo_id = mdl.id )";
    $aSQL[] =       "INNER JOIN marcas m ON ( m.id = mdl.marca_id)";
    $aSQL[] =     "WHERE m.id = mar.id GROUP BY m.id";
    $aSQL[] =   ") AS total,";
    $aSQL[] = "( SELECT COUNT(p.id) FROM produtos p INNER JOIN modelos md ON ( p.modelo_id = md.id ) INNER JOIN marcas m ON ( m.id = md.marca_id) WHERE mdl.id = p.modelo_id GROUP BY m.id ) AS total_modelo";
//    $aSQL[] =   "(";
//    $aSQL[] =     "SELECT COUNT(p.id)";
//    $aSQL[] =     "FROM produtos p";
//    $aSQL[] =       "INNER JOIN modelos md ON ( p.modelo_id = mdl.id )";
//    $aSQL[] =       "INNER JOIN marcas m ON ( md.id = p.modelo_id)";
//    $aSQL[] =     "WHERE m.id = mar.id GROUP BY m.id";
//    $aSQL[] =   ") AS total_modelo";
    $aSQL[] = "FROM marcas mar";
    $aSQL[] =   "INNER JOIN modelos mdl ON ( mar.id = mdl.marca_id )";
    $aSQL[] = "ORDER BY mar.marca_nome, mdl . modelo_nome;";
    
    $sql = join(" ", $aSQL);
//    die($sql);
    $data = $this->model->select->run($sql);

    $dataRetorno = $this->montarDataTreeView($data);      

    return $dataRetorno;
  }

  public function update() {
    return false;
  }
  
  private function montarDataTreeView($data) {
    unset($data['total']);
    
    $aTree=array();
    $marca_nome = "";
    
    foreach ($data as $marca) {
    
      if ( $marca_nome != $marca['marca_nome'] ) {
        $marca_nome = $marca['marca_nome'];
        
        $marcaPai = $marca;
        $total = str_pad($marcaPai['total'], 2, '0', STR_PAD_LEFT);
        
        $marcaPai['leaf'] = false;
        $marcaPai['expanded'] = false;
        $marcaPai['icon'] = "resources/icons/16/product.png";
        $marcaPai['tipo'] = "pai";
        $marcaPai['text'] = "{$marca_nome} ({$total})";
        
        $this->adicionarFilhos($data, $marca_nome, $marcaPai);
        
        $aTree[] = $marcaPai;
      }
      
      $marca_nome = $marca['marca_nome'];
    }
    
    $jsonRetorno = json_encode($aTree);
    
    return $jsonRetorno;
  }
  
  private function adicionarFilhos($data, $marca_nome, array &$marcaPai) {
    
    foreach ($data as $filho) {
      
      if ($filho['marca_nome'] == $marca_nome) {
        $total = str_pad($filho['total_modelo'], 2, '0', STR_PAD_LEFT);
        
        $filhoAdd['leaf'] = true;
        $filhoAdd['expanded'] = false;
        $filhoAdd['icon'] = "resources/icons/16/page_lista_icon.png";
        $filhoAdd['tipo'] = "filho";
        $filhoAdd['text'] = "{$filho['modelo_nome']} ({$total})";
        $filhoAdd['marca_id'] = $filho['marca_id'];
        $filhoAdd['modelo_id'] = $filho['modelo_id'];
        $filhoAdd['total'] = $filho['total_modelo'];
        
        $marcaPai['children'][] = $filhoAdd;
        
      }
      
    }
    
  }
  
}

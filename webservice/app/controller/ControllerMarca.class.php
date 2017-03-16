<?php
/**
 * Description of ControllerMarca
 *
 * @author adriano
 */
final class ControllerMarca extends Controller {
  
  public function __construct($postData) {
    parent::__construct(new ModelMarca(), $postData);    
  }
  
  public function create() {
    $aItems = $this->model->getArrayDeCampos();
    $data = CommonMethod::getElements($aItems, $this->postData);

    $this->setPropriedades($data, $this->model->insert);

    $data['id'] = $this->model->insert->run();
    
    $jsonRetorno = json_encode( array('success'=>true, 'msg'=> 'Marca cadastrada com sucesso!') );
    
    return $jsonRetorno;
  }

  public function delete() {
    $aItems = $this->model->getArrayDeCampos();
    $postData = CommonMethod::getElements($aItems, $this->postData);
    
    $podeExcluir = $this->validarExclusao($postData);
    if ($podeExcluir){
      $this->model->delete->condicoes = "id = '{$postData['id']}'";

      $this->model->delete->run();

      $jsonRetorno = json_encode(array('success' => true, 'msg' => 'Marca deletada com sucesso!'));
    }
    else{
      $jsonRetorno = json_encode(array('success' => true, 'msg' => 'Esta Marca não pode ser excluída! Tem modelos vinculados a ela.'));
    }

    return $jsonRetorno;
  }
  
  private function validarExclusao($data) {
    $postData=array();
    $postData['tipo'] = 'gridModelos';
    $postData['marca_id'] = $data['id'];
    
    $controllerModelo = new ControllerModelo($postData);
    $modelos = $controllerModelo->getAllModelos();

    if ($modelos['total'] > 0){
      return false;
    }
    else{
      return true;
    }
    
  }

  public function read() {
    $aSQL = array();
    
    $aSQL[] = "SELECT";
	$aSQL[] =   "mar.id, mar.id AS 'marca_id', mar.marca_nome, mar.marca_imagem";
    $aSQL[] = "FROM marcas mar";
    $aSQL[] = "ORDER BY";
    $aSQL[] =   "mar.marca_nome;";
    
    $sql = join(" ", $aSQL);
    
    $data = $this->model->select->run($sql);
    unset($data['total']);
    
    $dataRetorno = $this->jsonEncodeforGrid($data);     

    return $dataRetorno;
  }

  public function update() {
    $aItems = $this->model->getArrayDeCampos();
    $postData = CommonMethod::getElements($aItems, $this->postData);

    $this->model->update->condicoes = "id = '{$postData['id']}'";

    $this->setPropriedades($postData, $this->model->update);

    $this->model->update->run();

    $jsonRetorno = json_encode(array('success' => true, 'msg' => 'Marca alterada com sucesso!'));

    return $jsonRetorno;
  }  
  
}
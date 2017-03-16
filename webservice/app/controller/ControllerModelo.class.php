<?php
/**
 * Description of ControllerModelo
 *
 * @author adriano
 */
final class ControllerModelo extends Controller {
  
  public function __construct($postData) {
    parent::__construct(new ModelModelo(), $postData);    
  }
  
  public function create() {
    $aItems = $this->model->getArrayDeCampos();
    $data = CommonMethod::getElements($aItems, $this->postData);

    $this->setPropriedades($data, $this->model->insert);

    $data['id'] = $this->model->insert->run();

    $jsonRetorno = json_encode(array('success' => true, 'msg' => 'Modelo Cadastrado com Sucesso!'));

    return $jsonRetorno;
  }
  
  public function delete() {
    $aItems = $this->model->getArrayDeCampos();
    $postData = CommonMethod::getElements($aItems, $this->postData);

    $this->model->delete->condicoes = "id = '{$postData['id']}'";

    $this->model->delete->run();

    $jsonRetorno = json_encode(array('success' => true, 'msg' => 'Modelo Deletado com Sucesso!'));

    return $jsonRetorno;
  }

  public function read() {
    
    $data = $this->getAllModelos();
    unset($data['total']);
    
    $dataRetorno = $this->jsonEncodeforGrid($data);     

    return $dataRetorno;
  }
  
  public function getAllModelos() {
    $tipo = $this->postData['tipo'];
    $marca_id = $this->postData['marca_id'];
    $aSQL = array();

    $aSQL[] = "SELECT";
    $aSQL[] = "mdl.id, mdl.modelo_nome, mdl.modelo_imagem, mdl.marca_id, mar.marca_nome";
    $aSQL[] = "FROM modelos mdl";
    $aSQL[] = "INNER JOIN marcas mar ON (mdl.marca_id = mar.id)";

    if ($tipo == 'gridModelos') {
      $aSQL[] = "WHERE";
      $aSQL[] = "mdl.marca_id = {$marca_id}";
    }
    else if ($tipo == 'grid') {
      $aSQL[] = "GROUP BY";
      $aSQL[] = "mar.id";
    }

    $aSQL[] = "ORDER BY";
    $aSQL[] = "mar.marca_nome, mdl.modelo_nome";

    $sql = join(" ", $aSQL);

    $data = $this->model->select->run($sql);
    
    return $data;
  }

  public function update() {
    $aItems = $this->model->getArrayDeCampos();
    $postData = CommonMethod::getElements($aItems, $this->postData);

    $this->model->update->condicoes = "id = '{$postData['id']}'";

    $this->setPropriedades($postData, $this->model->update);

    $this->model->update->run();

    $jsonRetorno = json_encode(array('success' => true, 'msg' => 'Modelo Alterado com Sucesso!'));

    return $jsonRetorno;
  }  
  
}
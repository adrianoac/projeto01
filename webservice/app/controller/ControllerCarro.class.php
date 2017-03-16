<?php
/**
 * Description of ControllerCarro
 *
 * @author adriano
 */
final class ControllerCarro extends Controller {
  
  public function __construct($postData) {
    parent::__construct(new ModelCarro(), $postData);    
  }
  
  public function create() {
    $aItems = $this->model->getArrayDeCampos();
    $data = CommonMethod::getElements($aItems, $this->postData);
    $data['categoria_id'] = '0';
    
    $this->setPropriedades($data, $this->model->insert);

    $data['id'] = $this->model->insert->run();

    return $this->jsonEncodeforForm($data);
  }
  
  public function delete() {

  }

  public function read() {
    $postData = CommonMethod::getElements(array('tipo', 'filtro',  'id', 'pesquisar', 'start', 'limit'), $this->postData);
    
    $sql = DaoCarros::getSelect($postData);
    
    $data = $this->model->select->run($sql);
    
    $dataRetorno = $this->jsonEncodeforGrid($data);

    return $dataRetorno;
  }

  public function update() {
    $aItems = $this->model->getArrayDeCampos();
    $postData = CommonMethod::getElements($aItems, $this->postData);
    
    $this->model->update->condicoes = "id = '{$postData['id']}'";
    
    $this->setPropriedades($postData, $this->model->update);

    $this->model->update->run();
    
    $dataRetorno = $this->jsonEncodeforGrid($this->postData);

    return $dataRetorno;
  }
  
  public function ativarDesativar(){
    $postData = array();
    $postData['id'] = $this->postData['produto_id'];
    $postData['produto_ativo'] = $this->postData['produto_ativo'];
    
    $controllerCarro = new ControllerCarro($postData);
    $retorno = $controllerCarro->update();
    
    return $retorno;
  }
}
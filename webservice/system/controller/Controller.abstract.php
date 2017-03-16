<?php
/**
 * Description of ControllerLista
 *
 * @author adriano
 */
abstract class Controller {
  
  protected $postData = null;
  
  protected $model = false;

  public function __construct($model, $postData){
    $this->postData = $postData;
    $this->model = $model;
  }

  abstract public function create();
  
  abstract public function read();
  
  abstract public function update();
  
  abstract public function delete();
  
  protected function setPropriedades(array $data, &$objeto) {
    foreach ($data as $propriedade => $valor) {
      if ($propriedade!='id'){
        $objeto->$propriedade = $valor;
      }
    }
  }
  
  protected function jsonEncodeforForm($data) {
    $aRetorno = array();
    $aRetorno['success'] = true;
    $aRetorno['data'] = $data;
    
    $jsonRetorno = json_encode($aRetorno);
    
    return $jsonRetorno;
  }
  
  protected function jsonEncodeforGrid($data) {
    $total = $data['total'];
    unset($data['total']);
    
    $aRetorno = array();
    $aRetorno['success'] = true;
    $aRetorno['data'] = $data;
    $aRetorno['total'] = $total;

    $jsonRetorno = json_encode($aRetorno);

    return $jsonRetorno;
  }
  
}

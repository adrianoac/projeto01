<?php
require dirname(__FILE__) . DIRECTORY_SEPARATOR . "system" . DIRECTORY_SEPARATOR . "_util" . DIRECTORY_SEPARATOR . "_config.php";

define("IS_DEBUG", true);

final class WebService {

  private function getRequestData($queryString) {
    $request_body = file_get_contents('php://input');
    $dataDecode=array();
    
    if ( ! empty($request_body) ) {
      $dataDecode = json_decode($request_body, true);
      $jsonData = $dataDecode['data'][0];
    }
    
    $query=array();
    parse_str($queryString, $query);
    
//    $aArrays=array($_POST, $_GET, $query, $jsonData); ??
    $aArrays=array($_POST, $_GET, $jsonData);

    $requestData = CommonMethod::mergeArray($aArrays);
    
    return $requestData;
  }
  
  private function uriToArray($uri) {
    $parse = parse_url($uri);
    
    $data = array();
    $data['class'] = filter_input(INPUT_GET, 'c');
    $data['method'] = filter_input(INPUT_GET, 'm');
    $data['requestData'] = $this->getRequestData($parse['query']);
    
    return $data;
  }
  
  private function executarSolicitacao($uri) {
    $data = $this->uriToArray($uri);

    $class = $data['class'];
    $method = $data['method'];
    
    $objectClass = new $class($data['requestData']);
    
    $dataRetorno = $objectClass->$method();
    
    return $dataRetorno;
  }

  /**
   * Processa a solicitacao enviada ao servidor.
   * 
   * @return String JSON String contendo o resulta da solicitacao
   */
  public function processarSolicitacao() {
    
    $requestUri = filter_input(INPUT_SERVER, 'REQUEST_URI');
    
    
    $retorno = $this->executarSolicitacao($requestUri);
    
    die($retorno);
  }

}

$webservice = new Webservice();
$webservice->processarSolicitacao();
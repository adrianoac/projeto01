<?php

class ControllerLogin extends Controller {
  
  public function __construct($postData) {
    parent::__construct(new ModelLogin(), $postData);
  }

  public function logar() {
    
    $postData = CommonMethod::getElements(array('login', 'senha'), $this->postData);
    
    $sql = "SELECT u.id, u.username, u.role FROM users u WHERE MD5(u.username) = MD5('{$postData['login']}') AND MD5(u.password) = MD5('{$postData['senha']}');";
    
    $MySqlSelect = new MySqlSelect("users", $sql);
    
    $dadosUsuario = $MySqlSelect->run();
    
    
    if ($dadosUsuario['total'] > 0) {
      $aUsuario = $dadosUsuario[0];
      
      $_SESSION['idusuario'] = $aUsuario['id'];

      $aRetorno = array();
      $aRetorno['success'] = true;
      $aRetorno['data'] = $aUsuario;
      
      $jsonRetorno = json_encode($aRetorno);
    }
    else {
      $jsonRetorno = json_encode(array('success'=>false, 'msg'=>'Login ou senha inválida.'));
    }
    
    return $jsonRetorno;    
  }

  public function create() {
    
  }

  public function delete() {
    
  }

  public function read() {
    
  }

  public function update() {
    
  }

}

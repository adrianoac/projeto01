<?php
/**
 * Description of ControllerGaleriaDeImagens
 *
 * @author adriano
 */
class ControllerGaleriaDeImagens extends Controller {
  
  private $IMG_MINI_WIDTH = 85;
  private $IMG_MINI_HEIGHT=64;

  private $IMG_WIDTH = 800;
  private $IMG_HEIGHT =600;

  private $PATH_PRODUTO = null;
  
  private $PATH_IMAGENS = null;
  private $PATH_IMAGENS_MINI=null;
  
  private $LINK_IMAGENS = null;
  private $LINK_IMAGENS_MINI = null;
  
  private $TEMP_IMG = null;
  
  public function __construct($postData) {
    parent::__construct(new ModelGaleriaDeImagens, $postData);
    
    $DR = $_SERVER['DOCUMENT_ROOT'];//filter_input(INPUT_SERVER, "DOCUMENT_ROOT");
    $DS = DIRECTORY_SEPARATOR;
    
    $this->PATH_PRODUTO = "{$DR}controle{$DS}app{$DS}webroot{$DS}files{$DS}Produto{$DS}";
    
    $this->PATH_IMAGENS = "{$this->PATH_PRODUTO}{$postData['produto_id']}{$DS}";
    if (! is_dir($this->PATH_IMAGENS) ){
      mkdir($this->PATH_IMAGENS, 0777);
    }
    
    $this->PATH_IMAGENS_MINI = "{$this->PATH_PRODUTO}{$postData['produto_id']}{$DS}85X64{$DS}";
    if (!is_dir($this->PATH_IMAGENS_MINI)) {
      mkdir($this->PATH_IMAGENS_MINI, 0777);
    }

    $this->LINK_IMAGENS = "../../controle/app/webroot/files/Produto/{$postData['produto_id']}/";
    $this->LINK_IMAGENS_MINI = "../../controle/app/webroot/files/Produto/{$postData['produto_id']}/85X64/";
    
    $this->TEMP_IMG = "{$DR}admin{$DS}temp{$DS}";
    if ( !is_dir($this->TEMP_IMG) ){
      mkdir($this->TEMP_IMG, 777);
    }
    
  }

  public function create() {
    $file = $_FILES;
    $nomeImagens = $file['imagem']['name'];
    $erro = "";
    
    unlink($this->TEMP_IMG . $nomeImagens);
    if (move_uploaded_file($file['imagem']['tmp_name'], $this->TEMP_IMG . $nomeImagens) ) {
      
      $redimensionaMini = new m2brimagem($this->TEMP_IMG . $nomeImagens);
      $validaMini = $redimensionaMini->valida();

      if ($validaMini == 'OK') {
        unlink($this->PATH_IMAGENS_MINI . $nomeImagens);
        $redimensionaMini->redimensiona($this->IMG_MINI_WIDTH, $this->IMG_MINI_HEIGHT, 'crop');
        $redimensionaMini->grava($this->PATH_IMAGENS_MINI . $nomeImagens);
      }
      else {
        $erro = "<br>Erro ao Gravar miniatura, verificar permissão!";
      }
      
      $redimensionaImg = new m2brimagem($this->TEMP_IMG . $nomeImagens);
      $validaImg = $redimensionaImg->valida();
      if($validaImg == 'OK'){
        unlink($this->PATH_IMAGENS . $nomeImagens);
        $redimensionaImg->redimensiona($this->IMG_WIDTH, $this->IMG_HEIGHT, 'crop');
        $redimensionaImg->grava($this->PATH_IMAGENS . $nomeImagens);
      }
      else {
        $erro .= "<br>Erro ao Gravar imagem, verificar permissão!";
      }
    }
    else {
      $erro .= "<br>Erro no move uploaded file!";
    }
    
    $msg = "Arquivo enviado com sucesso!";
    if ( ! empty($erro) ){
      $msg = $erro;
    }
    unlink($this->TEMP_IMG . $nomeImagens);
    
    $dataRetorno = $this->jsonEncodeforForm(array('msg'=>$msg));
    return $dataRetorno;
  }

  public function delete() {
    $msgErro = "";
    $nomeImagens = $this->postData['imagem'];
    if ( file_exists($this->PATH_IMAGENS_MINI . $nomeImagens) ){
      unlink($this->PATH_IMAGENS_MINI . $nomeImagens);
    }
    else{
      $msgErro .= "Erro ao deletar Miniatura!";
    }
    
    if( file_exists($this->PATH_IMAGENS . $nomeImagens) ){
      unlink($this->PATH_IMAGENS . $nomeImagens);
    }
    else {
      $msgErro .= "Erro ao deletar Imagem!";
    }
    
    $msg = 'Arquivo deletado com sucesso!';      
    if ( !empty($msgErro) ){
      $msg = $msgErro;
    }
    
    $dataRetorno = $this->jsonEncodeforForm(array('msg' => $msg));      
    
    return $dataRetorno;
  }

  public function read() {
    $data = array();

    $images = glob($this->PATH_IMAGENS . "*.*");
    
//    $images = array_diff(scandir($this->PATH_IMAGENS), array('..', '.'));
    
//    var_dump($images);
//    echo "<br>$this->PATH_IMAGENS<br>";
//    die();
//    echo $this->PATH_IMAGENS;
    foreach ($images as $image) {
      $aImgPath = explode(DIRECTORY_SEPARATOR, $image);
      $imgName = end($aImgPath);
      
      $dataImage = array("produto_id"=>$this->postData['produto_id'], "imagem"=>$imgName);
      $data[] = $dataImage;
    }
    // $data[1]['principal'] = '1';
    $dataRetorno = $this->jsonEncodeforGrid($data);

    return $dataRetorno;
  }
  
  public function update() {
    return false;
  }
  
  public function definirImagemPrincipal(){
    //pegar na base a principal atual e unlink nela. //futuro
    $erro="";
    $postData = array();
    $postData['id'] =  $this->postData['produto_id'];
    $postData['produto_imagem'] = $this->postData['imagem'];
    
    $redimensionaImg = new m2brimagem($this->PATH_IMAGENS . $postData['produto_imagem']);
    $validaImg = $redimensionaImg->valida();
    if ($validaImg == 'OK') {
      unlink($this->PATH_PRODUTO . $postData['produto_imagem']);
      $redimensionaImg->redimensiona($this->IMG_WIDTH, $this->IMG_HEIGHT, 'crop');
      $redimensionaImg->grava($this->PATH_PRODUTO . $postData['produto_imagem']);
    }
    else {
      $erro = "Erro ao Gravar imagem, verificar permissão!";
    }

    $controllerCarro = new ControllerCarro($postData);    
    $controllerCarro->update(); 
    
    $msg = "Imagem principal definida com sucesso!";
    if ( !empty($erro) ){
      $msg = $erro;
    }
    
    $dataRetorno = $this->jsonEncodeforForm(array('msg' => $msg));
    return $dataRetorno;
  }
}

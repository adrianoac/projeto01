<?php
class imagem {
  /*Crio as variaveis nescessárias para o redimensionamento de imagens*/
  private $altura  = '';//Variável responsável pela altura  (x)
  private $largura = '';//Variável responsável pela largura (y);
  private $arquivo = '';//Pego o arquivo a ser redimensionado;

  public function __construct($campos = array()){
    parent::__construct();
//    $this->tabela = "imagem";
//    if(sizeof($campos) <= 0):
//        $this->campos_valores = array(
//          "nome_imagem"      => NULL,
//          "imagem_principal" => NULL
//        );
//    else:
//        $this->campos_valores = $campos;	
//    endif;
//
//    $this->campopk = "id_imagem"; 
  }


  public function redimensiona_image($arquivo ,$altura, $largura){
    $redimensiona = new m2brimagem();//Crio um objeto para redimensionar as imagens
    $this->altura  = $altura;        //Armazaeno o valor da altura passado por parâmentro
    $this->largura = $largura;       // Armazeno o valor da largura passadi por parâmentro
    $this->arquivo = $arquivo;       //Armazeno o valor do arquivo passado por parâmentro

    /*
     * Cria um comando que valida a execução
     */
    $valida = $redimensiona->valida();

    /*
     * Vejo se validou a execução
     */
    if($valida == 'OK'):
      /*
       * Redimentisiono a imagem e salvo
       */
      $redimensiona->redimensiona($largura, $altura, 'crop');
      $redimensiona->grava(UPLOADPATH);
    else:
      /*
       * Caso não funcione mata o método
       */
      die($valida);
    endif;

  }

}//fim classe Acervo

    
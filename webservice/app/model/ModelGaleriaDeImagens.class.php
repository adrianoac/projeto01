<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ModelGaleriaDeImagens
 *
 * @author adriano
 */
class ModelGaleriaDeImagens  extends Model {
  
  public function __construct() {

    self::$TABELA = "imagens";
    self::$TABELA_ALIAS = "i";

    self::$CAMPOS = array(
      'id',
      'produdo_id',
      'imagem'
    );

    self::$ORDEM_INICIAL = "id";

    parent::__construct();
  }

}

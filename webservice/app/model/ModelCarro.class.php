<?php
/**
 * Description of ModelCarro
 *
 * @author adriano
 */
class ModelCarro extends Model {
  
  public function __construct() {
    
    self::$TABELA = "produtos";
    self::$TABELA_ALIAS = "p";

    self::$CAMPOS = array(
      'id', 
      'produto_nome', 
      'produto_descricao', 
      'produto_valor', 
      'produto_fabricante', 
      'produto_url', 
      'produto_imagem', 
      'produto_ativo', 
      'item_images', 
      'item_topicos', 
      'categoria_id', 
      'produto_keys', 
      'modelo_id', 
      'produto_ano', 
      'produto_video', 
      'produto_importado'
    );
    
    self::$ORDEM_INICIAL = "produto_nome";

    parent::__construct();
  }
  
  
}
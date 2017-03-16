<?php

/**
 * Description of DaoCarros
 *
 * @author adriano
 */
final class DaoCarros {
  
  public static function getSelect($postData) {
    $aSQL = array();
    
    $aSQL[] = "SELECT SQL_CALC_FOUND_ROWS";
      self::montarFields($aSQL, $postData);
      
    $aSQL[] = "FROM produtos pro ";
      self::montarJoins($aSQL, $postData);
      
    $aSQL[] = "WHERE";
      $aSQL[] = "1=1";
      self::montarWhere($aSQL, $postData);
      
    $aSQL[] = "ORDER BY ";
      self::montarOrderBy($aSQL, $postData);
      
    $aSQL[] = "LIMIT ";
    $aSQL[] = "{$postData['start']}, {$postData['limit']};";
    
    $sql = join(" ", $aSQL);

    return $sql;
  }
  
  private static function montarFields(array &$aSQL, array $postData) {
	$aSQL[] = "pro.id,";
    $aSQL[] = "pro.produto_nome,";
    $aSQL[] = "pro.produto_descricao,";
    $aSQL[] = "pro.produto_valor,";
    $aSQL[] = "pro.produto_fabricante,";
    $aSQL[] = "pro.produto_url,";
    $aSQL[] = "pro.produto_imagem,";
    $aSQL[] = "pro.produto_ativo,";
    $aSQL[] = "pro.item_images,";
    $aSQL[] = "pro.item_topicos,";
    $aSQL[] = "pro.categoria_id,";
    $aSQL[] = "pro.produto_keys,";
    $aSQL[] = "pro.modelo_id,";
    $aSQL[] = "mdl.modelo_nome,";
    $aSQL[] = "mdl.marca_id,";
    $aSQL[] = "mar.marca_nome,";
    $aSQL[] = "pro.produto_ano,";
    $aSQL[] = "pro.produto_video,";
    $aSQL[] = "pro.produto_importado";
  }
  
  private static function montarJoins(array &$aSQL, array $postData) {
	$aSQL[] = "INNER JOIN modelos mdl ON ( pro.modelo_id = mdl.id )";
    $aSQL[] = "INNER JOIN marcas mar ON (mar.id = mdl.marca_id)";
  }

  private static function montarWhere(array &$aSQL, array $postData) {

    if ( $postData['tipo'] === 'pai' ) {
      self::montarWherePai($aSQL, $postData);
    }
    else if ( $postData['tipo'] === 'filho' ) {
      self::montarWhereFilhos($aSQL, $postData);
    }    
  }
  
  private static function montarWherePai(array &$aSQL, array $postData) {
    
    if ($postData['filtro'] !== "todos") {
      $aSQL[] = "AND mar.id = '{$postData['id']}' ";
    }
    
    self::montarWhereDaPesquisa($aSQL, $postData);
  }
  
  private static function montarWhereFilhos(array &$aSQL, array $postData){

    if ($postData['filtro'] !== "todos") {
      $aSQL[] = "AND mdl.id = '{$postData['id']}' ";
    }

    self::montarWhereDaPesquisa($aSQL, $postData);
  }
  
  private static function montarWhereDaPesquisa(array &$aSQL, array $postData){
    
    if (isset($postData['pesquisar'])) {
      if (!empty($postData['pesquisar'])) {
        $aSQL[] = "AND";
        $aSQL[] = "(";
        $aSQL[] =   "pro.produto_nome LIKE '%{$postData['pesquisar']}%' OR ";
        $aSQL[] =   "pro.produto_valor LIKE '%{$postData['pesquisar']}%' OR ";
        $aSQL[] =   "pro.produto_ano LIKE '%{$postData['pesquisar']}%' OR ";
        $aSQL[] =   "mdl.modelo_nome LIKE '%{$postData['pesquisar']}%' OR ";
        $aSQL[] =   "mar.marca_nome LIKE '%{$postData['pesquisar']}%'";
        $aSQL[] = ")";
      }
    }
    
  }
  
  private static function montarOrderBy(array &$aSQL, array $postData) {
    $aSQL[] = "mar.marca_nome, ";
    $aSQL[] = "mdl.modelo_nome, ";
    $aSQL[] = "pro.produto_nome ";
  }
  
}
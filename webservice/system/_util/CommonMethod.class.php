<?php

/**
 * Description of CommonMethod
 *
 * @author adriano
 */
final class CommonMethod {
 
  /**
   * Funde varios arrays lineares em um unicio array linear.
   * 
   * @param type $aArrays
   */
  public static function mergeArray($aArrays) {
    $aRetorno = array();
    
    for ( $i=0; $i <= count($aArrays)-1; $i++ ) {
      $array= $aArrays[$i];
      
      if (count($array) > 0 ) {
        foreach ($array as $key => $value) {
          $aRetorno[$key] = $value;
        }
      }
      
    }
    
    return $aRetorno;
  }
  
  /**
   * Filtra os dados de um array, pelo array de chaves passado.
   * 
   * @param Mixed $aItems Array ou String a ser filtrados
   * @param Array $aGets Array a ser filtrado.
   * 
   * @return Mixed $results Array ou String o valor filtrado.
   */
  public static function getElements($aGets, $aItems) {
    if (isset($aItems['data'])) {
      $items = json_decode($aItems['data'], true);
    }
    else {
      $items = array($aItems);
    }

    $aRetorno = array();

    for ($i = 0; $i <= count($aGets) - 1; $i++) {
      $key = $aGets[$i];
      foreach ($items[0] as $k => $v) {
        if ($key === $k) {
          $aRetorno[$k] = $v;
        }
      }
    }

    return $aRetorno;
  }
 
  /**
   *  Obtem o ip de quem tentou fazer o acesso
   *  @return Int ip = Ip da tentativa e acesso.
   */
  public static function getIp() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
      $ip = $_SERVER['HTTP_CLIENT_IP'];
    } 
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
      $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } 
    else {
      $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
  }
  
  /**
   * Obtem o ip reverso(host), de um endereço IP passado como parametro.
   * 
   * @param String $ip String
   * 
   * @return String $hostname Host reverso do IP informado.
   */
  public static function getIpReversao($ip) {
    $hostname = gethostbyaddr($ip);

    return $hostname;
  }
  
  /**
   * Verifica se o acesso esta vindo de um dispositivo movel
   * 
   * @return boolean
   */
  public static function isMovel() {
    $isMovel = false;
    if (isset($_SERVER["HTTP_USER_AGENT"])) {
      $user_agents = array("Android", "mobile", "Mobile", "midp", "j2me", "avantg", "docomo", "novarra", "palmos", "palmsource", "240x320", "opwv", "chtml", "pda", "windows\ ce", "mmp\/", "blackberry", "mib\/", "symbian", "wireless", "nokia", "hand", "mobi", "phone", "cdm", "up\.b", "audio", "SIE\-", "SEC\-", "samsung", "HTC", "mot\-", "mitsu", "sagem", "sony", "alcatel", "lg", "erics", "vx", "NEC", "philips", "mmm", "xx", "panasonic", "sharp", "wap", "sch", "rover", "pocket", "benq", "java", "pt", "pg", "vox", "amoi", "bird", "compal", "kg", "voda", "sany", "kdd", "dbt", "sendo", "sgh", "gradi", "jb", "\d\d\di", "moto");
      foreach ($user_agents as $user_string) {
        if (preg_match("/" . $user_string . "/i", $_SERVER["HTTP_USER_AGENT"])) {
          $isMovel = true;
        }
      }
    }

    return $isMovel;
  }
  
  /**
   * Formata uma String com valor adicionado a esquerda.
   * 
   * @param String $str  String a ser formatada.
   * @param Int $qtd  Quantidade de caracter a ser adicionado a string;
   * @param String $char Caracter a se adicionado a esquerda da string;
   * 
   * @return String String formatada
   */
  public static function padLeft($str, $qtd, $char="0") {
    return str_pad($str, $qtd, $char, STR_PAD_LEFT);
  }
  
  /**
   * Faz a macro substituicao dos itens de uma string pelo itens de um array, cuja chave do array se igual a %nomeDaChave na String passada.
   * 
   * @param type $str  String com as tag a ser substituidas.
   * @param type $vars Array com os valores a serem substituidos.
   * @param type $char Caracter marcador para macro substituicao.
   * 
   * @return String
   */
  public static function sprintf2($str, $vars, $char = '%') {
    if (!function_exists('cmp')) {

      function cmp($a, $b) {
        return strlen($b) - strlen($a);
      }
    }
    
    if (is_array($vars)) {
      uksort($vars, "cmp");

      foreach ($vars as $k => $v) {
        $str = str_replace($char . $k, $v, $str);
      }
    }

    return $str;
  }
  
  /**
   * Obtem a data e hora no padrao PtBr (DD/MM/YYYY HH:MM:SS)
   * 
   * @return String $dataHora Data e hora formatada.
   */
  public static function getDatahoraPtBr() {
    $dataHora = date("d/m/Y H:i:s");

    return $dataHora;
  }
  
  /**
   * Obtem a data no padrao PtBr (DD/MM/YYYY)
   * 
   * @return String $data Data formatada.
   */
  public static function getDataPtBr($dataMySql=null) {
    if (is_null($dataMySql) ){
      $data = date("d/m/Y");
    }
    else {
      $aData = explode("[/-]", $dataMySql); //rever
      $data = "{$aData[2]}/{$aData[1]}/{$aData[0]}";
    }
    return $data;
  }
  
  /**
   * Obtem a data e hora no padrao MySQL (YYYY-MM-DD HH:II:SS)
   * 
   * @return String $dataHora Contendo a data e a hora padronizadas.
   */
  public static function getDatahoraMySQL($dataPtBr=null) {
    if (is_null($dataPtBr)) {
      $dataHora = date("Y-m-d H:i:s");
    } 
    else {
      $aDataHora = explode(" ", $dataPtBr);
      $aData = explode("/", $aDataHora[0]);
      $dataHora = "{$aData[2]}-{$aData[1]}-{$aData[0]} {$aDataHora[1]}";
    }

    return $dataHora;
  }
  
  /**
   * Obtem a data no padrao MySQL (YYYY-MM-DD)
   * 
   * @return String $data Contendo a data padronizadas.
   */
  public static function getDataMySQL($dataPtBr=null) {
    if (is_null($dataPtBr) ){
      $data = date("Y-m-d");
    }
    else {
      $aData = explode("/", $dataPtBr);
      $data = "{$aData[2]}-{$aData[1]}-{$aData[0]}";
    }
    

    return $data;
  }

}
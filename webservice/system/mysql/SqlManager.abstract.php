<?php
/**
 * Description of Connections
 *
 * @author adriano
 */
abstract class SqlManager {

  private $PDO_CONNECTION = false;

  private function getConnection() {

    if ( !$this->PDO_CONNECTION instanceof PDO ) {

      $conn = new PDO("mysql:host=".  MySqlBase::HOST.";port=".  MySqlBase::PORT.";dbname=".  MySqlBase::BASE.";charset=utf8", MySqlBase::USER, MySqlBase::PASS);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $this->PDO_CONNECTION = $conn;
    }

    return $this->PDO_CONNECTION;
  }
  
  private function getTotal($conn) {
    $sql = "SELECT FOUND_ROWS() as 'total';";
    $query = $conn->query($sql);

    $aRetorno = $retorno = $query->fetchAll(PDO::FETCH_ASSOC);

    $total = $aRetorno[0]['total'];

    return $total;
  }

  private function processarConsulta(PDO $conn, $sql) {    
    try {
      $result = $conn->query($sql);

      $aDados = $result->fetchAll(PDO::FETCH_ASSOC);

      for ($i = 0; $i <= count($aDados) - 1; $i++) {
//        $aDados[$i] = array_map('utf8_encode', $aDados[$i]);
        $aDados[$i] = $aDados[$i];
      }

      $aDados['total'] = $this->getTotal($conn);

      return $aDados;
    }
    catch (PDOException $e) {
      throw new Exception("Erro ao processar a Consulta.<br/><br/>[CONSULTA]<br/>{$sql}<br/><br/>[EXCEPTION]<br/>{$e->getMessage()}<br/>");
    }
  }
  
  protected function sqlExec($sql) {
    $retorno = true;
    $conn = $this->getConnection();

    $strSQL = ( is_string($sql) ) ? $sql : $sql->getInstruction();

    $comando = strtoupper(substr($strSQL, 0, 6));
    if ($comando === "SELECT") {
      return $this->processarConsulta($conn, $sql);
    }
    else {
      $conn->query($strSQL);
      if ($comando === "INSERT"){
        $retorno = $conn->lastInsertId();        
      }
    }
    
    return $retorno;
  }

}

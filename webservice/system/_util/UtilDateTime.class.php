<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UtilDateTime
 *
 * @author adriano
 */
final class UtilDateTime {

  public function dateDifference($date1, $date2) {
    $d1 = (is_string($date1) ? strtotime($date1) : $date1);
    $d2 = (is_string($date2) ? strtotime($date2) : $date2);

    $diff_secs = abs($d1 - $d2);
    $base_year = min(date("Y", $d1), date("Y", $d2));

    $diff = mktime(0, 0, $diff_secs, 1, 1, $base_year);

    return array
      (
      "ano" => abs(substr(date('Ymd', $d1) - date('Ymd', $d2), 0, -4)),
      "months_total" => (date("Y", $diff) - $base_year) * 12 + date("n", $diff) - 1,
      "mes" => date("n", $diff) - 1,
      "days_total" => floor($diff_secs / (3600 * 24)),
      "dia" => date("j", $diff) - 1,
      "hours_total" => floor($diff_secs / 3600),
      "horas" => date("G", $diff),
      "minutes_total" => floor($diff_secs / 60),
      "minutos" => (int) date("i", $diff),
      "seconds_total" => $diff_secs,
      "segundos" => (int) date("s", $diff)
    );
  }

  private function datePtbr2en($date) {
    $aDataTime = explode(' ', $date);
    $data = $aDataTime[0];
    $hora = $aDataTime[1];
    list($dia, $mes, $ano) = explode('/', $data);

    return $ano . "/" . $mes . "/" . $dia . " " . $hora;
  }

  public function calcularTempoEmAberto($dataFinal, $dataInicial = '') {

    if (empty($dataInicial))
      $dataInicial = date('Y/m/d H:i:s');

    $dataFinal = $this->datePtbr2en($dataFinal);

    $aRetono = $this->dateDifference($dataInicial, $dataFinal);
    $sRetorno = '';
    if (!empty($aRetono['ano'])) {
      $sRetorno .= $aRetono['ano'] . ' anos ';
    }

    if (!empty($aRetono['mes'])) {
      $sRetorno .= $aRetono['mes'] . ' meses ';
      if (!empty($aRetono['ano']))
        return $sRetorno;
    }

    if (!empty($aRetono['dia'])) {
      $sRetorno .= $aRetono['dia'] . ' dias ';
      if (!empty($aRetono['ano']) or ! empty($aRetono['mes']))
        return $sRetorno;
    }

    if (!empty($aRetono['horas'])) {
      $sRetorno .= $aRetono['horas'] . ' horas ';
      if (!empty($aRetono['mes']) or ! empty($aRetono['dia']))
        return $sRetorno;
    }

    if (!empty($aRetono['minutos']))
      $sRetorno .= $aRetono['minutos'] . ' minutos ';
    if (!empty($aRetono['dia']) or ! empty($aRetono['horas']))
      return $sRetorno;

    if (!empty($aRetono['segundos'])) {
      $sRetorno .= $aRetono['segundos'] . ' segundos ';
      return $sRetorno;
    }

    if (empty($sRetorno))
      return '0 segundos ';
  }

  public function adicionarDiaEmUmaData($dataEn, $qtdDias) {
    $day = $qtdDias;
    $mth = 0;
    $yr = 0;
    $cd = strtotime($dataEn);
    $novaData = date('Y-m-d H:i:s', mktime(date('h', $cd), date('i', $cd), date('s', $cd), date('m', $cd) + $mth, date('d', $cd) + $day, date('Y', $cd) + $yr));

    return $novaData;
  }

  public function removerDiaEmUmaData($dataEn, $qtdDias) {
    $day = $qtdDias;
    $mth = 0;
    $yr = 0;
    $cd = strtotime($dataEn);
    $novaData = date('Y-m-d H:i:s', mktime(date('h', $cd), date('i', $cd), date('s', $cd), date('m', $cd) + $mth, date('d', $cd) - $day, date('Y', $cd) + $yr));

    return $novaData;
  }

  public function incrementarMes($dataEn, $qtdMes) {
    $day = 0;
    $mth = $qtdMes;
    $yr = 0;
    $cd = strtotime($dataEn);

    $novaData = date('Y-m-d H:i:s', mktime(date('h', $cd), date('i', $cd), date('s', $cd), date('m', $cd) + $mth, date('d', $cd) - $day, date('Y', $cd) + $yr));

    return $novaData;
  }

  public function decrementarMes($dataEn, $qtdMes) {
    $day = 0;
    $mth = $qtdMes;
    $yr = 0;
    $cd = strtotime($dataEn);

    $novaData = date('Y-m-d H:i:s', mktime(date('h', $cd), date('i', $cd), date('s', $cd), date('m', $cd) - $mth, date('d', $cd) + $day, date('Y', $cd) + $yr));

    return $novaData;
  }

}

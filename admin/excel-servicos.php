<?php
require_once 'dbconfig.php';
error_reporting(~E_ALL);

$arqexcel = "<meta charset='UTF-8'>";

$arqexcel .= "<table border='1'>";
$arqexcel .= "<thead>
    <tr>
      <th>NOME DO SERVIÇO</th>
      <th>ESPECIALIDADE</th>
      <th>PARCEIRO</th>
      <th>CONTATO</th>
      <th>VALOR PARTICULAR</th>
      <th>EXIBIR VALOR PARTICULAR</th>
      <th>VALOR CENTROCARD</th>
      <th>TIPO</th>
    </tr>
  </thead>
  <tbody>";
$stmt = $DB_con->prepare("SELECT * FROM services ORDER BY id DESC");
$stmt->execute();
if ($stmt->rowCount() > 0) {
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    extract($row);

    $arqexcel .= "<tr>
      <td>$name</td>
      <td>";
    if ($specialty == null or '') {
      $arqexcel .= "NÃO INFORMADO";
    } else {
      $arqexcel .= $specialty;
    }
    $arqexcel .= "</td>";
    $arqexcel .= "<td>";
    if ($partner == null or '') {
      $arqexcel .= "NÃO INFORMADO";
    } else {
      $arqexcel .= $partner;
    }
    $arqexcel .= "<td>";
    if ($contact == null or '') {
      $arqexcel .= "NÃO INFORMADO";
    } else {
      $arqexcel .= $contact;
    }
    $arqexcel .= "</td>";
    $arqexcel .= "<td>";
    if ($private == null or '') {
      $arqexcel .= "NÃO INFORMADO";
    } else {
      $arqexcel .= $private;
    }
    $arqexcel .= "</td>";
    $arqexcel .= "<td>";
    if ($private_status == null or '') {
      $arqexcel .= "NÃO INFORMADO";
    }
    if ($private_status == '1') {
      $arqexcel .= "SIM";
    }
    if ($private_status == '2') {
      $arqexcel .= "NÃO";
    }
    $arqexcel .= "</td>";
    $arqexcel .= "<td>";
    if ($centrocard == null or '') {
      $arqexcel .= "NÃO INFORMADO";
    } else {
      $arqexcel .= $centrocard;
    }
    $arqexcel .= "</td>";
    $arqexcel .= "<td>";
    if ($type == null or '') {
      $arqexcel .= "NÃO INFORMADO";
    } else {
      $arqexcel .= $type;
    }
    $arqexcel .= "</td>";
    $arqexcel .= "</tr>";
  }
}
$arqexcel .= "</tbody>
  </table>";

header("Content-Type: application/xls");
header("Content-Disposition:attachment; filename = relatorio-servicos-site.xls");

echo $arqexcel;

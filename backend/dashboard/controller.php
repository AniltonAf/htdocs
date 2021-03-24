<?php

$action = filter_input(INPUT_POST, 'action');

require 'sql.php';
require '../enviroment/function.php';
$data = new Data();
//defenir fuso horairio para definir hora com php
date_default_timezone_set("Atlantic/Cape_Verde");

session_start();

//
switch ($action) {

  case 'count_estado': //Contagem dos estados na tabela gerador config
    $response["gerador_status"]["on"] = $data->count_estado("gerador_status", true);
    $response["gerador_status"]["off"] = $data->count_estado("gerador_status", false);
    $response["gerador_avariado"]["on"] = $data->count_estado("avariado", true);
    $response["gerador_avariado"]["off"] = $data->count_estado("avariado", false);
    $response["rede_publica"]["on"] = $data->count_estado("rede_publica", true);
    $response["rede_publica"]["off"] = $data->count_estado("rede_publica", false);
    $response["qua_aut_trans"]["on"] = $data->count_estado("qua_aut_trans", true);
    $response["qua_aut_trans"]["off"] = $data->count_estado("qua_aut_trans", false);
    $response["low_fuel"]["on"] = $data->count_estado("low_fuel", true);
    $response["low_fuel"]["off"] = $data->count_estado("low_fuel", false);
    echo json_encode($response);
    break;

  case 'chart_estado':
    $chart_id = filter_input(INPUT_POST, 'chart_id');
    $res=[];
    if($chart_id==1){
      $res = [
        ['Estado', 'Quantidade'],
        ['Ligado', intval($data->count_estado("gerador_status", true))],
        ['Desligado', intval($data->count_estado("gerador_status", false))],
        ['Avariado', intval($data->count_estado("avariado", true))],
        ['Baixo nivel combustivel', intval($data->count_estado("low_fuel", true))]
      ];
    }
    elseif($chart_id==2){
      $res = [
        ['Estado', 'Quantidade'],
        ['Operacional', intval($data->count_estado("rede_publica", false))],
        ['Avariado', intval($data->count_estado("rede_publica", true))]
      ];
    }
    elseif($chart_id==3){
      $res = [
        ['Estado', 'Quantidade'],
        ['Operacional', intval($data->count_estado("qua_aut_trans", true))],
        ['Avariado', intval($data->count_estado("qua_aut_trans", false))]
      ];
    }
    
    echo json_encode($res);
    break;

    case 'chart_top_10':
      $chart_id = filter_input(INPUT_POST, 'chart_id');
      $res=[];
      if($chart_id==1){
        $response = $data->count_historico("avariado", false);

        foreach($response as $item){
          $res[]=[$item['descricao'],intval($item['qtd'])];
        }
      }
      elseif($chart_id==2){
        $response = $data->count_historico("rede_publica", true);

        foreach($response as $item){
          $res[]=[$item['descricao'],intval($item['qtd'])];
        }
      }
      elseif($chart_id==3){
        $response = $data->count_historico("qua_aut_trans", false);

        foreach($response as $item){
          $res[]=[$item['descricao'],intval($item['qtd'])];
        }
      }
      echo json_encode($res);
      break;

  case 'get_gerador':
    $id = filter_input(INPUT_POST, 'id');
    $gerador = $data->getGerador($id);
    $response = [
      "status" => true,
      "gerador" => $gerador,
      "time" => date('d/m H:i'),
    ];

    echo json_encode($response);
    break;

  case 'get_geradores': //apagar grupo
    $geradores = $data->getGeradores();

    $dados = array();

    foreach ($geradores as $line) {
      $estado_icon = '';
      if ($line["avariado"] == null) {
        $estado = '<div class="badge badge-sm badge-warning">Não configurado</div>';
        $estado_icon = 'warning';
      } elseif ($line["avariado"] == 1) {
        $estado = '<div class="badge badge-sm badge-danger">Avariado</div>';
        $estado_icon = 'danger';
      } elseif ($line["gerador_status"]) {
        $estado = '<div class="badge badge-sm badge-success">Funcional</div>';
        $estado_icon = 'success';
      } else {
        $estado = '<div class="badge badge-sm badge-info">Desligado</div>';
        $estado_icon = 'info';
      }
      $dados[] = [
        "type" => "Feature",
        "properties" => [
          "description" => '
							<strong >' . $line["descricao"] . '</strong>
							<table class="table table-sm table-striped" style="min-width: 200px;">
								<tr>
									<td>Fabricante</dh>
									<td>' . $line["fabricante"] . '</td>
								</tr>
								<tr>
									<td>Modelo</td>
									<td>' . $line["modelo"] . '</td>
								</tr>
								<tr>
									<td>Estado Gerador</td>
									<td>' . $estado . '</td>
								</tr>
								<tr>
									<td>Hora de Trabalho</td>
									<td>' . $line["hora_trabalho"] . 'min</td>
								</tr>
							</table>

						',
          "id" => $line["gerador_id"],
          "icon" => $estado_icon,
          'iconSize' => [26, 26]
        ],
        "geometry" => [
          "type" => "Point",
          "coordinates" => [(float)$line["longitude"], (float)$line["latitude"]]
        ]
      ];
    }

    $response = [
      "status" => true,
      "data" => $dados
    ];

    echo json_encode($response);

    break;

  case 'get_geradorMarker': //apagar grupo
    $gerador_id = filter_input(INPUT_POST, 'gerador_id');
    $estado_marker = filter_input(INPUT_POST, 'estado');
    $line = $data->getGerador($gerador_id);

    // horas trabalho gerador
  //  $horas_trabalhos= $data->horas_trabalho($gerador_id);

  //var_dump($horas_trabalhos);
  

    $estado_icon = '';
    if ($line["avariado"] == null) {
      $estado = '<div class="badge badge-sm badge-warning">Não configurado</div>';
      $estado_icon = 'warning';
    } elseif ($line["avariado"] == 1) {
      $estado = '<div class="badge badge-sm badge-danger">Avariado</div>';
      $estado_icon = 'danger';
    } elseif ($line["gerador_status"]) {
      $estado = '<div class="badge badge-sm badge-success">Funcional</div>';
      $estado_icon = 'success';
    } else {
      $estado = '<div class="badge badge-sm badge-info">Desligado</div>';
      $estado_icon = 'info';
    }

    if (strcmp($estado_icon, $estado_marker) == 0) {
      $response = ["status" => false];
    } else {
      $dados = [
        "type" => "Feature",
        "properties" => [
          "description" => '
									<strong >' . $line["descricao"] . '</strong>
									<table class="table table-sm table-striped" style="min-width: 200px;">
										<tr>
											<td>Fabricante</dh>
											<td>' . $line["fabricante"] . '</td>
										</tr>
										<tr>
											<td>Modelo</td>
											<td>' . $line["modelo"] . '</td>
										</tr>
										<tr>
											<td>Estado Gerador</td>
											<td>' . $estado . '</td>
										</tr>
										<tr>
											<td>Hora de Trabalho</td>
											<td>' . $line["hora_trabalho"] . 'min</td>
										</tr>
									</table>

								',
          "id" => $line["gerador_id"],
          "icon" => $estado_icon,
          'iconSize' => [26, 26]
        ],
        "geometry" => [
          "type" => "Point",
          "coordinates" => [(float)$line["longitude"], (float)$line["latitude"]]
        ]
      ];

      $response = ["status" => true, "data" => $dados];
    }


    echo json_encode($response);


    break;

  case 'get_server': //apagar grupo
    $server = $data->getServer();

    $response = [
      "status" => true,
      "server" => $server
    ];

    echo json_encode($response);

    break;

  case 'last5';
    $response = $data->last5event();

    echo json_encode($response);

    break;


  default:
    # code...
    break;
}

<?php

	$action= filter_input(INPUT_POST, 'action');

	require 'sql.php';
	$data = new Data();

	session_start();

	switch ($action) {

		case 'list':
			// Carregar o historico de Eventos ocorridos  nos geradores
			$response = $data->list();

    //  echo json_encode($response);

			echo printAll($response);

			break;

      case 'filtrar':

        $gerador_id = filter_input(INPUT_POST, 'gerador_id');
        $gerador_status = filter_input(INPUT_POST, 'gerador_status');
        $avariado = filter_input(INPUT_POST, 'avariado');
        $time = filter_input(INPUT_POST, 'data');

        $datas = explode(' - ',$time);

        $data_in =$datas[0];

        $data_out=$datas[1];


        $response = $data->filtrar($gerador_id, $gerador_status, $avariado, $data_in, $data_out);

        echo printAll($response);

		default:
			# code...
			break;
	}



  function printAll($response){
    $text = '';
			foreach ($response as $item) {
        $estado=$item["user_estado_envio"]?'Enviado':'Não Enviado';
				$text .= '<tr>';
				$text .= '<td>' . $item["user_nome"] . '</td>';
        $text .= '<td>' . $estado . '</td>';
        $text .= '<td>' . $item["tipo"] . '</td>';
        $text .= '<td>' . $item["menssagem"] . '</td>';
				$text .= '<td>' . $item['create_ut'] . '</td>';
				$text .= '</tr>';
			}

      return $text;
  }

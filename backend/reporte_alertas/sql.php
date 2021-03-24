<?php

require '../enviroment/db_connection.php';



class Data extends DbConnection
{

  private $db;


  function __construct()
  {
    $this->db = parent::getConnection();
  }


  private function data($res)
  {
    $data = array();

    while ($linha = $res->fetch(PDO::FETCH_ASSOC)) {
      $data[] = $linha;
    }

    return $data;
  }

  public function list()
  {

    try {

      $res = $this->db->prepare('SELECT * FROM monogerador.reporte_alertas ra  order by ra.create_ut desc'); //

      //$res->bindValue(':estado',$estado);

      $res->execute();

      $data = array();

      while ($linha = $res->fetch(PDO::FETCH_ASSOC)) {
        //$data[] = $linha;
        if ($linha['user_send'] && $linha['user_send'] != 'null' && $linha['user_send'] != '') {
          $user_state = json_decode($linha['user_send'], true);
          if (isset($user_state['success'])) {
            foreach ($user_state['success'] as $user_id) {
              $user = $this->getUser($user_id);
              $linha['user_nome'] = $user['nome'];
              $linha['user_estado_envio'] = true;
              $data[] = $linha;
            }
          }
          if (isset($user_state['fail'])) {
            foreach ($user_state['fail'] as $user_id) {
              $user = $this->getUser($user_id);
              $linha['user_nome'] = $user['nome'];
              $linha['user_estado_envio'] = false;
              $data[] = $linha;
            }
          }
        }
      }

      return $data;

      //return $this->data($res);

    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  }


  function filtrar($gerador_id, $gerador_status, $avariado, $data_in, $data_out)
  {
    try {

      $filtro = '';

      if ($gerador_id || $gerador_id != '') $filtro = $filtro == '' ? " where gerador_id='" . $gerador_id . "'" : $filtro . " and gerador_id='" . $gerador_id . "'";

      if ($gerador_status || $gerador_status != '') $filtro = $filtro == '' ? " where gerador_status='" . $gerador_status . "'" : $filtro . " and gerador_status='" . $gerador_status . "'";

      if ($avariado || $avariado != '') $filtro = $filtro == '' ? " where avariado='" . $avariado . "'" : $filtro . " and avariado='" . $avariado . "'";


      if ($data_in && $data_in != '' && $data_out && $data_out != '') $filtro = $filtro == '' ? " where (create_h_ut between '" . $data_in . "' and '" . $data_out . "')" : $filtro . " and (create_h_ut between '" . $data_in . "' and '" . $data_out . "')";

      $res = $this->db->prepare('SELECT gh.*,g.descricao FROM monogerador.gerador_historico gh join monogerador.gerador g on g.id=gh.gerador_id' . $filtro . ' order by gh.create_h_ut desc');

      //$res->bindValue(':estado',$estado);

      $res->execute();

      return $this->data($res);
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  }

  public function getUser($user_id)
  {

    try {
      //$id_utilizador = $_SESSION['caixa_monitorizacao']['user']['id'];

      $res = $this->db->prepare('SELECT u.nome FROM utilizador as u WHERE id=:user_id'); // and g.id_grupo in (select id_grupo from monogerador.grupo_acesso where id_utilizador=:id_utilizador)

      $res->bindValue(':user_id', $user_id);
      //$res->bindValue(':id_utilizador', $id_utilizador);

      $res->execute();

      return $res->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  }
}

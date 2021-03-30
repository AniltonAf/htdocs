<?php

require '../enviroment/db_connection.php';



Class Data extends DbConnection{

	private $db;


	function __construct(){
		$this->db=parent::getConnection();
	}


	private function data($res){
		$data=array();

		while($linha =$res->fetch(PDO::FETCH_ASSOC)){
			$data[]=$linha;
		}

		return $data;
	}

	public function list(){

		try{

			$res = $this->db->prepare('SELECT gh.*,g.descricao FROM monogerador.gerador_historico gh join monogerador.gerador g on g.id=gh.gerador_id order by gh.create_h_ut desc');

			$res->execute();

			return $this->data($res);

		}catch(PDOException $e){
				echo $e->getMessage();
		}
	}


  function filtrar($gerador_id, $gerador_status, $avariado, $rede_publica, $power_edificio, $qua_aut_trans, $data_in, $data_out){
    try{

      $filtro='';

      if($gerador_id || $gerador_id!='') $filtro= $filtro==''?" where gerador_id='".$gerador_id."'" :$filtro." and gerador_id='".$gerador_id."'";

      if($gerador_status || $gerador_status!='') $filtro= $filtro==''?" where gerador_status='".$gerador_status."'" :$filtro." and gerador_status='".$gerador_status."'";

      if($avariado || $avariado!='') $filtro= $filtro==''?" where avariado='".$avariado."'" :$filtro." and avariado='".$avariado."'";

	  if($rede_publica || $rede_publica!='') $filtro= $filtro==''?" where rede_publica='".$rede_publica."'" :$filtro." and rede_publica='".$rede_publica."'";

	  if($power_edificio || $power_edificio!='') $filtro= $filtro==''?" where power_edificio='".$power_edificio."'" :$filtro." and power_edificio='".$power_edificio."'";

	  if($qua_aut_trans || $qua_aut_trans!='') $filtro= $filtro==''?" where qua_aut_trans='".$qua_aut_trans."'" :$filtro." and qua_aut_trans='".$qua_aut_trans."'";

      if($data_in && $data_in!='' && $data_out && $data_out!='') $filtro= $filtro==''?" where (create_h_ut between '".$data_in."' and '".$data_out."')" :$filtro." and (create_h_ut between '".$data_in."' and '".$data_out."')";

			$res = $this->db->prepare('SELECT gh.*,g.descricao FROM monogerador.gerador_historico gh join monogerador.gerador g on g.id=gh.gerador_id'.$filtro.' order by gh.create_h_ut desc');

			//$res->bindValue(':estado',$estado);

			$res->execute();

			return $this->data($res);

		}catch(PDOException $e){
				echo $e->getMessage();
		}
  }

	public function getGerador($gerador_id ){

		try{
			$id_utilizador=$_SESSION['caixa_monitorizacao']['user']['id'];

			$res = $this->db->prepare('SELECT * FROM gerador as g WHERE id=:gerador_id and g.id_grupo in (select id_grupo from monogerador.grupo_acesso where id_utilizador=:id_utilizador)');

			$res->bindValue(':gerador_id',$gerador_id );
			$res->bindValue(':id_utilizador',$id_utilizador);

			$res->execute();

			return $this->data($res);

		}catch(PDOException $e){
				echo $e->getMessage();
		}
	}

}


?>

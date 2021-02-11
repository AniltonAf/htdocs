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

	public function count_estado($campo,$status){
		try{

			$id_utilizador=$_SESSION['caixa_monitorizacao']['user']['id'];

		//	$res = $this->db->prepare('SELECT Count(*) as qtd FROM gerador_config WHERE '.$campo.'=:status');
			$res = $this->db->prepare('SELECT Count(*) as qtd FROM gerador_config as gc join gerador as g on g.id=gc.gerador_id WHERE '.$campo.'=:status and g.id_grupo in (select id_grupo from grupo_acesso where id_utilizador=:id_utilizador)');
			
			$res->bindValue(':status',$status);
			$res->bindValue(':id_utilizador',$id_utilizador);

			$res->execute();

			$line=$res->fetch(PDO::FETCH_ASSOC);

			return $line['qtd'];

		}catch(PDOException $e){
				echo $e->getMessage();
		}
	}

	public function getGeradores(){
		$estado=1;
		try{


      $id_utilizador=$_SESSION['caixa_monitorizacao']['user']['id'];

			$res = $this->db->prepare('SELECT * FROM gerador as g join gerador_config as gc on gc.gerador_id=g.id WHERE estado=:estado and g.id_grupo in (select id_grupo from monogerador.grupo_acesso where id_utilizador=:id_utilizador)');

			$res->bindValue(':estado',$estado);
      $res->bindValue(':id_utilizador',$id_utilizador);

			$res->execute();

			return $this->data($res);

		}catch(PDOException $e){
				echo $e->getMessage();
		}
	}

	public function getGerador($id){
		$estado=1;
		try{

			$res = $this->db->prepare('SELECT * FROM gerador as g join gerador_config as gc on gc.gerador_id=g.id WHERE g.id=:id and estado=:estado');

			$res->bindValue(':estado',$estado);
			$res->bindValue(':id',$id);

			$res->execute();

			return $res->fetch(PDO::FETCH_ASSOC);

		}catch(PDOException $e){
				echo $e->getMessage();
		}
	}

	public function getServer(){
		$estado=1;
		try{

			$res = $this->db->prepare('SELECT * FROM mqtt_server WHERE ativo_ws=:estado');

			$res->bindValue(':estado',$estado);

			$res->execute();

			return $res->fetch(PDO::FETCH_ASSOC);

		}catch(PDOException $e){
				echo $e->getMessage();
		}
	}

	public function getItem($id){
		try{

			$res = $this->db->prepare('SELECT * FROM grupo WHERE id=:id');

			$res->bindValue(':id',$id);

			$res->execute();

			return $this->data($res);

		}catch(PDOException $e){
				echo $e->getMessage();
		}
	}

	public function last5event(){

		try{

			$res = $this->db->prepare('SELECT * FROM gerador_historico as gh join gerador as g on gh.gerador_id=g.id ORDER BY gh.create_ut DESC LIMIT 10');

			$res->execute();
			
			return $this->data($res);


		}catch(PDOException $e){
				echo $e->getMessage();
		}
	}

}


?>

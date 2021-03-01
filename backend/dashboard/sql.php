$ git commit -m "Resolved merge conflict by incorporating both suggestions."<?php

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


  public function count_historico($campo,$status){
		try{

			$id_utilizador=$_SESSION['caixa_monitorizacao']['user']['id'];

		//	$res = $this->db->prepare('SELECT Count(*) as qtd FROM gerador_config WHERE '.$campo.'=:status');
			$res = $this->db->prepare('select g.descricao ,COUNT(gh.gerador_id) as qtd from monogerador.gerador_historico gh join monogerador.gerador g on g.id = gh.gerador_id where '.$campo.' =:status and g.id_grupo in (select id_grupo from monogerador.grupo_acesso where id_utilizador=:id_utilizador) group by gh.gerador_id order by COUNT(gh.gerador_id) desc  limit 10');

			$res->bindValue(':status',$status);
			$res->bindValue(':id_utilizador',$id_utilizador);

			$res->execute();

			return $this->data($res);;

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

			$id_utilizador=$_SESSION['caixa_monitorizacao']['user']['id'];

			$res = $this->db->prepare('SELECT * FROM gerador as g join gerador_config as gc on gc.gerador_id=g.id WHERE g.id=:id and estado=:estado and g.id_grupo in (select id_grupo from monogerador.grupo_acesso where id_utilizador=:id_utilizador)');

			$res->bindValue(':estado',$estado);
			$res->bindValue(':id',$id);
			$res->bindValue(':id_utilizador',$id_utilizador);

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

			$res = $this->db->prepare('SELECT * FROM grupo WHERE id=:id and g.id_grupo in (select id_grupo from grupo_acesso where id_utilizador=:id_utilizador)');

			$res->bindValue(':id',$id);

			$res->execute();

			return $this->data($res);

		}catch(PDOException $e){
				echo $e->getMessage();
		}
	}

	public function last5event(){

		try{

			$id_utilizador=$_SESSION['caixa_monitorizacao']['user']['id'];

			$res = $this->db->prepare('SELECT * FROM gerador_historico as gh join gerador as g on gh.gerador_id=g.id  where g.id_grupo in (select id_grupo from grupo_acesso where id_utilizador=:id_utilizador) ORDER BY gh.create_h_ut DESC LIMIT 10');

			$res->bindValue(':id_utilizador',$id_utilizador);

			$res->execute();

			return $this->data($res);


		}catch(PDOException $e){
				echo $e->getMessage();
		}
	}

}


?>

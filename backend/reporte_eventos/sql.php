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

			$res = $this->db->prepare('SELECT * FROM gerador_historico');
			
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
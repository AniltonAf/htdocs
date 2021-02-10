<?php

use Twilio\Http\Response;
use Twilio\Rest\Verify;

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
		//$estado=1;
		try{

		//	$res = $this->db->prepare('SELECT * FROM utilizador WHERE estado=:estado');
			$res = $this->db->prepare('SELECT * FROM utilizador');

		//	$res->bindValue(':estado',$estado);

			$res->execute();

			return $this->data($res);

		}catch(PDOException $e){
				echo $e->getMessage();
		}
	}

  public function listGrupo(){
		//$estado=1;
		try{

      session_start();
      $id=$_SESSION['caixa_monitorizacao']['user']['id'];
      ob_end_flush();

		//	$res = $this->db->prepare('SELECT * FROM utilizador WHERE estado=:estado');
			$res = $this->db->prepare('select * from monogerador.grupo_acesso as ga join monogerador.grupo g on g.id =ga.id_grupo where id_utilizador =:id');

		  $res->bindValue(':id',$id);

			$res->execute();

			return $this->data($res);

		}catch(PDOException $e){
				echo $e->getMessage();
		}
	}


	public function listPerfil(){
		$estado=1;
		try{

			$res = $this->db->prepare('SELECT * FROM perfilutilizador WHERE estado=:estado');

			$res->bindValue(':estado',$estado);

			$res->execute();

			return $this->data($res);

		}catch(PDOException $e){
				echo $e->getMessage();
		}
	}

	public function getItem($id){
		try{

			$res = $this->db->prepare('SELECT * FROM utilizador WHERE id=:id');

			$res->bindValue(':id',$id);

			$res->execute();

			return $this->data($res);

		}catch(PDOException $e){
				echo $e->getMessage();
		}
	}

	// função para deletar utilizadores
	public function delete($id,$estado,$delete_ut){
		$response=array();
		try{

			$res = $this->db->prepare('UPDATE utilizador SET estado=:estado, delete_ut=:delete_ut WHERE id=:id');

			$res->bindValue(':id',$id);
			$res->bindValue(':estado',$estado);
			$res->bindValue(':delete_ut',$delete_ut);

			$res->execute();

			$response['status']=true;

		}catch(PDOException $e){
			$response['status']=false;
		}
		return $response;
	}


		// função para desbloquear utilizadores
		public function desbloquear($id,$estado,$delete_ut){
			$response=array();
			try{

				$res = $this->db->prepare('UPDATE utilizador SET estado=:estado, delete_ut=:delete_ut WHERE id=:id');

				$res->bindValue(':id',$id);
				$res->bindValue(':estado',$estado);
				$res->bindValue(':delete_ut',$delete_ut);

				$res->execute();

				$response['status']=true;

			}catch(PDOException $e){
				$response['status']=false;
			}
			return $response;
		}


		// função para desbloquear utilizadores
		public function bloquear($id,$estado,$delete_ut){
			$response=array();
			try{

				$res = $this->db->prepare('UPDATE utilizador SET estado=:estado, delete_ut=:delete_ut WHERE id=:id');

				$res->bindValue(':id',$id);
				$res->bindValue(':estado',$estado);
				$res->bindValue(':delete_ut',$delete_ut);

				$res->execute();

				$response['status']=true;

			}catch(PDOException $e){
				$response['status']=false;
			}
			return $response;
		}

	// função para registar novos utilizadores
	public function register($nome,$numero_funcionario,$departamento,$funcao,$email,$telefone,$id_perfil_permission,$password,$username,$foto,$alerta_sms,$alerta_email,$estado,$create_ut){
		$response=array();
		try{

			$res = $this->db->prepare('INSERT INTO utilizador (nome,numero_funcionario,departamento,funcao,email,telefone,id_perfil_permission,password,username,foto,alerta_sms,alerta_email,estado,create_ut) VALUES (:nome,:numero_funcionario,:departamento,:funcao,:email,:telefone,:id_perfil_permission,:password,:username,:foto,:alerta_sms,:alerta_email,:estado,:create_ut)');

			$res->bindValue(':nome',$nome);
			$res->bindValue(':numero_funcionario',$numero_funcionario);
			$res->bindValue(':departamento',$departamento);
			$res->bindValue(':funcao',$funcao);
			$res->bindValue(':email',$email);
			$res->bindValue(':telefone',$telefone);
			$res->bindValue(':id_perfil_permission',$id_perfil_permission);
			$res->bindValue(':password',$password);
			$res->bindValue(':username',$username);
			$res->bindValue(':foto',$foto);
			$res->bindValue(':alerta_email',$alerta_email);
			$res->bindValue(':alerta_sms',$alerta_sms);
			$res->bindValue(':estado',$estado);
			$res->bindValue(':create_ut',$create_ut);

			$res->execute();

			$response['status']=true;

		}catch(PDOException $e){
			//echo $e->getMessage();
			$message='Erro ao registar utilizador';
			if(strpos($e->getMessage(),'Duplicate')>=0){
				$text=explode("'", $e->getMessage());
				$message=$text[3]." '".$text[1]."' já existe";
			}
			$response['status']=false;
			$response['message']=$message;
		}
		return $response;
	}
	// função para editar utilizadores
	public function edit($nome,$numero_funcionario,$departamento,$funcao,$email,$telefone,$id_perfil_permission,$foto,$alerta_sms,$alerta_email,$create_ut,$id){
		$response=array();
		try{


			if($foto){
				$res = $this->db->prepare('UPDATE utilizador SET nome=:nome,numero_funcionario=:numero_funcionario,departamento=:departamento,funcao=:funcao,email=:email,telefone=:telefone,id_perfil_permission=:id_perfil_permission,alerta_sms=:alerta_sms,alerta_email=:alerta_email,foto=:foto WHERE id=:id');
				$res->bindValue(':foto',$foto);
			}else{
				$res = $this->db->prepare('UPDATE utilizador SET nome=:nome,numero_funcionario=:numero_funcionario,departamento=:departamento,funcao=:funcao,email=:email,telefone=:telefone,id_perfil_permission=:id_perfil_permission,alerta_sms=:alerta_sms,alerta_email=:alerta_email WHERE id=:id');
			}



			$res->bindValue(':nome',$nome);
			$res->bindValue(':numero_funcionario',$numero_funcionario);
			$res->bindValue(':departamento',$departamento);
			$res->bindValue(':funcao',$funcao);
			$res->bindValue(':email',$email);
			$res->bindValue(':telefone',$telefone);
			$res->bindValue(':id_perfil_permission',$id_perfil_permission);
			$res->bindValue(':alerta_sms',$alerta_sms);
			$res->bindValue(':alerta_email',$alerta_email);
			$res->bindValue(':id',$id);

			$res->execute();

			$response['status']=true;

		}catch(PDOException $e){
			$message='Erro ao editar utilizador';
			if(strpos($e->getMessage(),'Duplicate')>=0){
				$text=explode("'", $e->getMessage());
				$message=$text[3]." '".$text[1]."' já existe";
			}
			$response['status']=false;
			$response['message']=$message;
			echo $e->getMessage();
		}
		return $response;
	}

	public function listPermition($id_perfil){
		$estado=1;
		try{

			$res = $this->db->prepare('SELECT p.id,p.nome,p.descrisao, IF((SELECT pp.id FROM perfil_permissao as pp where pp.id_per=p.id and pp.id_perf_util=:id_perfil),true,false) as permissao FROM `permissoes` as p order by p.nome asc');

			$res->bindValue(':id_perfil',$id_perfil);

			$res->execute();

			return $this->data($res);

		}catch(PDOException $e){
				echo $e->getMessage();
		}
	}

	// função para deletar permissao
	public function deletePermissao($id_perfil){

		try{

			$res = $this->db->prepare("DELETE FROM perfil_permissao WHERE id_perf_util=:id_perfil");

			$res->bindValue(':id_perfil',$id_perfil);

			$res->execute();

			return true;

		}catch(PDOException $e){
			return false;
		}
	}

	// função para atribuir permissao
	public function addPermissao($id_perfil,$id_per){

		try{

			$res = $this->db->prepare("INSERT INTO perfil_permissao (id_perf_util,id_per) VALUES (:id_perfil,:id_per)");

			$res->bindValue(':id_perfil',$id_perfil);
			$res->bindValue(':id_per',$id_per);

			$res->execute();

			return true;

		}catch(PDOException $e){
			return false;
		}
	}


  function verifyPassword($id,$password){
    try {

			$res = $this->db->prepare('SELECT id FROM utilizador WHERE id=:id AND password=:password');

			$res->bindValue(':id', $id);
			$res->bindValue(':password', hash('sha256', $password));

			$res->execute();

			return $res->rowCount()?true:false;
		} catch (PDOException $e) {
			echo $e->getMessage();
      return false;
		}
  }
  //Editar Perfil
  function editprofile($nome,$email,$telefone,$id,$old_password,$new_password, $confirmar_password){
    try{

      $response=[
        "message"=>null,
        "status"=>false,
      ];

      if(($old_password && (!$new_password || !$confirmar_password))  || ($new_password && (!$old_password || !$confirmar_password))  || ($confirmar_password && (!$old_password || !$new_password))){
        $response['message']="Todos os campos de password devem ser preenchidas";
        return $response;
      }
      if($old_password && $new_password && $confirmar_password){
        if(!$this->verifyPassword($id,$old_password)){
          $response['message']="Passsword antigo errado";
          return $response;
        }
        if(strcmp($new_password,$confirmar_password)!==0){
          $response['message']="Novo password e confirmar são diferentes";
          return $response;
        }

        $res = $this->db->prepare("UPDATE utilizador set password=:password, nome=:nome, telefone=:telefone, email=:email WHERE id=:id");
        $res->bindValue(':password',hash('sha256', $new_password));
      }else{
        $res = $this->db->prepare("UPDATE utilizador set nome=:nome, telefone=:telefone, email=:email WHERE id=:id");
      }



      $res->bindValue(':email',$email);
      $res->bindValue(':telefone',$telefone);
      $res->bindValue(':nome',$nome);
      $res->bindValue(':id',$id);

			$res->execute();

      $response["status"]=true;
      $response["message"]="Registado com sucesso, Sessão próximo a esgotar";
			return $response;

		}catch(PDOException $e){
      echo $e->getMessage();
			return false;
		}
  }

}

<?php 

function db_connect(){
	$pdo = null;
	try{
		$pdo = new PDO('mysql:host=localhost;dbname=prop','admin','admin');
		$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	}catch(Exception $e){
		 echo 'Connection failed: ' . $e->getMessage()."\n";
	}
	return $pdo;
}

function db_addTenant($email,$password,$firstName,$lastName,$DOB,$isMale){
	try{
		$pdo = db_connect();
		$stmt = $pdo->prepare(		
					'call create_tenant_login_details(:email,:password,:firstName,:lastName,:DOB,:isMale);'
				);
		
		$stmt->bindValue(':email',$email);
		$stmt->bindValue(':password',$password);
		$stmt->bindValue(':firstName',$firstName);
		$stmt->bindValue(':lastName',$lastName);
		$stmt->bindValue(':DOB',$DOB);
		$stmt->bindValue(':isMale',$isMale);
		
		$stmt->execute();
		
	}catch(PDOException $e){
		echo 'exception: db_addTenant';
		echo $e->getMessage();
	}
}

function db_isValidCred($email,$password){
	try{
		$pdo = db_connect();
		
		$stmt = $pdo->prepare('select isValidCred(:email,:password)');
		
		$stmt->bindValue(':email',$email);
		$stmt->bindValue(':password',$password);
		
		$stmt->execute();
		
		$resultArray = $stmt->fetch();	
		$resultVal = $resultArray[0];
		return $resultVal;
	}catch(PDOException $e){
		$e->getMessage();
	}
}

function db_getIdLogin($email){
	try{
		$pdo = db_connect();
		
		$stmt = $pdo->prepare('select getLoginId(:email)');
		
		$stmt->bindValue(':email',$email);
		
		$stmt->execute();
		
		
		$resultArray = $stmt->fetch();
		
		$resultVal = $resultArray[0];
		
		return $resultVal;
	}catch(PDOException $e){
		$e->getMessage();
	}
}

function db_updateTenant($loginId,$email,$password,$firstName,$lastName,$DOB,$isMale){
	try{
		$pdo = db_connect();
		$stmt = $pdo->prepare(		
					'call updateTenant(:loginId,:email,:password,:firstName,:lastName,:DOB,:isMale);'
				);
		
		$stmt->bindValue(':loginId',$loginId);
		$stmt->bindValue(':email',$email);
		$stmt->bindValue(':password',$password);
		$stmt->bindValue(':firstName',$firstName);
		$stmt->bindValue(':lastName',$lastName);
		$stmt->bindValue(':DOB',$DOB);
		$stmt->bindValue(':isMale',$isMale);
		
		$stmt->execute();
		
	}catch(PDOException $e){
		$e->getMessage();
	}
}

function db_getTenantDetails($loginId){
	$pdo = db_connect();
	try{
		
		
		$stmt = $pdo->prepare(
						'select * from v_tenant_details '.
						'where loginId = :loginId'
						);
		
		$stmt->bindValue(':loginId',$loginId);
		
		$stmt->execute();
		
		$resultArray = $stmt->fetch();
		
		return $resultArray;
	}catch(PDOException $e){
		$e->getMessage(); 
	}
}
?>


































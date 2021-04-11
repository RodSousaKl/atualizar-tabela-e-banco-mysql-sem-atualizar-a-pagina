<?php
	
	//Função para pegar tamanho do arquivo para apresentação FrontEnd.
	function By2M($size){
	$filesizename = array(" Bytes", " KB", " MB", " GB", " TB", " PB", " EB", " ZB", " YB");
	return $size ? round($size/pow(1024, ($i = floor(log($size, 1024)))), 2) . $filesizename[$i] : '0 Bytes';
	}

	//Começa as operações para tratar os dados.
    //require_once "pdo.php";
    require_once "pdo.php";
    
	// Verificar se foi enviando dados via GET
	if (!empty($_GET["documento"])) {
		$documento = $_GET['documento'];
		$documento = explode(";", $documento);

			try {

		    	$insereDoc=$pdo->prepare("INSERT INTO tb_temp (doc, rota, temp) VALUES (?, ?, ?)");
			    $insereDoc->bindParam(1, $documento[0]);
			    $insereDoc->bindParam(2, $documento[1]);
			    $insereDoc->bindParam(3, $documento[2]);
			    $insereDoc->execute();

			    if ($documento[0] == NULL || $documento[1] == NULL) {
			    	throw new Error("valor invalido");
			    }

		        try {
		        	//monta a tebela na div de retorno 
		        	$stmt = $pdo->prepare("SELECT * FROM tb_temp ");
		        		if ($stmt->execute()) {
			                while ($rs = $stmt->fetch(PDO::FETCH_OBJ)) {
			                	$id = $rs->ID;
			                	$doc = $rs->doc;
			                	$rot = $rs->rota;
			                	$temp = $rs->temp;
			                	echo "<tr>";
			                	echo "<td>".$doc."</td>";
			                	echo "<td>".$rot."</td>";
			                	echo "<td>".$temp." Anos</td>";
			                	echo "<td><a href = '#' id = '".$id."'style ='color: red;' onclick='deleta(".$id.");'>Deletar</td>";
			                	echo "</tr>";
			                }
		            	}else{
		        			throw new Error("valor invalido");
		        		}
		        	

		        } catch (Exception $e) {
		        			echo "<th>";
		                	echo "<td> ERRO </td>";
		                	echo "<td> ERRO </td>";
		                	echo "</th>";
		        }

		       


	    } catch (Exception $e) {
	    				echo "<th>";
	                	echo "<td> ERRO </td>";
	                	echo "<td> ERRO </td>";
	                	echo "</th>";
	    }

	}

	// Verificar se foi enviando dados via GET
	if (!empty($_GET["id"])) {
		$id = $_GET['id'];

		try {

			$stmt = $pdo->prepare('DELETE FROM tb_temp WHERE ID = :id');
			$stmt->bindParam(':id', $id);
			$stmt->execute();

			try {

		        	$stmt = $pdo->prepare("SELECT * FROM tb_temp ");
		        		if ($stmt->execute()) {
			                while ($rs = $stmt->fetch(PDO::FETCH_OBJ)) {
			                	$id = $rs->ID;
			                	$doc = $rs->doc;
			                	$rot = $rs->rota;
			                	$temp = $rs->temp;
			                	echo "<tr>";
			                	echo "<td>".$doc."</td>";
			                	echo "<td>".$rot."</td>";
			                	echo "<td>".$temp." Anos</td>";
			                	echo "<td><a href = '#' id = '".$id."'style ='color: red;' onclick='deleta(".$id.");'>Deletar</td>";
			                	echo "</tr>";
			                }
		            	}else{
		        			throw new Error("valor invalido");
		        		}
		        	

		        } catch (Exception $e) {
		        			echo "<th>";
		                	echo "<td> ERRO </td>";
		                	echo "<td> ERRO </td>";
		                	echo "</th>";
		        }

		} catch (Exception $e) {
					echo "<th>";
	                	echo "<td> ERRO </td>";
	                	echo "<td> ERRO </td>";
	                	echo "</th>";
		}

		

	}



   
	    

?>
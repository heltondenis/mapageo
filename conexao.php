<?php
    
    function fetch_customizado($stmt)
    {
            $result = array();
            $md = $stmt->result_metadata();
            $params = array();
            while($field = $md->fetch_field()) {
                $params[] = &$result[$field->name];
            }
            call_user_func_array(array($stmt, 'bind_result'), $params);
            if ($stmt->fetch()) {
                return $result;
            }

        return null;
    }

    //Escolha o servidor//
    $servidor = "";
    $user = "";
    $senha = "";
    $dbname = "";
    
    //Criar a conexao
    $conn = mysqli_connect($servidor, $user, $senha, $dbname);
    mysqli_set_charset($conn, 'utf8');
    
    if(!$conn){
        die("Falha na conexao: " . mysqli_connect_error());
    }else{
        //echo "Conexao realizada com sucesso";
    }      
?>

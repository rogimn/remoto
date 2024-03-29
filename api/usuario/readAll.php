<?php
    // include database and object files
    include_once '../config/database.php';
    include_once '../objects/usuario.php';

        function decrypt($data, $key) {
            $len = strlen($key);
            
                if($len < 16) {
                    $key = str_repeat($key, ceil(16 / $len));
                    $data = base64_decode($data);
                    $val = openssl_decrypt($data, 'AES-256-OFB', $key, 0, $key);
                    $val =  str_replace(' ', '', $val);
                } else {
                    die('N&atilde;o foi poss&iacute;vel descriptografar o login');
                }
            
            return $val;
        }
     
    // get database connection
    $database = new Database();
    $db = $database->getConnection();
     
    // prepare object
    $usuario = new Usuario($db);

    // key for unlock pass
    $enigma = base64_encode('?');
     
    // query usuario
    $sql = $usuario->readAll();
    
        // check if more than 0 record found
        if($sql->rowCount() > 0) {
            // usuario array
            $usuario_arr['usuario'] = array();
        
                while($row = $sql->fetch(PDO::FETCH_ASSOC)) {
                    extract($row);

                    // decrypt the user and pass
                    $usuario = decrypt($usuario, $enigma);
                    #$senha = decrypt($senha, $enigma);

                    $usuario_item = array(
                        'status' => true,
                        'idusuario' => $idusuario,
                        'nome' => $nome,
                        'usuario' => $usuario,
                        'senha' => $senha,
                        'email' => $email,
                    );

                    array_push($usuario_arr['usuario'], $usuario_item);
                }
        
            echo json_encode($usuario_arr['usuario']);
        } else {
            $usuario_arr = array('status' => false);
            echo json_encode($usuario_arr);
        }
?>
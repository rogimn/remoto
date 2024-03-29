<?php
    // include database and object files
    include_once '../config/database.php';
    include_once '../objects/servico.php';

    // get database connection
    $database = new Database();
    $db = $database->getConnection();

    // prepare service object
    $servico = new Servico($db);

    // vars to control this script
    $msg = "Campo obrigat&oacute;rio vazio.";

        //filtering the inputs
        if(empty($_POST['rand'])) { die('Vari&aacute;vel de controle nula.'); }
        if(empty($_POST['idservico'])) { die('Vari&aacute;vel de controle nula.'); } else {
            $servico->idservico = $_POST['idservico'];
        }
        if(empty($_POST['situacao'])) { die($msg); } else {
            $filtro = 1;
            $servico->idsituacao = $_POST['situacao'];
        }
        if(!empty($_POST['data_fim'])) {
            $servico->data_fim = $_POST['data_fim'];
        } else {
            $servico->data_fim = NULL;
        }
        if(!empty($_POST['hora_fim'])) {
            $servico->hora_fim = $_POST['hora_fim'];
        } else {
            $servico->hora_fim = NULL;
        }
        if(empty($_POST['solicitante'])) { die($msg); } else {
            $filtro++;
            $servico->idsolicitante = $_POST['solicitante'];
        }
        if(!empty($_POST['assunto'])) {
            $_POST['assunto'] = str_replace("'","&#39;",$_POST['assunto']);
            $_POST['assunto'] = str_replace('"','&#34;',$_POST['assunto']);
            $_POST['assunto'] = str_replace('%','&#37;',$_POST['assunto']);
            $servico->assunto = $_POST['assunto'];
        } else {
            $servico->assunto = '';
        }
        if(empty($_POST['solicitacao'])) { die($msg); } else {
            $filtro++;
            $_POST['solicitacao'] = str_replace("'","&#39;",$_POST['solicitacao']);
            $_POST['solicitacao'] = str_replace('"','&#34;',$_POST['solicitacao']);
            $_POST['solicitacao'] = str_replace('%','&#37;',$_POST['solicitacao']);
            $servico->solicitacao = $_POST['solicitacao'];
        }
        if(!empty($_POST['procedimento'])) {
            $_POST['procedimento'] = str_replace("'","&#39;",$_POST['procedimento']);
            $_POST['procedimento'] = str_replace('"','&#34;',$_POST['procedimento']);
            $_POST['procedimento'] = str_replace('%','&#37;',$_POST['procedimento']);
            $servico->procedimento = $_POST['procedimento'];
        } else {
            $servico->procedimento = '';
        }

        if($filtro == 3) {
            if($servico->update()) {
                echo'true';
            } else {
                die(var_dump($db->errorInfo()));
            }
        } else {
            die('Vari&aacute;vel de controle nula.');
        }

    unset($database,$db,$servico,$msg);
?>
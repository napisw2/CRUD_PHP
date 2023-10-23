<?php
    //ESTAMOS PEGANDO E RECEBENDO AS PASTAS DO PROPRIO CRUD PRIVADO,MAS COMO O CONTROLADOR PUBLICO VAI RECEBER TUDO O QUE ESTÁ AQUI,VAMOS
    //VOLTAR ALGUMAS CASAS NA DECLARAÇÃO PARA QUE O ARQUIVO RECEBIDO SEJA O QUE IRÁ SURTIR EFEITO NO PRIVADO,POIS É ISSO QUE O CONTROLADOR
    //PUBLICO QUER RECEBER

    require "../../crud_app_privado/conexao.php";
    require "../../crud_app_privado/modelo_tarefa.php";
    require "../../crud_app_privado/servico_tarefa.php";
    
    //LEMBRANDO QUE ACAO JÁ TEM O SEU VALOR PLOTADO EM TODA AS TAREFAS,OU SEJA, SE NAO ESTIVER NADA NO GET,VAI TER NO REQUIRE.
    
    $acao= isset($_GET['acao']) ? $_GET['acao'] : $acao;
    
    if($acao =='inserir'){
        
        $tarefa= new Tarefa();
        $tarefa->__set('tarefa',$_POST['tarefa_post']);

        $conexao= new Conexao();

        $servicoTarefa= new ServicoTarefa($conexao,$tarefa);
        $servicoTarefa->inserir();

        header('location: nova_tarefa.php?inclusao=sucesso');
    }else if($acao =='recuperar'){ //recuperar é a primeira coisa que acontece quando abrimos todas tarefas.

        $tarefa= new Tarefa();
        $conexao= new Conexao();

        $servicoTarefa= new ServicoTarefa($conexao,$tarefa);
        $tarefas= $servicoTarefa->recuperar();

    }else if($acao=='atualizar'){
        
      
     
        $tarefa= new Tarefa();
        $tarefa->__set('id', $_POST['id']);
        $tarefa->__set('tarefa', $_POST['tarefa']);

        $conexao= new Conexao();

        $servicoTarefa= new ServicoTarefa($conexao,$tarefa);
        $servicoTarefa->atualizar();
        
        if($servicoTarefa->atualizar()){

                if(isset($_GET['pag']) & $_GET['pag']=='todas'){
                header('location: todas_tarefas.php');    
                }else{
                header('location: index.php');
                }
        }
    }else if($acao=='remover'){
        $tarefa= new Tarefa();
        $tarefa->__set('id', $_GET['id']);

        $conexao= new Conexao();

        $servicoTarefa= new ServicoTarefa($conexao,$tarefa);
        $servicoTarefa->remover();
        
        if( isset($_GET['pag']) && $_GET['pag'] == 'index') {
			header('location: index.php');	
		} else {
			header('location: todas_tarefas.php');
		} 
       
    }else if($acao=='marcarRealizada'){
        $tarefa= new Tarefa();
        $tarefa->__set('id', $_GET['id']);
        $tarefa->__set('id_status',2); //estamos forçando esse feito indo para realizado

        $conexao= new Conexao();

        $servicoTarefa= new ServicoTarefa($conexao,$tarefa);
        $servicoTarefa->realizadas();
        
        if( isset($_GET['pag']) && $_GET['pag'] == 'index') {
			header('location: index.php');	
		} else {
			header('location: todas_tarefas.php');
		}        

    }else if($acao=='tarefaPendente'){

        $tarefa= new Tarefa();
       
        $tarefa->__set('id_status',1);

        $conexao= new Conexao();

       
        $servicoTarefa= new ServicoTarefa($conexao,$tarefa);
        $tarefas= $servicoTarefa->pendente();
        

    }

       

    

?>

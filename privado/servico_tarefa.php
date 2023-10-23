<?php

class ServicoTarefa {

    private $conexao;
    private $tarefa;
    
    public function __construct(Conexao $conexao,Tarefa $tarefa){  //aqui estamos tipando o tipo de dados(dizendo que queremos receber apenas valores que venham de conexao ou de tarefa.)

        $this->conexao=$conexao->conectar();
        $this->tarefa=$tarefa;
        
       
    }

    public function inserir(){
        $query= 'insert into tb_tarefas(tarefa) values (:tarefa)';   //iniciando sql injection
        $stmt=$this->conexao->prepare($query);
        $stmt->bindValue(':tarefa',$this->tarefa->__get('tarefa')); //aqui ele esta recebendo tarefa,porem , sem o seu valor,entao usamos get
        $stmt->execute();
    }
    public function recuperar(){
            //algumas colunas vindo de tb_tarefas e outras de tb_status
            
        $query= 'select 
                    t.id, s.status, t.tarefa 
                 from 
                    tb_tarefas as t
                 left join tb_status as s on (t.id_status = s.id)

                 ';
                
        $stmt=$this->conexao->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ); // aqui estamos enviando um retorno do array de objetos que contem as tabelas e enviando para a variavel $tarefas em controlador_tarefa
    }
    public function atualizar(){
        $query= "update tb_tarefas set tarefa = :tarefa where id = :id ";
        
        $stmt=$this->conexao->prepare($query);
        $stmt->bindValue(':id',$this->tarefa->__get('id'));
        $stmt->bindValue(':tarefa',$this->tarefa->__get('tarefa'));
        return $stmt->execute();

    }
    public function remover(){

         $query= "delete from tb_tarefas where id = :id ";
        
        $stmt=$this->conexao->prepare($query);
        $stmt->bindValue(':id',$this->tarefa->__get('id'));
        $stmt->execute();

    }
    public function realizadas(){

        $query= "update tb_tarefas set id_status = :id_status where id = :id ";
        
        $stmt=$this->conexao->prepare($query);
        $stmt->bindValue(':id_status',$this->tarefa->__get('id_status'));
        $stmt->bindValue(':id',$this->tarefa->__get('id'));
        return $stmt->execute(); 

    }
    public function pendente(){

        $query= 'select 
                    t.id, s.status, t.tarefa 
                 from 
                    tb_tarefas as t
                 left join tb_status as s on (t.id_status = s.id) where t.id_status = :id_status

                 ';
        
        $stmt=$this->conexao->prepare($query);
        $stmt->bindValue(':id_status',$this->tarefa->__get('id_status'));
        
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);

    }


}








?>
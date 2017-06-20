<?php

class App extends Controller {

    function App() {

        parent::Controller();
        $this->load->model('app_model', 'app');
    }

    function buscandoAgenda() {
        header('Access-Control-Allow-Origin: *');
        $retorno = $this->app->buscandoAgenda();
        
        die(json_encode($result));
    }
    
    function validaUsuario() {
        header('Access-Control-Allow-Origin: *');
        
        if (isset($_GET['usuario']) && isset($_GET['pw'])){
            $retorno = $this->app->validaUsuario();
            if(count($retorno) > 0){
                $result = array(
                    "status" => "sucesso",
                    "hashSenha" => md5($_GET['pw'])
                );
            }
            else{
                $result = array(
                    "status" => "erro",
                    "motivo" => "Neste link não foi encontrado nenhum usuario com os dados informados!"
                );
            }
        } 
        else{
            $result = array(
                "status" => "erro",
                "motivo" => "Nome de usuario ou senha em branco."
            );
        }
        
        die(json_encode($result));
    }

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */

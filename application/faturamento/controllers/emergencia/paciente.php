<?php
class Paciente extends Controller {

	function Paciente() {
            parent::Controller();
            $this->load->model('giah/paciente_model', 'paciente_m');
            $this->load->library('mensagem');
            $this->load->library('utilitario');
            $this->load->library('pagination');
            $this->load->library('validation');
	}

	function index() {
            $data= 'teste';
         $this->carregarView($data);
	}



//        function alteraSenha($operador_id) {
//            $data['lista'] = $this->operador_m->listarCada($operador_id);
//
//         $this->carregarView($data,'giah/operador-novasenha');
//	}
//
//        function gravarNovaSenha() {
//            $novasenha = $_POST['txtNovaSenha'];
//            $confirmacao = $_POST['txtConfirmacao'];
//
//            if($novasenha == $confirmacao  )
//            {
//                if($this->operador_m->gravarNovaSenha()){
//                    $data['mensagem'] = $this->mensagem->getMensagem('operador003');
//                }else{
//                    $data['mensagem'] = $this->mensagem->getMensagem('operador004');
//                }
//
//            }else
//            {
//                $data['mensagem'] = $this->mensagem->getMensagem('operador005');
//
//            }
//                        $data['lista'] = $this->operador_m->listar($filtro=null, $maximo=null, $inicio=null);
//            $maximo = 10;
//            $total = $this->operador_m->totalRegistros($filtro);
//
//            $config['base_url'] = base_url() . 'giah/operador/pesquisar/' . $filtro . '/';
//            $config['total_rows'] = $total;
//            $config['per_page'] = $maximo;
//            $config['uri_segment'] = 5;
//            $config['first_link'] = 'Primeiro';
//            $config['last_link'] = 'Último';
//            $config['next_link'] = 'Próximo';
//            $config['prev_link'] = 'Anterior';
//            $config['cur_tag_open'] = '<b>&nbsp;';
//            $config['cur_tag_close'] = '</b>';
//            $config['num_links'] = 1;
//
//            $this->pagination->initialize($config);
//            $data['paginacao'] = $this->pagination->create_links();
//            $data['total'] = $total;
//
//            $this->carregarView($data);
//        }
//
//        function pesquisar($filtro=-1, $inicio=0) {
//            if (isset ($_POST['filtro']))
//            { $filtro = $_POST['filtro']; }
//
//            $maximo = 10;
//            $total = $this->operador_m->totalRegistros($filtro);
//
//            $config['base_url'] = base_url() . 'giah/operador/pesquisar/' . $filtro . '/';
//            $config['total_rows'] = $total;
//            $config['per_page'] = $maximo;
//            $config['uri_segment'] = 5;
//            $config['first_link'] = 'Primeiro';
//            $config['last_link'] = 'Último';
//            $config['next_link'] = 'Próximo';
//            $config['prev_link'] = 'Anterior';
//            $config['cur_tag_open'] = '<b>&nbsp;';
//            $config['cur_tag_close'] = '</b>';
//            $config['num_links'] = 1;
//
//            $this->pagination->initialize($config);
//            $data['paginacao'] = $this->pagination->create_links();
//            $data['total'] = $total;
//            $data['lista'] = $this->operador_m->listar($filtro, $maximo, $inicio);
//            if ($filtro != -1) {
//                $data['filtro'] = $filtro;
//            } else {
//                $data['filtro'] = '';
//            };
//
//            $this->carregarView($data);
//        }
//
//        function gravar() {
//            if( $this->operador_m->gravar())
//            {$data['mensagem'] = $this->mensagem->getMensagem('operador006'); }
//            else
//            { $data['mensagem'] = $this->mensagem->getMensagem('operador007'); }
//             $data['lista'] = $this->operador_m->listar($filtro=null, $maximo=null, $inicio=null);
//                     $maximo = 10;
//            $total = $this->operador_m->totalRegistros($filtro);
//
//            $config['base_url'] = base_url() . 'giah/operador/pesquisar/' . $filtro . '/';
//            $config['total_rows'] = $total;
//            $config['per_page'] = $maximo;
//            $config['uri_segment'] = 5;
//            $config['first_link'] = 'Primeiro';
//            $config['last_link'] = 'Último';
//            $config['next_link'] = 'Próximo';
//            $config['prev_link'] = 'Anterior';
//            $config['cur_tag_open'] = '<b>&nbsp;';
//            $config['cur_tag_close'] = '</b>';
//            $config['num_links'] = 1;
//
//            $this->pagination->initialize($config);
//            $data['paginacao'] = $this->pagination->create_links();
//            $data['total'] = $total;
//            $this->carregarView($data);
//        }
//
//        function excluirOperador($operador_id) {
//            if ($this->operador_m->excluirOperador($operador_id))
//            {$data['mensagem'] = 'operador001';}
//            else
//            {$data['mensagem'] =  'operador002';}
//
//            $data['lista'] = $this->operador_m->listar($filtro=null, $maximo=null, $inicio=null);
//
//            redirect(base_url()."giah/operador/index/$data","refresh");
//        }

        private function carregarView($data=null, $view=null) {
            if (!isset ($data)) { $data['mensagem'] = ''; }

            if ($this->utilitario->autorizar(2, $this->session->userdata('modulo')) == true)
            {
                $this->load->view('header', $data);
                if ($view != null) {
                    $this->load->view($view, $data);
                } else {
                    $this->load->view('emergencia/paciente-form', $data);
                }
            } else {
                $data['mensagem'] = $this->mensagem->getMensagem('login005');
                $this->load->view('header', $data);
                $this->load->view('home');
            }
            $this->load->view('footer');
        }
}
?>

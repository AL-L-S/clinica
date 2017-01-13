<?php
class Importacaoopm extends Controller {

        function Importacaoopm() {
            parent::Controller();
            $this->load->model('giah/importacaoopm_model', 'importacaoopm_m');
            $this->load->library('mensagem');
            $this->load->library('utilitario');
            $this->load->library('pagination');
            $this->load->library('validation');
        }

        function index() {

        $this->load->view('giah/importacao-lista');

        }

        function compativel() {


        $this->load->view('giah/importacaocompativel-lista');

        }

        function importar(){
            $config['upload_path'] = "/home/cti6162/workspace/aph/upload/";
            $config['allowed_types'] = 'txt';
            $config['max_size'] = '2000';
            $config['overwrite'] = TRUE;
            $this->load->library('upload', $config);

            if (!$this->upload->do_upload()) {
                $error = array('error' => $this->upload->display_errors());
                } else {
                $error = null;
                $data = array('upload_data' => $this->upload->data());
                }
            // inicia a importacao
            if (!isset($error)) {
                // armazena o conteudo do arquivo em um array
                $fd = fopen("/home/cti6162/workspace/aph/upload/tb_procedimento.txt", "r"); //TODO: hm lembrar de alterar para recuperar o nome do arquivo

                while (!feof($fd)) {
                    $buffer = fgets($fd, 4096);

                    $lines[] = $buffer;

                }
                fclose($fd);
                // inserir o registro para cada linha
                foreach ($lines as $line) {

                    
                    if (trim($line) != "") {

                        $co_procedimento = substr($line, 0,10);
                        $no_procedimento = substr($line, 10,250);
                        $tp_complexidade = substr($line, 260,1);
                        $tp_sexo = substr($line, 261,1);
                        $qt_maxima_execucao = substr($line, 262,4);
                        $qt_dias_permanencia = substr($line, 266,4);
                        $qt_pontos = substr($line, 270,4);
                        $vl_idade_minima = substr($line, 274,4);
                        $vl_idade_maxima = substr($line, 278,4);
                        $vl_sh = substr($line, 282,10);
                        $vl_sa = substr($line, 292,10);
                        $vl_sp = substr($line, 302,10);
                        $co_financiamento = substr($line, 312,2);
                        $co_rubrica = substr($line, 314,6);
                        $dt_competencia = substr($line, 320,6);
                       $this->importacaoopm_m->gravarImportacao($co_procedimento, $no_procedimento, $tp_complexidade,
                               $tp_sexo,$qt_maxima_execucao,$qt_dias_permanencia,$qt_pontos,$vl_idade_minima,$vl_idade_maxima,
                               $vl_sh,$vl_sa,$vl_sp,$co_financiamento,$co_rubrica,$dt_competencia);
                    }
                }
                $mensagem = "importacaoopm001";
            } else {
                $mensagem = "importacaoopm002";
            }

            if ($mensagem != null) {
                $data['mensagem'] = $this->mensagem->getMensagem($mensagem);
            }

            if (isset($error)) {
                $data['erros'] = $error;
            }

        }

        function criadbf(){

            // database "definition"
            $def = array(
              array("co_pro", "C", 10 ),
              array("no_pro", "C", 250),
              array("tp_compl", "C", 1),
              array("tp_sexo", "C",1),
              array("qt_max_ex", "N", 4, 0),
              array("qt_d_perm", "N", 4, 0),
              array("qt_pnts",     "N", 4, 0),
              array("vl_id_min", "N", 4, 0),
              array("vl_id_max", "N", 4, 0),
              array("vl_sh", "N", 10, 0     ),
              array("vl_sa", "N", 10, 0),
              array("vl_sp", "N", 10, 0),
              array("co_fin", "C", 2),
              array("co_rub", "C", 6),
              array("dt_compet", "D")
            );

// creation
            if (!dbase_create('/home/cti6162/workspace/aph/upload/tb_procedimento.dbf', $def)) {
              echo "Error, can't create the database\n";
            }
                     
        }
        function inserirdados(){

            $data['lista'] = $this->importacaoopm_m->listar();
            $lista =  $data['lista'];


      
            // open in read-write mode
            $db = dbase_open('/home/cti6162/workspace/aph/upload/tb_procedimento.dbf', 2);

            if ($db) {
                foreach ($lista as $key => $value) {
              dbase_add_record($db, array(
                  $value -> co_procedimento,
                  $value -> no_procedimento,
                  $value -> tp_complexidade,
                  $value -> tp_sexo,
                  $value -> qt_maxima_execucao,
                  $value -> qt_dias_permanencia,
                  $value -> qt_pontos,
                  $value -> vl_idade_minima,
                  $value -> vl_idade_maxima,
                  $value -> vl_sh,
                  $value -> vl_sa,
                  $value -> vl_sp,
                  $value -> co_financiamento,
                  $value -> co_rubrica,
                  $value -> dt_competencia
                  ));
              dbase_close($db);

                }
            }

        }

        function importarCompativel(){
            $config['upload_path'] = "/home/cti6162/workspace/aph/upload/";
            $config['allowed_types'] = 'txt';
            $config['max_size'] = '2000';
            $config['overwrite'] = TRUE;
            $this->load->library('upload', $config);

            if (!$this->upload->do_upload()) {
                $error = array('error' => $this->upload->display_errors());
                } else {
                $error = null;
                $data = array('upload_data' => $this->upload->data());
                }
            // inicia a importacao
            if (!isset($error)) {
                // armazena o conteudo do arquivo em um array
                $fd = fopen("/home/cti6162/workspace/aph/upload/rl_procedimento_compativel.txt", "r"); //TODO: hm lembrar de alterar para recuperar o nome do arquivo


                while (!feof($fd)) {
                    $buffer = fgets($fd, 4096);

                    $lines[] = $buffer;

                }
                fclose($fd);
                // inserir o registro para cada linha
                foreach ($lines as $line) {


                    if (trim($line) != "") {

                        $co_procedimento_principal = substr($line, 0,10);
                        $co_registro_principal = substr($line, 10,2);
                        $co_procedimento_compativel = substr($line, 12,10);
                        $co_registro_compativel = substr($line, 22,2);
                        $tp_compatibilidade = substr($line, 24,1);
                        $qt_permitida = substr($line, 25,4);
                        $dt_competencia = substr($line, 29,6);

                       $this->importacaoopm_m->gravarImportacaoCompativel($co_procedimento_principal, $co_registro_principal, $co_procedimento_compativel,
                               $co_registro_compativel,$tp_compatibilidade,$qt_permitida,$dt_competencia);
                    }
                }
                $mensagem = "importacaoopm003";
            } else {
                $mensagem = "importacaoopm004";
            }

            if ($mensagem != null) {
                $data['mensagem'] = $this->mensagem->getMensagem($mensagem);
            }

            if (isset($error)) {
                $data['erros'] = $error;
            }

        }

        function criadbfcompativel(){

            // database "definition"
            $def = array(
              array("co_procedimento_principal", "C", 10 ),
              array("co_registro_principal", "C", 2),
              array("co_procedimento_compativel", "C", 10),
              array("co_registro_compativel", "C", 2),
              array("tp_compatibilidade", "C", 1),
              array("qt_permitida", "N", 4, 0),
              array("dt_competencia", "D")
            );

// creation
            if (!dbase_create('/home/cti6162/workspace/aph/upload/rl_procedimento_compativel.dbf', $def)) {
              echo "Error, can't create the database\n";
            }

        }
        function inserirdadoscompativel(){

            $data['lista'] = $this->importacaoopm_m->listarcompativel();
            $lista =  $data['lista'];



            // open in read-write mode
            $db = dbase_open('/home/cti6162/workspace/aph/upload/rl_procedimento_compativel.dbf', 2);

            if ($db) {
                foreach ($lista as $key => $value) {
              dbase_add_record($db, array(
                  $value -> co_procedimento_principal,
                  $value -> co_registro_principal,
                  $value -> co_procedimento_compativel,
                  $value -> co_registro_compativel,
                  $value -> tp_compatibilidade,
                  $value -> qt_permitida,
                  $value -> dt_competencia
      
                  ));
              dbase_close($db);

                }
            }

        }
}


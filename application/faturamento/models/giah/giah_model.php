<?php

    class Giah_model extends Model {

        function Giah_model() {
        parent::Model();
    }

    function listar($ano) {
        
        $this->db->select('competencia,
                                count(pontuacao_medica) as total_pontuacao');
        
            //$this->db->where("g.competencia like '". $ano . "%'");
            //$this->db->where('c.classificacao_id', 3);
            $this->db->from('tb_giah g');
            $this->db->join('tb_servidor_teto se', 'se.teto_id = g.servidor_id');
            $this->db->join('tb_servidor s', 's.servidor_id = se.servidor_id');
            $this->db->join('tb_classificacao c', 'c.classificacao_id = s.classificacao_id');
            $this->db->where('c.classificacao_id', 3);
            $this->db->orderby("g.competencia");
        
        $this->db->groupby('competencia');
        //$return = $this->db->get('tb_giah g');
        $query = $this->db->get();
        $return = $query->result();
        
        return $return;

    }

    function listargiah($competencia) {
        $this->db->select('g.competencia,
                               g.servidor_id,
                               g.pontuacao_medica,
                               g.valor,
                               g.situacao_id');
        $this->db->from('tb_giah g');
        $this->db->join('tb_servidor s', 's.servidor_id = g.servidor_id');
        $this->db->where("g.competencia", $competencia);
        $query = $this->db->get();
        $return = $query->result();
        return $return;
    }

    function listarservidor($classificacao_id) {
        $this->db->select('g.competencia,
                               g.servidor_id,
                               st.salario_base,
                               s.classificacao_id,
                               g.pontuacao_medica,
                               g.valor,
                               g.situacao_id');
        $this->db->from('tb_giah g');
        $this->db->join('tb_servidor s', 's.servidor_id = g.servidor_id');
        $this->db->join('tb_servidor_teto st', 'st.servidor_id = g.servidor_id');
        $this->db->where("s.classificacao_id", $classificacao_id);
        $query = $this->db->get();
        $return = $query->result();
        return $return;
    }

    function listarparametro($competencia) {
        $this->db->select('competencia,
                                valor_sih,
                                valor_aih,
                                valor_cib');
        $this->db->from('tb_parametrogiah');
        $this->db->where("competencia", $competencia);
        $return = $this->db->get();
        return $return->result();
    }

    function gravarPontuacao($competencia, $teto_id, $pontos) {
        $this->db->set('competencia', $competencia);
        $this->db->set('servidor_id', $teto_id);
        $this->db->set('pontuacao_medica', $pontos);
        $this->db->set('valor', 0);
        $this->db->set('situacao_id', 16);
        $this->db->insert('tb_giah');
        $erro = $this->db->_error_message();
        if (trim($erro) != ""){ // erro de banco
            return false;
        }else{
            return true;
        }
    }

    function excluir($competencia) {

         try {
                        $this->db->where('competencia', $competencia);
                        $this->db->where('pontuacao_medica <>', 0);
                        $this->db->delete('tb_giah');
                        $erro = $this->db->_error_message();
                        if (trim($erro) != "") // erro de banco
                        { return false; }
                        else
                        { return true; }
                    } catch (Exception $exc) {
                        return false;
                    }
    }

    function excluirGIAHErrada($competencia) {
        $this->db->where('competencia', $competencia);
        $this->db->where('situacao_id <> ', 16);
        $this->db->delete('tb_giah');
        return true;
    }

    /* Inicio dos métodos para execucao das regras de negocio */
    function calcularparametro($parametro) {
        $this->db->select('(valor_sih+valor_aih+valor_cib) as soma ');
        $this->db->from('tb_parametrogiah');
        $this->db->where("competencia", $parametro);
        $return = $this->db->get()->result();
        return $return[0]->soma;
    }

    function calcularSomaSuplementar($competencia) {
        $this->db->select('SUM(su.valor) AS soma');
        $this->db->from('tb_suplementar su');
        $this->db->join('tb_servidor se', 'se.servidor_id = su.servidor_id');
        $this->db->where('su.competencia', $competencia);
        $this->db->where("se.classificacao_id in (1,4,5,6)");  // Demais servidores
        $return = $this->db->get()->result();
        if (count($return) == 1 && isset ($return[0]->soma))
        { return $return[0]->soma; }
        else
        { return 0; }
    }

    function calcularSomaSuplementarMedicosECH($competencia) {
        $this->db->select('SUM(su.valor) AS soma');
        $this->db->from('tb_suplementar su');
        $this->db->join('tb_servidor se', 'se.servidor_id = su.servidor_id');
        $this->db->where('su.competencia', $competencia);
        $this->db->where("se.classificacao_id in (2,3)");  // Demais servidores
        $return = $this->db->get()->result();
        if (count($return) == 1 && isset ($return[0]->soma))
        { return $return[0]->soma; }
        else
        { return 0; }
    }

    function SomaProdutividadeMedicosECH($competencia) {
        $this->db->select('SUM(g.valor) AS soma');
        $this->db->from('tb_giah g');
        $this->db->join('tb_servidor_teto se', 'se.teto_id = g.servidor_id');
        $this->db->join('tb_servidor s', 's.servidor_id = se.servidor_id');
        $this->db->where('g.competencia', $competencia);
//        if ($classificacao == 'M')
//        { $this->db->where('se.classificacao_id in (2,3)'); } // Médio e chefia médica
//        else
        $this->db->where("s.classificacao_id in (2,3)");  // Médio e chefia médica
        $return = $this->db->get()->result();
        if (count($return) == 1 && isset ($return[0]->soma))
        { return $return[0]->soma; }
        else
        { return 0; }
    }

    function calcularSomaPontuacaoMedica($competencia) {
        $this->db->select('SUM(pontuacao_medica) as soma');
        $this->db->from('tb_giah');
        $this->db->where('situacao_id', 16);
        $this->db->where("competencia", $competencia);
        $return = $this->db->get()->result();
        if (count($return) == 1 && isset ($return[0]->soma) )
        { return $return[0]->soma; }
        else
        { return 0; }
    }

    function calcularSomaSalariosDemaisCategorias() {
        
                    $sql = "SELECT SUM(result) from (
                            select CASE WHEN (desconto_percentual = true) 
						      THEN (se.salario_base*(1-(d.valor/100)))
						      WHEN (desconto_percentual != true) 
						      THEN (se.salario_base-d.valor)
						      else (se.salario_base) 
						      END AS result
                from ijf.tb_servidor_teto se
                left join ijf.tb_desconto d on d.teto_id = se.teto_id
                join ijf.tb_servidor s on s.servidor_id = se.servidor_id
                where (s.classificacao_id = 1 or s.classificacao_id = 4
                or s.classificacao_id = 5 or s.classificacao_id = 6)
                and se.situacao = 't') AS result";
        $return = $this->db->query($sql)->result();
        if (count($return) == 1 && isset ($return[0]->sum) )
        { return $return[0]->sum; }
        else
        { return 0; }
    }

    function calcularSomaProdutividadeChefiaMedica($competencia) {
        $this->db->select('SUM(valor) as soma');
        $this->db->from('tb_giah');
        $this->db->where("competencia", $competencia);
        $this->db->where("servidor_id in (select servidor_id from tb_servidor where classificacao_id = 2 and situacao_id = 1)");
        $return = $this->db->get()->result();

        if (count($return) == 1 && isset ($return[0]->soma))
        { return $return[0]->soma; }
        else
        { return 0; }
    }

    function gerarProdutividadeChefiaMedica($competencia) {
        
        $sql = "insert into ijf.tb_giah
                (competencia, servidor_id, pontuacao_medica, valor, observacao, situacao_id)
                select '$competencia', se.teto_id, 1, se.salario_base,
                'método: gerarProdutividadeChefiaMedica', 17
                from ijf.tb_servidor_teto se
                join ijf.tb_servidor s on s.servidor_id = se.servidor_id
                where s.classificacao_id = 2
                and se.situacao = 't'";
        $this->db->query($sql);
        
    }

    function gerarGIAHunificada($competencia) {

        $sql = "insert into ijf.tb_giah_unificado (servidor_id, competencia, valor, pontuacao_medica, observacao, situacao_id)
                SELECT  distinct( st.servidor_id), '$competencia', SUM(valor), SUM(pontuacao_medica), 'Unificado', 17 FROM ijf.tb_servidor_teto st
                join ijf.tb_giah g on g.servidor_id = st.teto_id
                GROUP BY st.servidor_id";
        $this->db->query($sql);
    }
    
    function selecionarsuplementar($competencia) {
        $this->db->select();
        $this->db->from('tb_suplementar su');
        $this->db->where('su.competencia', $competencia);
        $return = $this->db->get()->result();
        return $return;
    }

    function aplicarsuplementar($competencia, $valor, $servidor_id) {

        $sql = "UPDATE ijf.tb_giah
                SET valor = valor + '$valor'
                 WHERE servidor_id= '$servidor_id'
                 and competencia = '$competencia'";
        $this->db->query($sql);

    }

    function gerarProdutividadeDemaisCategorias($competencia, $ist) {
        $sql = "insert into ijf.tb_giah
                (competencia, servidor_id, pontuacao_medica, valor, observacao, situacao_id)
                select '$competencia', se.teto_id, 0, 
                                                      CASE WHEN (desconto_percentual = true)
						      THEN (((se.salario_base*(1-(d.valor/100)))* $ist))
						      WHEN (desconto_percentual != true)
						      THEN (((se.salario_base-d.valor)* $ist))
						      else (((se.salario_base)* $ist))
						      END AS result
                                                      
                , 'método: gerarProdutividadeDemaisCategorias', 17
                from ijf.tb_servidor_teto se
                left join ijf.tb_desconto d on d.teto_id = se.teto_id
                join ijf.tb_servidor s on s.servidor_id = se.servidor_id
                where (s.classificacao_id = 1 or s.classificacao_id = 4
                or s.classificacao_id = 5 or s.classificacao_id = 6)
                AND se.situacao = 't'";
        $this->db->query($sql);
        
    }

    function gerarProdutividadeMedica($competencia) {
        $sql = "UPDATE ijf.tb_giah
                SET valor = (pontuacao_medica)
                    , situacao_id = 17
                    , observacao = 'médoto: gerarProdutividadeMedica'
                WHERE situacao_id = 16
                AND competencia = '$competencia'";
        $this->db->query($sql);
    }

    function CorrigirProdutividadeMedicosECH($competencia, $ipm) {
        $sql = "UPDATE ijf.tb_giah
                SET valor = valor * $ipm
                WHERE competencia = '$competencia' AND pontuacao_medica != 0";
        $this->db->query($sql);
        
    }
    
    }
?>
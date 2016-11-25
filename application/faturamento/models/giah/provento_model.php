<?php

/**
 * Esta classe é a responsável pela conexão com o banco de dados.
 * @author Equipe de desenvolvimento APH
 * @version 1.0
 * @copyright Prefeitura de Fortaleza
 * @access public
 * @package Model
 * @subpackage GIAH
 */
class Provento_model extends Model
{

    /**
     * Função construtora para setar os valores de conexão com o banco.
     * @author Equipe de desenvolvimento APH
     * @access public
     * @return void
     * @param integer $servidor_id com a informação do KEY do servidor.
     */
    function Provento_model()
    {
        parent::Model();
    }

    /**
     * Função para informar todos os registros da tabela TB_PROVENTO.
     * @author Equipe de desenvolvimento APH
     * @access public
     * @return Array
     * @param string $ano com a informação do ano corrente.
     */
    function listarProventosDoAno($ano)
    {
        $this->db->select('competencia, SUM(valor) AS total');
        //$this->db->where('competencia like', $ano . "%");
        $this->db->groupby('competencia');
        $this->db->orderby('competencia');
        $rs = $this->db->get('tb_provento')->result();
        return $rs;
    }

    function listarProventosIr($competencia)
    {
        $sql = "SELECT competencia, ir, s.nome, s.matricula, s.cpf
                  FROM ijf.tb_provento p
                join ijf.tb_servidor s on s.servidor_id = p.servidor_id
                where p.competencia = '$competencia'
                and p.ir != 0 ";
        return $this->db->query($sql)->result();
    }

    function listarProventosInss($competencia)
    {
        $sql = "SELECT competencia, inss, s.nome, s.matricula, s.cpf
                  FROM ijf.tb_provento p
                join ijf.tb_servidor s on s.servidor_id = p.servidor_id
                where p.competencia = '$competencia'
                and p.inss != 0 ";
        return $this->db->query($sql)->result();
    }

    /**
     * Função para informar todas as GIAH geradas da tabela TB_GIAH.
     * @author Equipe de desenvolvimento APH
     * @access public
     * @return Array
     * @param string $competencia com a informação do ano/mês.
     */
    function totalGIAHGerada($competencia)
    {
        $sql = "SELECT * FROM ijf.tb_giah where competencia = '$competencia' and situacao_id = 17";
        return $this->db->query($sql)->result();
    }

    /**
     * Função para informar todos os proventos gerados da tabela TB_PROVENTO.
     * @author Equipe de desenvolvimento APH
     * @access public
     * @return Array
     * @param string $competencia com a informação do ano/mês.
     */
    function totalProventoGerado($competencia)
    {
        $sql = "SELECT * FROM ijf.tb_provento where competencia = '$competencia' ";
        return $this->db->query($sql)->result();
    }

    /**
     * Função para gerar proventos na tabela TB_PROVENTO.
     * @author Equipe de desenvolvimento APH
     * @access public
     * @return Array
     * @param string $competencia com a informação do ano/mês.
     */
    function gerarProvento($competencia)
    {
        $sql = "insert into ijf.tb_provento
                (competencia, servidor_id, valor, inss, ir, situacao_id, pensao)
                select
                       g.competencia,
                       g.servidor_id,
                       case
                          when i.valor is null then g.valor
                          else (i.valor + g.valor)
                       end as valor,
                       case
                          when g.valor > 0 and i.valor is null and s.desconto_inss = true then ijf.get_inss(g.valor)
                          when g.valor > 0 and s.desconto_inss = true then ijf.get_inss(g.valor + i.valor)
                          when i.valor > 0 and s.desconto_inss = true then ijf.get_inss(i.valor)
                          else 0.00
                       end as inss,
                       case
                          when g.valor > 0 and i.valor is null and s.desconto_inss = true then ijf.get_ir((g.valor-ijf.get_inss(g.valor)))
                          when g.valor > 0 and s.desconto_inss = true then ijf.get_ir(((g.valor + i.valor)-ijf.get_inss(g.valor + i.valor)))
                          when g.valor > 0 and i.valor is null then ijf.get_ir((g.valor))
                          when g.valor > 0 then ijf.get_ir((g.valor + i.valor))
                          when i.valor > 0 and s.desconto_inss = true then ijf.get_ir((i.valor-ijf.get_inss(i.valor)))
                          else 0.00
                       end as ir,
                       1 as ativo,
                       case
                            when i.valor is not null and g.valor is not null and ijf.get_percentual(s.servidor_id) is not null then
                            (ijf.get_percentual(s.servidor_id) * (g.valor + i.valor))
                            when i.valor is null and ijf.get_percentual(s.servidor_id) is not null then
                            (ijf.get_percentual(s.servidor_id) * (g.valor))
                            when g.valor is null and ijf.get_percentual(s.servidor_id) is not null then
                            (ijf.get_percentual(s.servidor_id) * (i.valor))
                          else 0.00
                       end as pensao
                       from ijf.tb_giah_unificado g
                       left join ijf.tb_servidor s on s.servidor_id = g.servidor_id
                       left join ijf.tb_incentivo i on i.servidor_id = s.servidor_id
                       and i.competencia = '$competencia'
                       and i.autoriza_super = true
                       where g.competencia = '$competencia'
                       group by
                       g.competencia,
                       g.servidor_id,
                       s.servidor_id,
                       g.valor,
                       i.valor,
                       s.desconto_inss";
        $this->db->query($sql);
    }

    function gerarProventoincentivomedico($competencia)
    {

        $sql = " insert into ijf.tb_provento
                (competencia, servidor_id, valor, inss, ir, situacao_id, pensao)
                    SELECT
			$competencia,
			I.SERVIDOR_ID,
			I.VALOR,
                       case
                          when s.desconto_inss = true then ijf.get_inss(i.valor)
                          else 0.00
                       end as inss,
                       case
                          when i.valor > 0 and s.desconto_inss = true then ijf.get_ir((i.valor-ijf.get_inss(i.valor)))
                          else 0.00
                       end as ir,
                       1 as ativo,
                       case
                            when ijf.get_percentual(s.servidor_id) is not null then
                            (ijf.get_percentual(s.servidor_id) * (i.valor))
                          else 0.00
                       end as pensao
                    FROM IJF.TB_INCENTIVO I
                    JOIN IJF.TB_SERVIDOR S ON S.SERVIDOR_ID = I.SERVIDOR_ID
                    LEFT JOIN IJF.TB_PROVENTO P ON I.SERVIDOR_ID = P.SERVIDOR_ID
                    WHERE S.CLASSIFICACAO_ID = 3
                    AND P.COMPETENCIA IS NULL
                    AND I.AUTORIZA_SUPER = 'true'
                    AND I.COMPETENCIA = '$competencia'";
        $this->db->query($sql);
    }

    /**
     * Função para gerar arquivo SAM tabela TB_PROVENTO.
     * @author Equipe de desenvolvimento APH
     * @access public
     * @return Array
     * @param string $competencia com a informação do ano/mês.
     */
    function gerarArquivoSAM($competencia)
    {

        $sql = "SELECT
                    se.matricula_sam AS matricula,
                    g.competencia,
                    g.competencia AS data_base,
                    g.valor AS valor_verba
                    FROM ijf.tb_giah g
                    JOIN ijf.tb_servidor_teto se ON se.teto_id = g.servidor_id
                    WHERE g.competencia = '$competencia'";
        return $this->db->query($sql)->result();
    }

    /**
     * Função para gerar arquivo BB da tabela TB_PROVENTO.
     * @author Equipe de desenvolvimento APH
     * @access public
     * @return Array
     * @param string $competencia com a informação do ano/mês.
     */
    function gerarArquivoBBServidor($competencia)
    {

        $sql = "SELECT
                    st.agencia AS agencia,
                    st.agencia_dv AS agencia_dv,
                    st.conta AS conta,
                    st.conta_dv AS conta_dv,
                    se.nome AS nome,
                    se.cpf,
                    (pr.valor - (pr.inss + pr.ir + pr.pensao)) AS valor
                    FROM ijf.tb_provento pr
                    JOIN ijf.tb_servidor_teto st ON st.servidor_id = pr.servidor_id
                    JOIN ijf.tb_servidor se ON se.servidor_id = st.servidor_id
                    WHERE pr.competencia = '$competencia'";

        return $this->db->query($sql)->result();
    }

    function totalProvento($competencia)
    {

        $sql = "SELECT
                    count(servidor_id)
                    FROM ijf.tb_provento pr
                    WHERE pr.competencia = '$competencia'";

        return $this->db->query($sql)->result();
    }

    /**
     * Função para gerar arquivo BB com os pensionistas da tabela TB_PROVENTO.
     * @author Equipe de desenvolvimento APH
     * @access public
     * @return Array
     * @param string $competencia com a informação do ano/mês.
     */
    function gerarArquivoBBPensionista($competencia)
    {

        $this->db->select('pe.agencia AS agencia,
                    pe.agencia_dv AS agencia_dv,
                    pe.conta AS conta,
                    pe.conta_dv AS conta_dv,
                    pe.nome AS nome,
                    pe.cpf,
                    (pr.valor * pe.percentual) AS valor');
        $this->db->from('tb_provento pr');
        $this->db->where('pr.competencia', $competencia);
        $this->db->join('tb_servidor_teto st', 'st.teto_id = pr.servidor_id');
        $this->db->join('tb_pensionista pe', 'pe.servidor_id = st.servidor_id');
        $this->db->where('pe.situacao_id', 3);
        $return = $this->db->get();
        return $return->result();
    }

}

?>
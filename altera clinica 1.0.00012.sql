--28/11/2017
ALTER TABLE ponto.tb_empresa_permissoes ADD COLUMN credito boolean DEFAULT true;
--29/11/2017
ALTER TABLE ponto.tb_empresa_permissoes ADD COLUMN valor_recibo_guia boolean DEFAULT false;

-- 01/12/2017

ALTER TABLE ponto.tb_paciente_credito ADD COLUMN parcelas1 integer DEFAULT 1;
ALTER TABLE ponto.tb_paciente_credito ADD COLUMN parcelas2 integer DEFAULT 1;
ALTER TABLE ponto.tb_paciente_credito ADD COLUMN parcelas3 integer DEFAULT 1;
ALTER TABLE ponto.tb_paciente_credito ADD COLUMN parcelas4 integer DEFAULT 1;

ALTER TABLE ponto.tb_paciente_credito ADD COLUMN desconto_ajuste1 numeric(10,2);
ALTER TABLE ponto.tb_paciente_credito ADD COLUMN desconto_ajuste2 numeric(10,2);
ALTER TABLE ponto.tb_paciente_credito ADD COLUMN desconto_ajuste3 numeric(10,2);
ALTER TABLE ponto.tb_paciente_credito ADD COLUMN desconto_ajuste4 numeric(10,2);

ALTER TABLE ponto.tb_paciente_credito ADD COLUMN faturado boolean DEFAULT false;


-- 04/12/2017

CREATE TABLE ponto.tb_empresa_impressao_orcamento
(
  empresa_impressao_orcamento_id serial NOT NULL,
  texto text,
  nome text,
  cabecalho boolean DEFAULT false,
  rodape boolean DEFAULT false,
  ativo boolean DEFAULT true,
  empresa_id integer,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  CONSTRAINT tb_empresa_impressao_orcamento_pkey PRIMARY KEY (empresa_impressao_orcamento_id)
);


ALTER TABLE ponto.tb_empresa_permissoes ADD COLUMN orcamento_config boolean DEFAULT false;

-- 05/12/2017

ALTER TABLE ponto.tb_ambulatorio_fila_impressao ADD COLUMN paciente character varying(200);
ALTER TABLE ponto.tb_ambulatorio_fila_impressao ADD COLUMN paciente_id integer;

-- 06/12/2017

ALTER TABLE ponto.tb_ambulatorio_orcamento_item ADD COLUMN observacao text;

ALTER TABLE ponto.tb_empresa ADD COLUMN impressao_orcamento integer;

--07/12/2017
ALTER TABLE ponto.tb_agenda_exames ADD COLUMN retorno boolean DEFAULT false;
--09/12/2017
ALTER TABLE ponto.tb_empresa_permissoes ADD COLUMN odontologia_valor_alterar boolean DEFAULT true;
ALTER TABLE ponto.tb_empresa_permissoes ADD COLUMN selecionar_retorno boolean DEFAULT true;

--11/12/2017
ALTER TABLE ponto.tb_empresa_permissoes ADD COLUMN administrador_cancelar boolean DEFAULT true;

CREATE OR REPLACE FUNCTION insereValor()
RETURNS text AS $$
DECLARE
    resultado integer;
BEGIN
    resultado := ( SELECT COUNT(*) FROM ponto.tb_versao WHERE sistema = '1.0.000013');
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_versao(sistema, banco_de_dados)
        VALUES ('1.0.000013', '1.0.000013');
    END IF;
    RETURN 'SUCESSO';
END;
$$ LANGUAGE plpgsql;

SELECT insereValor();
-- 01/10/2018

CREATE TABLE ponto.tb_estoque_fracionamento
(
  estoque_fracionamento_id serial NOT NULL,
  produto_id integer,
  quantidade integer,
  produto_entrada integer,
  quantidade_entrada integer,
  fornecedor_id integer,
  armazem_id integer,
  ativo boolean DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,

  CONSTRAINT tb_estoque_fracionamento_pkey PRIMARY KEY (estoque_fracionamento_id)
);

ALTER TABLE ponto.tb_estoque_entrada ADD COLUMN fracionamento_id integer;

-- 02/10/2018
ALTER TABLE ponto.tb_agenda_exames ADD COLUMN producao_paga boolean NOT NULL DEFAULT false;
ALTER TABLE ponto.tb_agenda_exames ADD COLUMN operador_producao integer;
ALTER TABLE ponto.tb_agenda_exames ADD COLUMN data_producao timestamp without time zone;



CREATE OR REPLACE FUNCTION insereValor()
RETURNS text AS $$
DECLARE
    resultado integer;
BEGIN
    resultado := ( SELECT COUNT(*) FROM ponto.tb_versao_alteracao WHERE chamado = '2871');
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_versao_alteracao(versao, alteracao, chamado, tipo)
        VALUES ('1.0.000030',
            'Ao fechar a produção do médico em Produção Médica o sistema deixa marcado no recibo que foi pago.',
            '2871',
            'Melhoria'
            );

    END IF;
    RETURN 'SUCESSO';
END;
$$ LANGUAGE plpgsql;
SELECT insereValor();


CREATE OR REPLACE FUNCTION insereValor()
RETURNS text AS $$
DECLARE
    resultado integer;
BEGIN
    resultado := ( SELECT COUNT(*) FROM ponto.tb_versao_alteracao WHERE chamado = '3007');
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_versao_alteracao(versao, alteracao, chamado, tipo)
        VALUES ('1.0.000030',
            'Agora Em Estoque->Rotinas->Manter Entrada é possível Fracionar uma entrada em outra unidade. Ex: Entrada de 30 caixas de comprimidos podem ser fracionadas para 300 comprimidos. Obs: Não é possível fracionar uma caixa para uma caixa',
            '3007',
            'Melhoria'
            );

    END IF;
    RETURN 'SUCESSO';
END;
$$ LANGUAGE plpgsql;
SELECT insereValor();

ALTER TABLE ponto.tb_convenio ADD COLUMN padrao_particular boolean DEFAULT false;

ALTER TABLE ponto.tb_operador ALTER COLUMN conselho TYPE character varying(20);

ALTER TABLE ponto.tb_cadastro_aso ADD COLUMN coordenador_id integer;
ALTER TABLE ponto.tb_cadastro_aso ADD COLUMN guia_id integer;

-- 03/10/2018

ALTER TABLE ponto.tb_convenio ADD COLUMN coordenador_id integer;

CREATE TABLE ponto.tb_empresa_lembretes_aniversario
(
  empresa_lembretes_aniversario_id serial NOT NULL,
  texto character varying(10000),
  perfil_destino integer,
  operador_destino integer,
  empresa_id integer,
  ativo boolean DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  aniversario date,

  CONSTRAINT tb_empresa_lembretes_aniversario_pkey PRIMARY KEY (empresa_lembretes_aniversario_id)
);

CREATE TABLE ponto.tb_empresa_lembretesaniv_visualizacao
(
  empresa_lembretesaniv_visualizacao_id serial NOT NULL,
  empresa_id integer,
  empresa_lembretes_aniversario_id integer,
  operador_visualizacao integer,
  data_visualizacao timestamp without time zone,
  CONSTRAINT tb_empresa_lembretesaniv_visualizacao_pkey PRIMARY KEY (empresa_lembretesaniv_visualizacao_id)
);

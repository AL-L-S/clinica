--09/01/2018


CREATE OR REPLACE FUNCTION insereValor()
RETURNS text AS $$
DECLARE
    resultado integer;
BEGIN
    resultado := ( SELECT COUNT(*) FROM ponto.tb_perfil WHERE nome = 'GERENTE DE RECEPÇÃO FINANCEIRO');
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_perfil(perfil_id, nome)
        VALUES (18, 'GERENTE DE RECEPÇÃO FINANCEIRO');
    END IF;
    RETURN 'SUCESSO';
END;
$$ LANGUAGE plpgsql;

SELECT insereValor();


CREATE TABLE ponto.tb_empresa_impressao_encaminhamento
(
  empresa_impressao_encaminhamento_id serial,
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
  CONSTRAINT tb_empresa_impressao_encaminhamento_pkey PRIMARY KEY (empresa_impressao_encaminhamento_id)
);


ALTER TABLE ponto.tb_empresa_permissoes ADD COLUMN encaminhamento_citycor boolean DEFAULT false;

--10/01/2018
CREATE TABLE ponto.tb_procedimento_percentual_laboratorio
(
  procedimento_percentual_laboratorio_id serial,
  procedimento_tuss_id integer,
  laboratorio integer,
  valor numeric(10,2),
  ativo boolean DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  CONSTRAINT tb_procedimento_percentual_laboratorio_pkey PRIMARY KEY (procedimento_percentual_laboratorio_id)
);


CREATE TABLE ponto.tb_procedimento_percentual_laboratorio_convenio
(
  procedimento_percentual_laboratorio_convenio_id serial,
  procedimento_percentual_laboratorio_id integer,
  laboratorio integer,
  valor numeric(10,2),
  percentual boolean DEFAULT true,
  ativo boolean DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  dia_recebimento integer,
  tempo_recebimento integer,
  revisor boolean DEFAULT false,
  CONSTRAINT tb_procedimento_percentual_laboratorio_convenio_pkey PRIMARY KEY (procedimento_percentual_laboratorio_convenio_id)
);


CREATE TABLE ponto.tb_procedimento_percentual_laboratorio_convenio_antigo
(
  procedimento_percentual_laboratorio_convenio_antigo_id serial,
  procedimento_percentual_laboratorio_convenio_id integer,
  procedimento_percentual_laboratorio_id integer,
  laboratorio integer,
  valor numeric(10,2),
  percentual boolean DEFAULT true,
  ativo boolean DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  dia_recebimento integer,
  tempo_recebimento integer,
  CONSTRAINT tb_procedimento_percentual_laboratorio_convenio_antigo_pkey PRIMARY KEY (procedimento_percentual_laboratorio_convenio_antigo_id)
);



ALTER TABLE ponto.tb_procedimento_tuss ADD COLUMN valor_laboratorio numeric(10,2);
ALTER TABLE ponto.tb_procedimento_tuss ADD COLUMN percentual_laboratorio boolean DEFAULT false;

ALTER TABLE ponto.tb_empresa_impressao_laudo ADD COLUMN adicional_cabecalho text;
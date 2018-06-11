-- Dia 06/02/2018
ALTER TABLE ponto.tb_estoque_armazem ADD COLUMN visivel_solicitacao boolean DEFAULT true;

-- Dia 07/02/2018
ALTER TABLE ponto.tb_agenda_exames ADD COLUMN confirmacao_recebimento_convenio boolean DEFAULT false;

-- Dia 07/02/2018
ALTER TABLE ponto.tb_paciente_indicacao ADD COLUMN credor_devedor_id integer;
ALTER TABLE ponto.tb_paciente_indicacao ADD COLUMN conta_id integer;
ALTER TABLE ponto.tb_paciente_indicacao ADD COLUMN classe character varying(60);
ALTER TABLE ponto.tb_paciente_indicacao ADD COLUMN tipo_id character varying(60);

-- Dia 10/02/2018
ALTER TABLE ponto.tb_empresa_permissoes ADD COLUMN associa_credito_procedimento boolean DEFAULT true;

CREATE TABLE ponto.tb_fornecedor_material
(
  fornecedor_material_id serial NOT NULL,
  razao_social character varying(200),
  nome character varying(200),
  cnpj character varying(20),
  cep character varying(9),
  logradouro character varying(200),
  numero character varying(20),
  complemento character varying(100),
  bairro character varying(100),
  municipio_id integer,
  celular character varying(15),
  telefone character varying(15),
  ativo boolean DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  tipo_logradouro_id integer,
  caixa boolean DEFAULT false,
  cnpjxml character varying(20),
  razao_socialxml character varying(200),
  cpfxml character varying(11),
  registroans character varying(11),
  dinheiro boolean DEFAULT false,
  producaomedicadinheiro boolean DEFAULT false,
  cnes character varying(20),
  tipo_xml_id integer,
  valor_taxa numeric(10,2),
  CONSTRAINT tb_fornecedor_material_pkey PRIMARY KEY (fornecedor_material_id)
);


ALTER TABLE ponto.tb_solicitacao_cirurgia ADD COLUMN fornecedor_id integer;

CREATE TABLE ponto.tb_solicitacao_cirurgia_material
(
  solicitacao_cirurgia_material_id serial,
  solicitacao_cirurgia_id integer,
  procedimento_tuss_id integer,
  ativo boolean NOT NULL DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  horario_especial boolean DEFAULT false,
  valor numeric(10,2),
  quantidade integer,
  desconto numeric(10,2),
  agenda_exames_id integer,
  equipe_particular boolean DEFAULT false,
  via character varying(100),
  CONSTRAINT tb_solicitacao_cirurgia_material_pkey PRIMARY KEY (solicitacao_cirurgia_material_id)
);


-- Dia 15/02/2018
ALTER TABLE ponto.tb_empresa_permissoes ADD COLUMN campos_obrigatorios_pac_cpf boolean DEFAULT false;
ALTER TABLE ponto.tb_empresa_permissoes ADD COLUMN campos_obrigatorios_pac_sexo boolean DEFAULT true;
ALTER TABLE ponto.tb_empresa_permissoes ADD COLUMN campos_obrigatorios_pac_nascimento boolean DEFAULT true;
ALTER TABLE ponto.tb_empresa_permissoes ADD COLUMN campos_obrigatorios_pac_telefone boolean DEFAULT true;
ALTER TABLE ponto.tb_empresa_permissoes ADD COLUMN campos_obrigatorios_pac_municipio boolean DEFAULT false;
ALTER TABLE ponto.tb_convenio ADD COLUMN dia_aquisicao integer;

-- 15/02/2018

ALTER TABLE ponto.tb_agenda_exame_equipe ADD COLUMN parcelas1 integer DEFAULT 1;
ALTER TABLE ponto.tb_agenda_exame_equipe ADD COLUMN parcelas2 integer DEFAULT 1;
ALTER TABLE ponto.tb_agenda_exame_equipe ADD COLUMN parcelas3 integer DEFAULT 1;
ALTER TABLE ponto.tb_agenda_exame_equipe ADD COLUMN parcelas4 integer DEFAULT 1;

ALTER TABLE ponto.tb_agenda_exame_equipe ADD COLUMN desconto numeric(10,2);
ALTER TABLE ponto.tb_agenda_exame_equipe ADD COLUMN desconto_ajuste1 numeric(10,2);
ALTER TABLE ponto.tb_agenda_exame_equipe ADD COLUMN desconto_ajuste2 numeric(10,2);
ALTER TABLE ponto.tb_agenda_exame_equipe ADD COLUMN desconto_ajuste3 numeric(10,2);
ALTER TABLE ponto.tb_agenda_exame_equipe ADD COLUMN desconto_ajuste4 numeric(10,2);

ALTER TABLE ponto.tb_agenda_exame_equipe ADD COLUMN faturado boolean DEFAULT false;


ALTER TABLE ponto.tb_agenda_exame_equipe ADD COLUMN forma_pagamento1 integer;
ALTER TABLE ponto.tb_agenda_exame_equipe ADD COLUMN valor1 numeric(10,2) DEFAULT 0;

ALTER TABLE ponto.tb_agenda_exame_equipe ADD COLUMN forma_pagamento2 integer;
ALTER TABLE ponto.tb_agenda_exame_equipe ADD COLUMN valor2 numeric(10,2) DEFAULT 0;

ALTER TABLE ponto.tb_agenda_exame_equipe ADD COLUMN forma_pagamento3 integer;
ALTER TABLE ponto.tb_agenda_exame_equipe ADD COLUMN valor3 numeric(10,2) DEFAULT 0;

ALTER TABLE ponto.tb_agenda_exame_equipe ADD COLUMN forma_pagamento4 integer;
ALTER TABLE ponto.tb_agenda_exame_equipe ADD COLUMN valor4 numeric(10,2) DEFAULT 0;


ALTER TABLE ponto.tb_agenda_exame_equipe ADD COLUMN data_faturamento timestamp without time zone;
ALTER TABLE ponto.tb_agenda_exame_equipe ADD COLUMN operador_faturamento integer;

ALTER TABLE ponto.tb_ambulatorio_desconto ADD COLUMN agenda_exame_equipe_id integer;



CREATE OR REPLACE FUNCTION insereValor()
RETURNS text AS $$
DECLARE
    resultado integer;
BEGIN
    resultado := ( SELECT COUNT(*) FROM ponto.tb_versao WHERE sistema = '1.0.000018');
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_versao(sistema, banco_de_dados)
        VALUES ('1.0.000018', '1.0.000018');
    END IF;
    RETURN 'SUCESSO';
END;
$$ LANGUAGE plpgsql;

SELECT insereValor();
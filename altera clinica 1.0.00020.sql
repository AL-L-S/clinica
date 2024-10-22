-- Dia 05/03/2018
CREATE TABLE ponto.tb_ambulatorio_empresa_operador
(
  ambulatorio_empresa_operador_id serial NOT NULL,
  operador_id integer,
  empresa_id integer,
  ativo boolean DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  CONSTRAINT tb_ambulatorio_empresa_operador_pkey PRIMARY KEY (ambulatorio_empresa_operador_id)
);

INSERT INTO ponto.tb_ambulatorio_empresa_operador(operador_id, empresa_id)
SELECT oe.operador_id, oe.empresa_id
FROM ponto.tb_operador_empresas oe
WHERE oe.ativo = 't'
AND oe.operador_id NOT IN (
    SELECT DISTINCT(operador_id)
    FROM ponto.tb_ambulatorio_empresa_operador
    WHERE ativo = 't'
);

-- Dia 07/03/2018
ALTER TABLE ponto.tb_empresa_permissoes ADD COLUMN subgrupo_procedimento boolean DEFAULT false;

CREATE TABLE ponto.tb_ambulatorio_subgrupo
(
  ambulatorio_subgrupo_id serial NOT NULL,
  nome character varying(250),
  ativo boolean NOT NULL DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  CONSTRAINT tb_ambulatorio_subgrupo_pkey PRIMARY KEY (ambulatorio_subgrupo_id)
);

CREATE TABLE ponto.tb_ambulatorio_subgrupo_grupo
(
  ambulatorio_subgrupo_grupo_id serial NOT NULL,
  grupo character varying(250),
  subgrupo_id integer,
  ativo boolean NOT NULL DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  CONSTRAINT tb_ambulatorio_subgrupo_grupo_pkey PRIMARY KEY (ambulatorio_subgrupo_grupo_id)
);

ALTER TABLE ponto.tb_procedimento_tuss ADD COLUMN subgrupo_id integer;
ALTER TABLE ponto.tb_forma_entradas_saida ADD COLUMN empresa_id integer;

ALTER TABLE ponto.tb_empresa_permissoes ADD COLUMN subgrupo boolean DEFAULT false;

CREATE OR REPLACE FUNCTION insereValor()
RETURNS text AS $$
DECLARE
    resultado integer;
BEGIN
    resultado := (SELECT COUNT(*) FROM ponto.tb_forma_entradas_saida WHERE empresa_id is not null);
    IF resultado = 0 THEN 

    UPDATE ponto.tb_forma_entradas_saida
    SET  empresa_id=1
    WHERE empresa_id is null;
	
    INSERT INTO ponto.tb_forma_entradas_saida(empresa_id, descricao, data_cadastro, operador_cadastro, 
            data_atualizacao, operador_atualizacao, ativo, agencia, conta)
            
    SELECT e.empresa_id,c.descricao, c.data_cadastro, c.operador_cadastro, 
        c.data_atualizacao, c.operador_atualizacao, c.ativo, c.agencia, c.conta
    FROM ponto.tb_empresa e, ponto.tb_forma_entradas_saida c
    WHERE e.empresa_id != 1
    AND c.ativo = true;

  UPDATE ponto.tb_entradas e
  SET conta = c2.forma_entradas_saida_id
  FROM ponto.tb_forma_entradas_saida c 
  LEFT JOIN ponto.tb_forma_entradas_saida c2 ON c.descricao = c2.descricao
  where e.ativo = true
  AND e.conta = c.forma_entradas_saida_id
  AND c2.empresa_id = e.empresa_id 
  AND c.ativo = true
  AND c2.ativo = true;

  UPDATE ponto.tb_saidas e
  SET conta = c2.forma_entradas_saida_id
  FROM ponto.tb_forma_entradas_saida c 
  LEFT JOIN ponto.tb_forma_entradas_saida c2 ON c.descricao = c2.descricao
  where e.ativo = true
  AND e.conta = c.forma_entradas_saida_id
  AND c2.empresa_id = e.empresa_id 
  AND c.ativo = true
  AND c2.ativo = true;


  UPDATE ponto.tb_saldo e
  SET conta = c2.forma_entradas_saida_id
  FROM ponto.tb_forma_entradas_saida c 
  LEFT JOIN ponto.tb_forma_entradas_saida c2 ON c.descricao = c2.descricao
  where e.ativo = true
  AND e.conta = c.forma_entradas_saida_id
  AND c2.empresa_id = e.empresa_id 
  AND c.ativo = true
  AND c2.ativo = true;


  UPDATE ponto.tb_financeiro_contasreceber e
  SET conta = c2.forma_entradas_saida_id
  FROM ponto.tb_forma_entradas_saida c 
  LEFT JOIN ponto.tb_forma_entradas_saida c2 ON c.descricao = c2.descricao
  where e.ativo = true
  AND e.conta = c.forma_entradas_saida_id
  AND c2.empresa_id = e.empresa_id 
  AND c.ativo = true
  AND c2.ativo = true;

  UPDATE ponto.tb_financeiro_contaspagar e
  SET conta = c2.forma_entradas_saida_id
  FROM ponto.tb_forma_entradas_saida c 
  LEFT JOIN ponto.tb_forma_entradas_saida c2 ON c.descricao = c2.descricao
  where e.ativo = true
  AND e.conta = c.forma_entradas_saida_id
  AND c2.empresa_id = e.empresa_id 
  AND c.ativo = true
  AND c2.ativo = true;
    
    END IF;
    
    RETURN 'SUCESSO';
END;
$$ LANGUAGE plpgsql;

SELECT insereValor();


-- SELECT e.empresa_id,c.descricao, c.data_cadastro, c.operador_cadastro, 
--        c.data_atualizacao, c.operador_atualizacao, c.ativo, c.agencia, c.conta
--   FROM ponto.tb_empresa e, ponto.tb_forma_entradas_saida c
--   WHERE e.empresa_id != 1
--   AND c.ativo = true


ALTER TABLE ponto.tb_convenio ADD COLUMN caminho_logo text;

ALTER TABLE ponto.tb_solicitacao_cirurgia_procedimento ADD COLUMN quantidade integer;

ALTER TABLE ponto.tb_solicitacao_cirurgia_procedimento ADD COLUMN valor_unitario numeric(10,2);

ALTER TABLE ponto.tb_solicitacao_cirurgia_material ADD COLUMN valor_unitario numeric(10,2);


ALTER TABLE ponto.tb_solicitacao_cirurgia ADD COLUMN observacao text;

ALTER TABLE ponto.tb_solicitacao_cirurgia_material ADD COLUMN observacao text;

-- Dia 12/03/2018
ALTER TABLE ponto.tb_ambulatorio_orcamento ADD COLUMN ativo boolean DEFAULT TRUE;
ALTER TABLE ponto.tb_ambulatorio_orcamento ADD COLUMN autorizado boolean DEFAULT FALSE;

-- Dia 13/03/2018
ALTER TABLE ponto.tb_ambulatorio_laudo ADD COLUMN observacao_laudo text;
ALTER TABLE ponto.tb_internacao ALTER COLUMN leito TYPE integer USING (leito::integer);

CREATE TABLE ponto.tb_solicitacao_sadt
(
  solicitacao_sadt_id serial NOT NULL,
  paciente_id integer,
  convenio_id integer,
  medico_solicitante integer,
  ativo boolean DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  guia_id integer,
  empresa_id integer,
  CONSTRAINT tb_solicitacao_sadt_pkey PRIMARY KEY (solicitacao_sadt_id)
);

CREATE TABLE ponto.tb_solicitacao_sadt_procedimento
(
  solicitacao_sadt_procedimento_id serial,
  solicitacao_sadt_id integer,
  procedimento_convenio_id integer,
  quantidade integer,
  valor numeric,
  ativo boolean DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  CONSTRAINT tb_solicitacao_sadt_procedimento_pkey PRIMARY KEY (solicitacao_sadt_procedimento_id)
);

-- Dia 14/03/2018
ALTER TABLE ponto.tb_solicitacao_cirurgia ADD COLUMN data_autorizacao date;
ALTER TABLE ponto.tb_solicitacao_cirurgia ADD COLUMN operador_autorizacao integer;
UPDATE ponto.tb_solicitacao_cirurgia
   SET data_autorizacao=data_prevista
 WHERE data_autorizacao IS NULL
 AND autorizado = 't';

ALTER TABLE ponto.tb_paciente ADD COLUMN nacionalidade text;
ALTER TABLE ponto.tb_paciente ADD COLUMN sexo_real text;

ALTER TABLE ponto.tb_procedimento_convenio_pagamento ADD COLUMN ativo boolean DEFAULT true;

ALTER TABLE ponto.tb_empresa_permissoes ADD COLUMN profissional_completo boolean DEFAULT false;
ALTER TABLE ponto.tb_empresa_permissoes ADD COLUMN tecnica_promotor boolean DEFAULT true;
ALTER TABLE ponto.tb_empresa_permissoes ADD COLUMN tecnica_enviar boolean DEFAULT true;
ALTER TABLE ponto.tb_solicitacao_cirurgia ADD COLUMN ambulatorio_laudo_id integer;



CREATE OR REPLACE FUNCTION insereValor()
RETURNS text AS $$
DECLARE
    resultado integer;
BEGIN
    resultado := ( SELECT COUNT(*) FROM ponto.tb_versao WHERE sistema = '1.0.000020');
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_versao(sistema, banco_de_dados)
        VALUES ('1.0.000020', '1.0.000020');
    END IF;
    RETURN 'SUCESSO';
END;
$$ LANGUAGE plpgsql;

SELECT insereValor();
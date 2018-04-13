-- Dia 27/03/2018
ALTER TABLE ponto.tb_procedimento_tuss ADD COLUMN agrupador_grupo character varying(50);

-- Dia 05/04/2018
CREATE TABLE ponto.tb_paciente_estorno_registro
(
  paciente_estorno_registro_id serial NOT NULL,
  paciente_credito_id integer,
  paciente_id integer,
  agenda_exames_id integer,
  procedimento_convenio_id integer,
  valor numeric(10,2),
  ativo boolean DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  forma_pagamento_id integer,
  data date,
  empresa_id integer,
  forma_pagamento1 integer,
  valor1 numeric(10,2) DEFAULT 0,
  forma_pagamento2 integer,
  valor2 numeric(10,2) DEFAULT 0,
  forma_pagamento3 integer,
  valor3 numeric(10,2) DEFAULT 0,
  forma_pagamento4 integer,
  valor4 numeric(10,2) DEFAULT 0,
  parcelas1 integer DEFAULT 1,
  parcelas2 integer DEFAULT 1,
  parcelas3 integer DEFAULT 1,
  parcelas4 integer DEFAULT 1,
  desconto_ajuste1 numeric(10,2),
  desconto_ajuste2 numeric(10,2),
  desconto_ajuste3 numeric(10,2),
  desconto_ajuste4 numeric(10,2),
  faturado boolean DEFAULT false,
  financeiro_fechado boolean DEFAULT false,
  operador_financeiro integer,
  data_financeiro timestamp without time zone,
  CONSTRAINT tb_paciente_estorno_registro_pkey PRIMARY KEY (paciente_estorno_registro_id)
);


ALTER TABLE ponto.tb_empresa_permissoes ADD COLUMN valor_convenio_nao boolean DEFAULT false;


CREATE TABLE ponto.tb_formapagamento_conta_empresa
(
  formapagamento_conta_empresa_id serial,
  forma_pagamento_id integer,
  empresa_id integer,
  conta_id integer,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  ativo boolean DEFAULT true,
  CONSTRAINT formapagamento_conta_empresa_id_pkey PRIMARY KEY (formapagamento_conta_empresa_id)
);


CREATE OR REPLACE FUNCTION insereValor()
RETURNS text AS $$
DECLARE
    resultado integer;
BEGIN
    resultado := ( SELECT COUNT(*) FROM ponto.tb_formapagamento_conta_empresa);
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_formapagamento_conta_empresa(forma_pagamento_id, empresa_id, 
            conta_id)
	SELECT fp.forma_pagamento_id, e.empresa_id, c2.forma_entradas_saida_id
	FROM ponto.tb_forma_pagamento fp, ponto.tb_empresa e, ponto.tb_forma_entradas_saida c, ponto.tb_forma_entradas_saida c2
	WHERE fp.ativo = true
	AND fp.conta_id = c.forma_entradas_saida_id
	AND c.descricao = c2.descricao
	AND e.empresa_id = c2.empresa_id
	ORDER BY fp.nome,e.empresa_id;
    END IF;
    RETURN 'SUCESSO';
END;
$$ LANGUAGE plpgsql;

SELECT insereValor();



ALTER TABLE ponto.tb_ambulatorio_laudo ADD COLUMN primeiro_atendimento boolean DEFAULT false;


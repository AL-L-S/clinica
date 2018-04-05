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

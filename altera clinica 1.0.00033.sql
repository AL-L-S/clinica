-- Iniciando versao 33

CREATE OR REPLACE FUNCTION insereValor()
RETURNS text AS $$
DECLARE
    resultado integer;
BEGIN
    resultado := ( SELECT COUNT(*) FROM ponto.tb_versao_alteracao WHERE chamado = '3229');
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_versao_alteracao(versao, alteracao, chamado, tipo)
        VALUES ('1.0.000032',
            'Ao editar o médico na guia utilizando um perfil de Administrador Total ele irá alterar também no laudo',
            '3229',
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
    resultado := ( SELECT COUNT(*) FROM ponto.tb_versao_alteracao WHERE chamado = '3289');
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_versao_alteracao(versao, alteracao, chamado, tipo)
        VALUES ('1.0.000032',
            'Ao ativar a flag de Faturamento Modelo 2 (Procedimentos com recebimento em caixa) o sistema irá mostrar no relatório produção médica uma tabela com todos os descontos aplicados, valor bruto, valor médico e valor restante da clinica (Saldo)',
            '3289',
            'Melhoria'
            );

    END IF;
    RETURN 'SUCESSO';
END;
$$ LANGUAGE plpgsql;
SELECT insereValor();
-- Dia 21/11/2018


CREATE TABLE ponto.tb_conta_grupo
(
  conta_grupo_id serial NOT NULL,
  nome character varying(250),
  conta_id integer,
  empresa_id integer,
  ativo boolean NOT NULL DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  CONSTRAINT tb_conta_grupo_pkey PRIMARY KEY (conta_grupo_id)
);

CREATE TABLE ponto.tb_conta_grupo_contas
(
  conta_grupo_contas_id serial NOT NULL,
  conta_id integer,
  conta_grupo_id integer,
  ativo boolean NOT NULL DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  CONSTRAINT tb_conta_grupo_contas_pkey PRIMARY KEY (conta_grupo_contas_id)
);

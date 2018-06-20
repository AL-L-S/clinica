-- 14/06/2018
ALTER TABLE ponto.tb_internacao ADD COLUMN idade_inicio integer;
ALTER TABLE ponto.tb_internacao ADD COLUMN tipo_dependencia integer;

ALTER TABLE ponto.tb_internacao ADD COLUMN ocupacao_responsavel text;

ALTER TABLE ponto.tb_empresa ADD COLUMN impressao_internacao integer;



CREATE OR REPLACE FUNCTION insereValor()
RETURNS text AS $$
DECLARE
    resultado integer;
BEGIN
    resultado := ( SELECT COUNT(*) FROM ponto.tb_versao_alteracao WHERE chamado = '2275');
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_versao_alteracao(versao, alteracao, chamado, tipo)
        VALUES ('1.0.000025',
            'Adicionado filtro de especialidade no faturar. Obs: Para fechar o faturamento é necessário retirar o filtro',
            '2275',
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
    resultado := ( SELECT COUNT(*) FROM ponto.tb_versao_alteracao WHERE chamado = '2286');
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_versao_alteracao(versao, alteracao, chamado, tipo)
        VALUES ('1.0.000025',
            'Impressões configuráveis adicionadas a lista de internação',
            '2286',
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
    resultado := ( SELECT COUNT(*) FROM ponto.tb_versao_alteracao WHERE chamado = '2282');
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_versao_alteracao(versao, alteracao, chamado, tipo)
        VALUES ('1.0.000025',
            'Versão alternativa do termo de internação e termo de saída adicionado para local específico (IVV)',
            '2282',
            'Melhoria'
            );
    END IF;
    RETURN 'SUCESSO';
END;
$$ LANGUAGE plpgsql;
SELECT insereValor();


ALTER TABLE ponto.tb_internacao ADD COLUMN excluido boolean DEFAULT false;



CREATE TABLE ponto.tb_empresa_impressao_internacao_temp
(
  empresa_impressao_internacao_temp_id serial,
  texto text,
  impressao_id integer,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  adicional_cabecalho text,
  CONSTRAINT tb_empresa_impressao_internacao_temp_pkey PRIMARY KEY (empresa_impressao_internacao_temp_id)
);
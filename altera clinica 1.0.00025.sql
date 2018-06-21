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


ALTER TABLE ponto.tb_internacao ADD COLUMN procedimento_convenio_id integer;

ALTER TABLE ponto.tb_internacao ADD COLUMN valor_total numeric(10,2);


-- QUERY CORRETA PARA AS CLINICAS COMUNS
UPDATE ponto.tb_internacao i
  SET procedimento_convenio_id = selecao.procedimento_convenio_id
FROM 
 (SELECT i.internacao_id, pc.procedimento_convenio_id
FROM ponto.tb_internacao i
LEFT JOIN ponto.tb_paciente p ON i.paciente_id = p.paciente_id 
LEFT JOIN ponto.tb_procedimento_convenio pc ON p.convenio_id = pc.convenio_id 
WHERE p.convenio_id is not null
AND pc.procedimento_tuss_id = i.procedimentosolicitado
 ) as selecao
 WHERE i.internacao_id = selecao.internacao_id;
 



-- QUERY ESPECIFICA PARA O IVV
-- ESSA QUERY É PARA O IVV ESPECIFICAMENTE DEVIDO AO FATO DE QUE ELES COLOCARAM PROCEDIMENTOS_TUSS
-- COM ID DIFERENTE NAS INTERNAÇOES, NAO SEGUINDO UM PADRAO PARA PODER COMEÇAR A UTILIZAR VALOR NOS PROCEDIMENTOS
-- SENDO ASSIM ESSA QUERY ABAIXO OLHA APENAS PARA O CONVENIO E NAO PARA O PROCEDIMENTO, JA QUE ELES POSSUEM APENAS UM
-- POR CONVENIO
-- NAS OUTRAS CLINICAS, É SÓ RODAR A DE CIMA
/*

UPDATE ponto.tb_internacao i
  SET procedimento_convenio_id = selecao.procedimento_convenio_id
FROM 
 (SELECT i.internacao_id, i.paciente_id, i.procedimentosolicitado, p.convenio_id, pc.procedimento_convenio_id
 FROM ponto.tb_internacao i
 LEFT JOIN ponto.tb_paciente p ON i.paciente_id = p.paciente_id 
 LEFT JOIN ponto.tb_procedimento_convenio pc ON p.convenio_id = pc.convenio_id 
 --WHERE p.convenio_id is not null
 WHERE pc.convenio_id = p.convenio_id
 ) as selecao
 WHERE i.internacao_id = selecao.internacao_id;



UPDATE ponto.tb_internacao i
  SET procedimento_convenio_id = selecao.procedimento_convenio_id
FROM 
 (SELECT i.internacao_id, pc.procedimento_convenio_id
FROM ponto.tb_internacao i
LEFT JOIN ponto.tb_paciente p ON i.paciente_id = p.paciente_id 
LEFT JOIN ponto.tb_procedimento_convenio pc ON p.convenio_id = pc.convenio_id 
WHERE p.convenio_id is not null
AND pc.procedimento_tuss_id = i.procedimentosolicitado
 ) as selecao
 WHERE i.internacao_id = selecao.internacao_id;

 */

UPDATE ponto.tb_internacao i
  SET valor_total = selecao.valortotal
FROM 
 (SELECT pc.procedimento_convenio_id, valortotal
   FROM ponto.tb_procedimento_convenio pc
 ) as selecao
 WHERE i.procedimento_convenio_id = selecao.procedimento_convenio_id
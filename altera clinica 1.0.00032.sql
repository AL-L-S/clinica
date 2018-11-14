ALTER TABLE ponto.tb_internacao ADD COLUMN internacao_statusinternacao_id integer;
ALTER TABLE ponto.tb_internacao ADD COLUMN operador_status integer;
ALTER TABLE ponto.tb_internacao ADD COLUMN data_status timestamp without time zone;


CREATE TABLE ponto.tb_internacao_procedimento_externo
(
  internacao_procedimento_externo_id serial NOT NULL,
  internacao_id integer,
  procedimento text,
  duracao text,
  observacao text,
  data date,
  ativo boolean DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  CONSTRAINT tb_internacao_procedimento_externo_pkey PRIMARY KEY (internacao_procedimento_externo_id)
);



-- Dia 05/11/2018

ALTER TABLE ponto.tb_cadastro_aso ADD COLUMN detalhamento_nr text;

ALTER TABLE ponto.tb_empresa_permissoes ADD COLUMN ordenacao_situacao boolean DEFAULT false;

-- Dia 06/11/2018

ALTER TABLE ponto.tb_farmacia_produto ADD COLUMN procedimento_tuss_id integer;

-- Dia 07/11/2018

ALTER TABLE ponto.tb_empresa_permissoes ADD COLUMN filtrar_agenda boolean DEFAULT false;


ALTER TABLE ponto.tb_agenda_exames ADD COLUMN carater_xml integer DEFAULT 1;

-- Corrigindo os problemas de ordenação na tela de atendimento.

UPDATE ponto.tb_ambulatorio_laudo
   SET data_finalizado = data_atualizacao
 WHERE situacao = 'FINALIZADO' and data_finalizado is null;

ALTER TABLE ponto.tb_ambulatorio_orcamento ADD COLUMN recusado boolean DEFAULT false;

ALTER TABLE ponto.tb_empresa_permissoes ADD COLUMN grupo_convenio_proc boolean DEFAULT false;

CREATE OR REPLACE FUNCTION insereValor()
RETURNS text AS $$
DECLARE
    resultado integer;
BEGIN
    resultado := ( SELECT COUNT(*) FROM ponto.tb_versao_alteracao WHERE chamado = '3202');
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_versao_alteracao(versao, alteracao, chamado, tipo)
        VALUES ('1.0.000032',
            'Agora é possível associar um procedimento a um produto na farmácia, ao fazer isso, é possível associar um convênio ao procedimento e com um convênio associado, na tela de prescrição o produto aparecerá na cor verde, caso contrário, na cor azul.',
            '3202',
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
    resultado := ( SELECT COUNT(*) FROM ponto.tb_versao_alteracao WHERE chamado = '3201');
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_versao_alteracao(versao, alteracao, chamado, tipo)
        VALUES ('1.0.000032',
            'Nas opções de Internação do paciente é possível adicionar um procedimento que será realizado em outra instituição, informando quanto tempo irá demorar, o que o paciente irá fazer, a data em que será realizado e observações',
            '3201',
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
    resultado := ( SELECT COUNT(*) FROM ponto.tb_versao_alteracao WHERE chamado = '3189');
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_versao_alteracao(versao, alteracao, chamado, tipo)
        VALUES ('1.0.000032',
            'Na multifunção geral calendário da recepção utilizando o layout 2, existe a possibilidade de filtar os agendamentos por Procedimento',
            '3189',
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
    resultado := ( SELECT COUNT(*) FROM ponto.tb_versao_alteracao WHERE chamado = '3188');
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_versao_alteracao(versao, alteracao, chamado, tipo)
        VALUES ('1.0.000032',
            'A opção de alterar o médico na tela de atendimento não aparece mais para o médico, só é possível alterar o médico se o usuário tiver perfil de Administrador Total.',
            '3188',
            'Melhoria'
            );

    END IF;
    RETURN 'SUCESSO';
END;
$$ LANGUAGE plpgsql;
SELECT insereValor();

-- Dia 10/11/2018

ALTER TABLE ponto.tb_financeiro_contaspagar ADD COLUMN periodo text;

ALTER TABLE ponto.tb_financeiro_contaspagar ADD COLUMN intervalo_parcela integer;

-- Dia 12/11/2018

ALTER TABLE ponto.tb_procedimento_convenio ADD COLUMN validade integer;

UPDATE ponto.tb_procedimento_convenio
SET validade = 365
WHERE procedimento_tuss_id in (SELECT procedimento_tuss_id FROM ponto.tb_procedimento_tuss WHERE grupo = 'ASO')
AND validade is null;
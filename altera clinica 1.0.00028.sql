--------------------------------- INICIANDO A VERSÃO 28-----------------------------------------------------

-- Dia 12/09/2018

ALTER TABLE ponto.tb_empresa_permissoes ADD COLUMN profissional_agendar boolean DEFAULT true;

ALTER TABLE ponto.tb_empresa_permissoes ADD COLUMN profissional_externo boolean DEFAULT false;

ALTER TABLE ponto.tb_operador ADD COLUMN profissional_agendar_o boolean DEFAULT true;

CREATE OR REPLACE FUNCTION insereValor()
RETURNS text AS $$
DECLARE
    resultado integer;
BEGIN
    resultado := ( SELECT COUNT(*) FROM ponto.tb_versao_alteracao WHERE chamado = '2870');
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_versao_alteracao(versao, alteracao, chamado, tipo)
        VALUES ('1.0.000028',
            'Adicionada a possibilidade de um profissional não poder agendar na multifunção fisioterapia. Existe uma flag no cadastro de empresa e uma no cadastro do profissional para isso. Ativando a da empresa a opção fica ativa no cadastro do profissional',
            '2870',
            'Melhoria'
            );

    END IF;
    RETURN 'SUCESSO';
END;
$$ LANGUAGE plpgsql;
SELECT insereValor();


ALTER TABLE ponto.tb_internacao ADD COLUMN senha TEXT;

ALTER TABLE ponto.tb_internacao_ficha_questionario ADD COLUMN observacao_ligacao TEXT;

-- Dia 13/09/2018

CREATE TABLE ponto.tb_laudo_apendicite
(
  simnao text,
  perguntas text,
  
  guia_id integer,
  paciente_id integer,
  laudo_apendicite_id serial not null  
);
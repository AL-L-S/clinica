ALTER TABLE ponto.tb_internacao ADD COLUMN internacao_statusinternacao_id integer;
ALTER TABLE ponto.tb_internacao ADD COLUMN operador_status integer;
ALTER TABLE ponto.tb_internacao ADD COLUMN data_status timestamp without time zone;

-- Dia 05/11/2018

ALTER TABLE ponto.tb_cadastro_aso ADD COLUMN detalhamento_nr text;


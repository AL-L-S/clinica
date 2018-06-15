-- 14/06/2018
ALTER TABLE ponto.tb_internacao ADD COLUMN idade_inicio integer;
ALTER TABLE ponto.tb_internacao ADD COLUMN tipo_dependencia integer;

ALTER TABLE ponto.tb_internacao ADD COLUMN ocupacao_responsavel text;

ALTER TABLE ponto.tb_empresa ADD COLUMN impressao_internacao integer;
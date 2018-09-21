-- 18/09
ALTER TABLE ponto.tb_empresa ADD COLUMN endereco_integracao_lab text;
ALTER TABLE ponto.tb_empresa ADD COLUMN identificador_lis text;
ALTER TABLE ponto.tb_empresa ADD COLUMN origem_lis text;


ALTER TABLE ponto.tb_ambulatorio_atestado ALTER COLUMN texto TYPE text;

ALTER TABLE ponto.tb_agenda_exames ADD COLUMN mensagem_integracao_lab text;
ALTER TABLE ponto.tb_agenda_exames ADD COLUMN json_integracao_lab text;
ALTER TABLE ponto.tb_agenda_exames ADD COLUMN data_integracao_lab timestamp without time zone;
ALTER TABLE ponto.tb_agenda_exames ADD COLUMN operador_integracao_lab integer;
ALTER TABLE ponto.tb_agenda_exames ADD COLUMN json_resultado_lab text;
ALTER TABLE ponto.tb_agenda_exames ADD COLUMN data_resultado_lab timestamp without time zone;
ALTER TABLE ponto.tb_agenda_exames ADD COLUMN operador_resultado_lab integer;
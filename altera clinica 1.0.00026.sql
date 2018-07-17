-- Dia 12/07/2018
ALTER TABLE ponto.tb_paciente_estorno_registro ADD COLUMN justificativa TEXT;

-- Dia 16/07/2018
ALTER TABLE ponto.tb_empresa_permissoes ADD COLUMN relatorios_clinica_med boolean DEFAULT false;

-- Dia 17/07/2018
ALTER TABLE ponto.tb_ambulatorio_orcamento_item ADD COLUMN data_preferencia timestamp without time zone;
-- Dia 06/02/2018
ALTER TABLE ponto.tb_estoque_armazem ADD COLUMN visivel_solicitacao boolean DEFAULT true;

-- Dia 07/02/2018
ALTER TABLE ponto.tb_agenda_exames ADD COLUMN confirmacao_recebimento_convenio boolean DEFAULT false;

-- Dia 07/02/2018
ALTER TABLE ponto.tb_paciente_indicacao ADD COLUMN credor_devedor_id integer;
ALTER TABLE ponto.tb_paciente_indicacao ADD COLUMN conta_id integer;
ALTER TABLE ponto.tb_paciente_indicacao ADD COLUMN classe character varying(60);
ALTER TABLE ponto.tb_paciente_indicacao ADD COLUMN tipo_id character varying(60);


-- Dia 26/04/2018
ALTER TABLE ponto.tb_ambulatorio_orcamento_item ADD COLUMN dia_semana_preferencia text;
ALTER TABLE ponto.tb_ambulatorio_orcamento_item ADD COLUMN turno_prefencia text;

-- Dia 12/05/2018
ALTER TABLE ponto.tb_empresa ADD COLUMN horario_seg_sex_inicio text;
ALTER TABLE ponto.tb_empresa ADD COLUMN horario_seg_sex_fim text;
ALTER TABLE ponto.tb_empresa ADD COLUMN horario_sab_inicio text;
ALTER TABLE ponto.tb_empresa ADD COLUMN horario_sab_fim text;

UPDATE ponto.tb_empresa
   SET horario_seg_sex_inicio='08:00', horario_seg_sex_fim='18:00', horario_sab_inicio='08:00', horario_sab_fim='12:00'
 WHERE (horario_seg_sex_inicio IS NULL OR horario_seg_sex_inicio = '');

-- Dia 20/01/2018
ALTER TABLE ponto.tb_ambulatorio_orcamento_item ADD COLUMN valor_ajustado numeric(10,2);

-- Dia 23/01/2018
UPDATE ponto.tb_ambulatorio_orcamento_item oi
SET paciente_id = ( SELECT paciente_id FROM ponto.tb_ambulatorio_orcamento WHERE ponto.tb_ambulatorio_orcamento.ambulatorio_orcamento_id = oi.orcamento_id LIMIT 1 )
WHERE oi.paciente_id IS NULL;

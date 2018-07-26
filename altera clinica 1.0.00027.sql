-- Dia 26/07/2018
ALTER TABLE ponto.tb_ambulatorio_orcamento_item ADD COLUMN autorizado boolean DEFAULT false;
UPDATE ponto.tb_ambulatorio_orcamento_item SET autorizado = ao.autorizado 
FROM ( 
    ponto.tb_ambulatorio_orcamento_item aoi 
    INNER JOIN ponto.tb_ambulatorio_orcamento ao
    ON aoi.orcamento_id = ao.ambulatorio_orcamento_id
)
WHERE ponto.tb_ambulatorio_orcamento_item.ambulatorio_orcamento_item_id = aoi.ambulatorio_orcamento_item_id
AND ponto.tb_ambulatorio_orcamento_item.autorizado != true;

UPDATE ponto.tb_ambulatorio_orcamento_item SET data_preferencia = ao.data_criacao 
FROM ( 
    ponto.tb_ambulatorio_orcamento_item aoi 
    INNER JOIN ponto.tb_ambulatorio_orcamento ao
    ON aoi.orcamento_id = ao.ambulatorio_orcamento_id
)
WHERE ponto.tb_ambulatorio_orcamento_item.ambulatorio_orcamento_item_id = aoi.ambulatorio_orcamento_item_id
AND ponto.tb_ambulatorio_orcamento_item.data_preferencia IS NULL;

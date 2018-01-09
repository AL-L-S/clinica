--09/01/2018


CREATE OR REPLACE FUNCTION insereValor()
RETURNS text AS $$
DECLARE
    resultado integer;
BEGIN
    resultado := ( SELECT COUNT(*) FROM ponto.tb_perfil WHERE nome = 'GERENTE DE RECEPÇÃO FINANCEIRO');
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_perfil(perfil_id, nome)
        VALUES (18, 'GERENTE DE RECEPÇÃO FINANCEIRO');
    END IF;
    RETURN 'SUCESSO';
END;
$$ LANGUAGE plpgsql;

SELECT insereValor();





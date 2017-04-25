-- ADICIONANDO A FUNCIONALIDADE DE FISIOTERAPIA HOME CARE.
-- AO MARCAR ESSA OPÇÃO NO CONVÊNIO, A PRIMEIRA SESSÃO DO PROCEDIMENTO NÃO É LIBERADO NA HORA

-- 04/04/2017
ALTER TABLE ponto.tb_convenio ADD COLUMN home_care boolean DEFAULT false;


-- 06/04/2017


DROP TABLE ponto.tb_versao;
CREATE TABLE ponto.tb_versao
(
  versao_id SERIAL NOT NULL,
  sistema character varying(20),
  banco_de_dados character varying(20),
  CONSTRAINT tb_versao_pkey PRIMARY KEY (versao_id )
);

INSERT INTO ponto.tb_versao(sistema, banco_de_dados)
    VALUES ('1.0.00005', '1.0.00004');

-- Versão 1.0.00005 Adicionado ajuste de valores relacionados ao relatório de conferência


-- 07/04/2017 Procedimentos Home Care

ALTER TABLE ponto.tb_procedimento_tuss ADD COLUMN home_care boolean DEFAULT false;

INSERT INTO ponto.tb_versao(sistema, banco_de_dados)
    VALUES ('1.0.00006', '1.0.00005');
-- 12/04/2017 Flag para verificar se já foi feito o ajuste de valores relacionados com o convênio

ALTER TABLE ponto.tb_agenda_exames ADD COLUMN ajuste_cbhpm boolean DEFAULT false;



---++++++++++ VERSÃO 1.0.00007 ++++++++++---
-- Querys para fazer com que na tela "manter contas a receber"
-- Seja mostrado o valor da parcela, seguido do total de parcelas. Ex: 1/7
UPDATE ponto.tb_financeiro_contasreceber fc
SET parcela = '1'
WHERE parcela IS NULL

UPDATE ponto.tb_financeiro_contasreceber fc
SET numero_parcela =
		(
			SELECT MAX(parcela) AS total FROM ponto.tb_financeiro_contasreceber
			WHERE ponto.tb_financeiro_contasreceber.devedor = fc.devedor
			AND ponto.tb_financeiro_contasreceber.conta = fc.conta
			AND ponto.tb_financeiro_contasreceber.classe = fc.classe	
			AND TO_CHAR(ponto.tb_financeiro_contasreceber.data_cadastro, 'YYYY-DD-MM HH24:MI') = TO_CHAR(fc.data_cadastro, 'YYYY-DD-MM HH24:MI')
		);


--| Versão 1.0.00007 
--|     1 - Correções no relatorio de caixa personalizado (aparencia e layout)
--|     2 - Correções no relatorio de nota (ao clicar no nome do paciente o sistema abre um pop-up com os dados do paciente)
--|     3 - Correções na tela "manter contas a receber" (o sistema agora informa o numero total de parcelas)
--|     4 - Correção no filtro de especialidade nas multifunções do medico (ao selecionar uma especialidade e pesquisar 
--| ele traz de todos os medicos daquela especialidade)
--|     5 - Mudanças na impressão do relatorio de orçamento. Agora o relatorio esta em grade (com borda nas tabelas) e o campo 
--| "descrição" agora sai na impressao do relatorio.

INSERT INTO ponto.tb_versao(sistema, banco_de_dados)
    VALUES ('1.0.00007', '1.0.00005');

---++++++++ FIM VERSÃO 1.0.00007 ++++++++---


--| Versão 1.0.00007 
--|     1 - Médicos não tem mais acesso a recepção, com exceção do cadastro de pacientes.
--|     2 - Médicos não tem mais acesso a recepção, com exceção do cadastro de pacientes.
ALTER TABLE ponto.tb_operador ADD COLUMN curriculo character varying(20000);


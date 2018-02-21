-- Dia 16/02/2018
ALTER TABLE ponto.tb_empresa_permissoes ADD COLUMN repetir_horarios_agenda boolean DEFAULT false;
ALTER TABLE ponto.tb_empresa_permissoes ADD COLUMN conjuge boolean DEFAULT false;
ALTER TABLE ponto.tb_paciente ADD COLUMN nome_conjuge text;
ALTER TABLE ponto.tb_paciente ADD COLUMN nascimento_conjuge date;
ALTER TABLE ponto.tb_paciente ADD COLUMN instagram text;
ALTER TABLE ponto.tb_paciente ADD COLUMN vencimento_carteira date;

ALTER TABLE ponto.tb_operador ADD COLUMN ocupacao_painel boolean DEFAULT true;

ALTER TABLE ponto.tb_empresa_permissoes ADD COLUMN laudo_sigiloso boolean DEFAULT false;
-- Dia 20/02/2018

ALTER TABLE ponto.tb_ambulatorio_laudo ADD COLUMN adendo text;

-- Brasindice importação

CREATE TABLE ponto.tb_brasindice_material
(
  brasindice_material_id serial,
  codigo_laboratorio character varying(500),
  nome_laboratorio character varying(500), 
  codigo_material character varying(500),
  nome_material character varying(500),
  codigo_apresentacao character varying(500),
  nome_apresentacao character varying(500),
  preco character varying(10),
  quantidade_fracionamento character varying(10),
  tipo_preco character varying(10),
  valor_fracionado character varying(10),
  edicao_alteracao_preco character varying(500),
  ipi_material character varying(10),
  flag_portaria character varying(10),
  brasindice_tiss character varying(50),
  tuss_material character varying(50),
  hierarquia_material character varying(500),
  ativo boolean DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  CONSTRAINT tb_brasindice_material_pkey PRIMARY KEY (brasindice_material_id)
);


COPY ponto.tb_brasindice_material(codigo_laboratorio, nome_laboratorio, 
            codigo_material, nome_material, codigo_apresentacao, nome_apresentacao, 
            preco, quantidade_fracionamento, tipo_preco, valor_fracionado, 
            edicao_alteracao_preco, ipi_material, flag_portaria, brasindice_tiss, tuss_material)
           
	FROM '/home/sisprod/material_brasindice.txt' DELIMITER '@' encoding 'windows-1252'; 


UPDATE ponto.tb_brasindice_material
   SET codigo_laboratorio=replace(codigo_laboratorio, '"', ''), 
       nome_laboratorio=replace(nome_laboratorio, '"', ''), 
       codigo_material=replace(codigo_material, '"', ''),
       nome_material=replace(nome_material, '"', ''), 
       codigo_apresentacao=replace(codigo_apresentacao, '"', ''),
       nome_apresentacao=replace(nome_apresentacao, '"', ''), 
       preco=replace(preco, '"', ''), 
       quantidade_fracionamento=replace(quantidade_fracionamento, '"', ''), 
       tipo_preco=replace(tipo_preco, '"', ''), 
       valor_fracionado=replace(valor_fracionado, '"', ''), 
       edicao_alteracao_preco=replace(edicao_alteracao_preco, '"', ''), 
       ipi_material=replace(ipi_material, '"', ''), 
       flag_portaria=replace(flag_portaria, '"', ''), 
       brasindice_tiss=replace(brasindice_tiss, '"', ''), 
       tuss_material = replace(tuss_material, '"', '');


--- MEDICAMENTOS


CREATE TABLE ponto.tb_brasindice_medicamento
(
  brasindice_medicamento_id serial,
  codigo_laboratorio character varying(500),
  nome_laboratorio character varying(500), 
  codigo_medicamento character varying(500),
  nome_medicamento character varying(500),
  codigo_apresentacao character varying(500),
  nome_apresentacao character varying(500),
  preco character varying(10),
  quantidade_fracionamento character varying(10),
  tipo_preco character varying(10),
  valor_fracionado character varying(10),
  edicao_alteracao_preco character varying(500),
  ipi_medicamento character varying(10),
  flag_portaria character varying(10),
  codigo_ean character varying(100),
  brasindice_tiss character varying(50),
  tuss_medicamento character varying(50),
  hierarquia_medicamento character varying(500),
  ativo boolean DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  CONSTRAINT tb_brasindice_medicamento_pkey PRIMARY KEY (brasindice_medicamento_id)
  );


COPY ponto.tb_brasindice_medicamento(codigo_laboratorio, nome_laboratorio, 
            codigo_medicamento, nome_medicamento, codigo_apresentacao, nome_apresentacao, 
            preco, quantidade_fracionamento, tipo_preco, valor_fracionado, 
            edicao_alteracao_preco, ipi_medicamento, flag_portaria, codigo_ean, brasindice_tiss, tuss_medicamento)
           
	FROM '/home/sisprod/medicamento_brasindice.txt' DELIMITER '@' encoding 'windows-1252'; 


UPDATE ponto.tb_brasindice_medicamento
   SET codigo_laboratorio=replace(codigo_laboratorio, '"', ''), 
       nome_laboratorio=replace(nome_laboratorio, '"', ''), 
       codigo_medicamento=replace(codigo_medicamento, '"', ''),
       nome_medicamento=replace(nome_medicamento, '"', ''), 
       codigo_apresentacao=replace(codigo_apresentacao, '"', ''),
       nome_apresentacao=replace(nome_apresentacao, '"', ''), 
       preco=replace(preco, '"', ''), 
       quantidade_fracionamento=replace(quantidade_fracionamento, '"', ''), 
       tipo_preco=replace(tipo_preco, '"', ''), 
       valor_fracionado=replace(valor_fracionado, '"', ''), 
       edicao_alteracao_preco=replace(edicao_alteracao_preco, '"', ''), 
       ipi_medicamento=replace(ipi_medicamento, '"', ''), 
       flag_portaria=replace(flag_portaria, '"', ''), 
       brasindice_tiss=replace(brasindice_tiss, '"', ''), 
       tuss_medicamento = replace(tuss_medicamento, '"', '');


-- SOLUÇÕES 

CREATE TABLE ponto.tb_brasindice_solucao
(
  brasindice_solucao_id serial,
  codigo_laboratorio character varying(500),
  nome_laboratorio character varying(500), 
  codigo_solucao character varying(500),
  nome_solucao character varying(500),
  codigo_apresentacao character varying(500),
  nome_apresentacao character varying(500),
  preco character varying(10),
  quantidade_fracionamento character varying(10),
  tipo_preco character varying(10),
  valor_fracionado character varying(10),
  edicao_alteracao_preco character varying(500),
  ipi_solucao character varying(10),
  flag_portaria character varying(10),
  codigo_ean character varying(100),
  brasindice_tiss character varying(50),
  tuss_solucao character varying(50),
  hierarquia_solucao character varying(500),
  ativo boolean DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  CONSTRAINT tb_brasindice_solucao_pkey PRIMARY KEY (brasindice_solucao_id)
  );


COPY ponto.tb_brasindice_solucao(codigo_laboratorio, nome_laboratorio, 
            codigo_solucao, nome_solucao, codigo_apresentacao, nome_apresentacao, 
            preco, quantidade_fracionamento, tipo_preco, valor_fracionado, 
            edicao_alteracao_preco, ipi_solucao, flag_portaria,codigo_ean, brasindice_tiss, tuss_solucao)
           
	FROM '/home/sisprod/solucao_brasindice.txt' DELIMITER '@' encoding 'windows-1252'; 


UPDATE ponto.tb_brasindice_solucao
   SET codigo_laboratorio=replace(codigo_laboratorio, '"', ''), 
       nome_laboratorio=replace(nome_laboratorio, '"', ''), 
       codigo_solucao=replace(codigo_solucao, '"', ''),
       nome_solucao=replace(nome_solucao, '"', ''), 
       codigo_apresentacao=replace(codigo_apresentacao, '"', ''),
       nome_apresentacao=replace(nome_apresentacao, '"', ''), 
       preco=replace(preco, '"', ''), 
       quantidade_fracionamento=replace(quantidade_fracionamento, '"', ''), 
       tipo_preco=replace(tipo_preco, '"', ''), 
       valor_fracionado=replace(valor_fracionado, '"', ''), 
       edicao_alteracao_preco=replace(edicao_alteracao_preco, '"', ''), 
       ipi_solucao=replace(ipi_solucao, '"', ''), 
       flag_portaria=replace(flag_portaria, '"', ''), 
       brasindice_tiss=replace(brasindice_tiss, '"', ''), 
       tuss_solucao = replace(tuss_solucao, '"', '');


ALTER TABLE ponto.tb_brasindice_medicamento ALTER COLUMN preco TYPE numeric(10,2) USING (preco::numeric(10,2));
ALTER TABLE ponto.tb_brasindice_medicamento ALTER COLUMN valor_fracionado TYPE numeric(10,2) USING (valor_fracionado::numeric(10,2));
ALTER TABLE ponto.tb_brasindice_medicamento ALTER COLUMN quantidade_fracionamento TYPE integer USING (quantidade_fracionamento::integer);
ALTER TABLE ponto.tb_brasindice_medicamento ALTER COLUMN ipi_medicamento TYPE numeric(10,2) USING (ipi_medicamento::numeric(10,2));


ALTER TABLE ponto.tb_brasindice_material ALTER COLUMN preco TYPE numeric(10,2) USING (preco::numeric(10,2));
ALTER TABLE ponto.tb_brasindice_material ALTER COLUMN valor_fracionado TYPE numeric(10,2) USING (valor_fracionado::numeric(10,2));
ALTER TABLE ponto.tb_brasindice_material ALTER COLUMN quantidade_fracionamento TYPE integer USING (quantidade_fracionamento::integer);
ALTER TABLE ponto.tb_brasindice_material ALTER COLUMN ipi_material TYPE numeric(10,2) USING (ipi_material::numeric(10,2));


ALTER TABLE ponto.tb_brasindice_solucao ALTER COLUMN preco TYPE numeric(10,2) USING (preco::numeric(10,2));
ALTER TABLE ponto.tb_brasindice_solucao ALTER COLUMN valor_fracionado TYPE numeric(10,2) USING (valor_fracionado::numeric(10,2));
ALTER TABLE ponto.tb_brasindice_solucao ALTER COLUMN quantidade_fracionamento TYPE integer USING (quantidade_fracionamento::integer);
ALTER TABLE ponto.tb_brasindice_solucao ALTER COLUMN ipi_solucao TYPE numeric(10,2) USING (ipi_solucao::numeric(10,2));

ALTER TABLE ponto.tb_tuss ADD COLUMN tipo text;
ALTER TABLE ponto.tb_tuss ADD COLUMN tabela text;
ALTER TABLE ponto.tb_tuss ADD COLUMN brasindice_material_id integer;
ALTER TABLE ponto.tb_tuss ADD COLUMN brasindice_solucao_id integer;
ALTER TABLE ponto.tb_tuss ADD COLUMN brasindice_medicamento_id integer;





INSERT INTO ponto.tb_tuss(
            brasindice_material_id, codigo, descricao, grupo, 
            valor,valor_bri, grupo_matmed)
  SELECT brasindice_material_id, tuss_material, concat_ws(' ', nome_material::text, nome_apresentacao::text) as material  , 'MATERIAL',
         valor_fracionado, valor_fracionado, 'MATERIAL'
       tuss_material
  FROM ponto.tb_brasindice_material;



INSERT INTO ponto.tb_tuss(
            brasindice_medicamento_id, codigo, descricao, grupo, 
            valor,valor_bri, grupo_matmed)
 SELECT brasindice_medicamento_id, tuss_medicamento, concat_ws(' ', nome_medicamento::text, nome_apresentacao::text) as medicamento  , 'MEDICAMENTO',
         valor_fracionado, valor_fracionado, 'MEDICAMENTO'
       tuss_medicamento
  FROM ponto.tb_brasindice_medicamento;


INSERT INTO ponto.tb_tuss(
            brasindice_solucao_id, codigo, descricao, grupo, 
            valor,valor_bri, grupo_matmed)
 SELECT brasindice_solucao_id, tuss_solucao, concat_ws(' ', nome_solucao::text, nome_apresentacao::text) as solucao  , 'SOLUCAO',
         valor_fracionado, valor_fracionado, 'SOLUCAO'
       tuss_solucao
  FROM ponto.tb_brasindice_solucao;




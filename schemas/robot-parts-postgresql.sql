

CREATE TABLE robots (
  id SERIAL NOT NULL,
  name character varying(70) NOT NULL,
  type character varying(32) NOT NULL,
  year smallint NOT NULL,

  CONSTRAINT robots_pkey PRIMARY KEY (id)
);


CREATE TABLE parts (
  id SERIAL NOT NULL,
  name character varying(70) NOT NULL,

  CONSTRAINT parts_pkey PRIMARY KEY (id)
);


CREATE TABLE parts2robots (
  id SERIAL NOT NULL,
  robots_id int NOT NULL,
  parts_id int NOT NULL,
  created_at timestamp without time zone NOT NULL DEFAULT now(),

  CONSTRAINT parts2robots_pkey PRIMARY KEY (id),
  CONSTRAINT parts2robots_robots_id_fk FOREIGN KEY (robots_id)
      REFERENCES public.robots (id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  CONSTRAINT parts2robots_parts_id_fk FOREIGN KEY (parts_id)
      REFERENCES public.parts (id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION
);

INSERT INTO robots("id", "name", "type", "year") VALUES
(1, 'WowWee Mip Robot', 'Remote controlled', 2017),
(2, 'WowWee Miposaur', 'Remote controlled', 2017)
;

SELECT pg_catalog.setval('robots_id_seq', 3, false);


INSERT INTO parts(id, name) VALUES
(1, 'Head of Mip Robot'),
(2, 'Corpus of Mip Robot'),
(3, 'Left arm of Mip Robot'),
(4, 'Right arm of Mip Robot'),
(5, 'Left wheel of Mip Robot'),
(6, 'Right wheel of Mip Robot'),

(7, 'Head of Miposaur'),
(8, 'Corpus of Miposaur'),
(9, 'Left arm of Miposaur'),
(10, 'Right arm of Miposaur'),
(11, 'Left wheel of Miposaur'),
(12, 'Right wheel of Miposaur'),
(13, 'Tail of Miposaur')
;

SELECT pg_catalog.setval('parts_id_seq', 14, false);


INSERT INTO parts2robots(id, robots_id, parts_id, created_at) VALUES
(1, 1, 1, now()),
(2, 1, 2, now()),
(3, 1, 3, now()),
(4, 1, 4, now()),
(5, 1, 5, now()),
(6, 1, 6, now())
;

SELECT pg_catalog.setval('parts2robots_id_seq', 7, false);
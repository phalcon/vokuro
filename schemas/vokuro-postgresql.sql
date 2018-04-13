--
-- PostgreSQL database dump
--

-- Dumped from database version 9.3.5
-- Dumped by pg_dump version 9.3.5
-- Started on 2014-12-16 09:40:47 EAT

SET statement_timeout = 0;
SET lock_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

--
-- TOC entry 2076 (class 1262 OID 12066)
-- Dependencies: 2075
-- Name: postgres; Type: COMMENT; Schema: -; Owner: postgres
--

COMMENT ON DATABASE postgres IS 'default administrative connection database';


--
-- TOC entry 188 (class 3079 OID 11787)
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner:
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- TOC entry 2079 (class 0 OID 0)
-- Dependencies: 188
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner:
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


SET search_path = public, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- TOC entry 171 (class 1259 OID 16411)
-- Name: email_confirmations; Type: TABLE; Schema: public; Owner: postgres; Tablespace:
--

CREATE TABLE email_confirmations (
    id integer NOT NULL,
    "usersId" integer NOT NULL,
    code character(32) NOT NULL,
    "createdAt" integer NOT NULL,
    "modifiedAt" integer,
    confirmed character(1) DEFAULT 'N'::bpchar
);


ALTER TABLE public.email_confirmations OWNER TO postgres;

--
-- TOC entry 170 (class 1259 OID 16409)
-- Name: email_confirmations_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE email_confirmations_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.email_confirmations_id_seq OWNER TO postgres;

--
-- TOC entry 2080 (class 0 OID 0)
-- Dependencies: 170
-- Name: email_confirmations_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE email_confirmations_id_seq OWNED BY email_confirmations.id;


--
-- TOC entry 173 (class 1259 OID 16420)
-- Name: failed_logins; Type: TABLE; Schema: public; Owner: postgres; Tablespace:
--

CREATE TABLE failed_logins (
    id integer NOT NULL,
    "usersId" integer,
    "ipAddress" character(15) NOT NULL,
    attempted integer NOT NULL
);


ALTER TABLE public.failed_logins OWNER TO postgres;

--
-- TOC entry 172 (class 1259 OID 16418)
-- Name: failed_logins_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE failed_logins_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.failed_logins_id_seq OWNER TO postgres;

--
-- TOC entry 2081 (class 0 OID 0)
-- Dependencies: 172
-- Name: failed_logins_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE failed_logins_id_seq OWNED BY failed_logins.id;


--
-- TOC entry 175 (class 1259 OID 16426)
-- Name: password_changes; Type: TABLE; Schema: public; Owner: postgres; Tablespace:
--

CREATE TABLE password_changes (
    id integer NOT NULL,
    "usersId" integer NOT NULL,
    "ipAddress" character(15) NOT NULL,
    "userAgent" text NOT NULL,
    "createdAt" integer NOT NULL
);


ALTER TABLE public.password_changes OWNER TO postgres;

--
-- TOC entry 174 (class 1259 OID 16424)
-- Name: password_changes_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE password_changes_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.password_changes_id_seq OWNER TO postgres;

--
-- TOC entry 2082 (class 0 OID 0)
-- Dependencies: 174
-- Name: password_changes_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE password_changes_id_seq OWNED BY password_changes.id;


--
-- TOC entry 177 (class 1259 OID 16432)
-- Name: permissions; Type: TABLE; Schema: public; Owner: postgres; Tablespace:
--

CREATE TABLE permissions (
    id integer NOT NULL,
    "profilesId" integer NOT NULL,
    resource character varying(16) NOT NULL,
    action character varying(16) NOT NULL
);


ALTER TABLE public.permissions OWNER TO postgres;

--
-- TOC entry 176 (class 1259 OID 16430)
-- Name: permissions_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE permissions_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.permissions_id_seq OWNER TO postgres;

--
-- TOC entry 2083 (class 0 OID 0)
-- Dependencies: 176
-- Name: permissions_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE permissions_id_seq OWNED BY permissions.id;


--
-- TOC entry 179 (class 1259 OID 16438)
-- Name: profiles; Type: TABLE; Schema: public; Owner: postgres; Tablespace:
--

CREATE TABLE profiles (
    id integer NOT NULL,
    name character varying(64) NOT NULL,
    active character(1) NOT NULL
);


ALTER TABLE public.profiles OWNER TO postgres;

--
-- TOC entry 178 (class 1259 OID 16436)
-- Name: profiles_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE profiles_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.profiles_id_seq OWNER TO postgres;

--
-- TOC entry 2084 (class 0 OID 0)
-- Dependencies: 178
-- Name: profiles_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE profiles_id_seq OWNED BY profiles.id;


--
-- TOC entry 181 (class 1259 OID 16444)
-- Name: remember_tokens; Type: TABLE; Schema: public; Owner: postgres; Tablespace:
--

CREATE TABLE remember_tokens (
    id integer NOT NULL,
    "usersId" integer NOT NULL,
    token character(32) NOT NULL,
    "userAgent" text NOT NULL,
    "createdAt" integer NOT NULL
);


ALTER TABLE public.remember_tokens OWNER TO postgres;

--
-- TOC entry 180 (class 1259 OID 16442)
-- Name: remember_tokens_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE remember_tokens_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.remember_tokens_id_seq OWNER TO postgres;

--
-- TOC entry 2085 (class 0 OID 0)
-- Dependencies: 180
-- Name: remember_tokens_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE remember_tokens_id_seq OWNED BY remember_tokens.id;


--
-- TOC entry 183 (class 1259 OID 16450)
-- Name: reset_passwords; Type: TABLE; Schema: public; Owner: postgres; Tablespace:
--

CREATE TABLE reset_passwords (
    id integer NOT NULL,
    "usersId" integer NOT NULL,
    code character varying(48) NOT NULL,
    "createdAt" integer NOT NULL,
    "modifiedAt" integer,
    reset character(1) NOT NULL
);


ALTER TABLE public.reset_passwords OWNER TO postgres;

--
-- TOC entry 182 (class 1259 OID 16448)
-- Name: reset_passwords_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE reset_passwords_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.reset_passwords_id_seq OWNER TO postgres;

--
-- TOC entry 2086 (class 0 OID 0)
-- Dependencies: 182
-- Name: reset_passwords_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE reset_passwords_id_seq OWNED BY reset_passwords.id;


--
-- TOC entry 185 (class 1259 OID 16456)
-- Name: success_logins; Type: TABLE; Schema: public; Owner: postgres; Tablespace:
--

CREATE TABLE success_logins (
    id integer NOT NULL,
    "usersId" integer NOT NULL,
    "ipAddress" character(15) NOT NULL,
    "userAgent" text NOT NULL
);


ALTER TABLE public.success_logins OWNER TO postgres;

--
-- TOC entry 184 (class 1259 OID 16454)
-- Name: success_logins_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE success_logins_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.success_logins_id_seq OWNER TO postgres;

--
-- TOC entry 2087 (class 0 OID 0)
-- Dependencies: 184
-- Name: success_logins_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE success_logins_id_seq OWNED BY success_logins.id;


--
-- TOC entry 187 (class 1259 OID 16462)
-- Name: users; Type: TABLE; Schema: public; Owner: postgres; Tablespace:
--

CREATE TABLE users (
    id integer NOT NULL,
    name character varying(255) NOT NULL,
    email character varying(255) NOT NULL,
    password character(60) NOT NULL,
    "mustChangePassword" character(1) DEFAULT NULL::bpchar,
    "profilesId" integer NOT NULL,
    banned character(1) NOT NULL,
    suspended character(1) NOT NULL,
    active character(1) DEFAULT NULL::bpchar
);


ALTER TABLE public.users OWNER TO postgres;

--
-- TOC entry 186 (class 1259 OID 16460)
-- Name: users_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.users_id_seq OWNER TO postgres;

--
-- TOC entry 2088 (class 0 OID 0)
-- Dependencies: 186
-- Name: users_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE users_id_seq OWNED BY users.id;


--
-- TOC entry 1908 (class 2604 OID 16414)
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY email_confirmations ALTER COLUMN id SET DEFAULT nextval('email_confirmations_id_seq'::regclass);


--
-- TOC entry 1910 (class 2604 OID 16423)
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY failed_logins ALTER COLUMN id SET DEFAULT nextval('failed_logins_id_seq'::regclass);


--
-- TOC entry 1911 (class 2604 OID 16429)
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY password_changes ALTER COLUMN id SET DEFAULT nextval('password_changes_id_seq'::regclass);


--
-- TOC entry 1912 (class 2604 OID 16435)
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY permissions ALTER COLUMN id SET DEFAULT nextval('permissions_id_seq'::regclass);


--
-- TOC entry 1913 (class 2604 OID 16441)
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY profiles ALTER COLUMN id SET DEFAULT nextval('profiles_id_seq'::regclass);


--
-- TOC entry 1914 (class 2604 OID 16447)
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY remember_tokens ALTER COLUMN id SET DEFAULT nextval('remember_tokens_id_seq'::regclass);


--
-- TOC entry 1915 (class 2604 OID 16453)
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY reset_passwords ALTER COLUMN id SET DEFAULT nextval('reset_passwords_id_seq'::regclass);


--
-- TOC entry 1916 (class 2604 OID 16459)
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY success_logins ALTER COLUMN id SET DEFAULT nextval('success_logins_id_seq'::regclass);


--
-- TOC entry 1917 (class 2604 OID 16465)
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY users ALTER COLUMN id SET DEFAULT nextval('users_id_seq'::regclass);


--
-- TOC entry 2054 (class 0 OID 16411)
-- Dependencies: 171
-- Data for Name: email_confirmations; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- TOC entry 2089 (class 0 OID 0)
-- Dependencies: 170
-- Name: email_confirmations_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('email_confirmations_id_seq', 1, false);


--
-- TOC entry 2056 (class 0 OID 16420)
-- Dependencies: 173
-- Data for Name: failed_logins; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- TOC entry 2090 (class 0 OID 0)
-- Dependencies: 172
-- Name: failed_logins_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('failed_logins_id_seq', 1, false);


--
-- TOC entry 2058 (class 0 OID 16426)
-- Dependencies: 175
-- Data for Name: password_changes; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- TOC entry 2091 (class 0 OID 0)
-- Dependencies: 174
-- Name: password_changes_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('password_changes_id_seq', 1, false);


--
-- TOC entry 2060 (class 0 OID 16432)
-- Dependencies: 177
-- Data for Name: permissions; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO permissions VALUES (1, 3, 'users', 'index');
INSERT INTO permissions VALUES (2, 3, 'users', 'search');
INSERT INTO permissions VALUES (3, 3, 'profiles', 'index');
INSERT INTO permissions VALUES (4, 3, 'profiles', 'search');
INSERT INTO permissions VALUES (5, 1, 'users', 'index');
INSERT INTO permissions VALUES (6, 1, 'users', 'search');
INSERT INTO permissions VALUES (7, 1, 'users', 'edit');
INSERT INTO permissions VALUES (8, 1, 'users', 'create');
INSERT INTO permissions VALUES (9, 1, 'users', 'delete');
INSERT INTO permissions VALUES (10, 1, 'users', 'changePassword');
INSERT INTO permissions VALUES (11, 1, 'profiles', 'index');
INSERT INTO permissions VALUES (12, 1, 'profiles', 'search');
INSERT INTO permissions VALUES (13, 1, 'profiles', 'edit');
INSERT INTO permissions VALUES (14, 1, 'profiles', 'create');
INSERT INTO permissions VALUES (15, 1, 'profiles', 'delete');
INSERT INTO permissions VALUES (16, 1, 'permissions', 'index');
INSERT INTO permissions VALUES (17, 2, 'users', 'index');
INSERT INTO permissions VALUES (18, 2, 'users', 'search');
INSERT INTO permissions VALUES (19, 2, 'users', 'edit');
INSERT INTO permissions VALUES (20, 2, 'users', 'create');
INSERT INTO permissions VALUES (21, 2, 'profiles', 'index');
INSERT INTO permissions VALUES (22, 2, 'profiles', 'search');


--
-- TOC entry 2092 (class 0 OID 0)
-- Dependencies: 176
-- Name: permissions_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('permissions_id_seq', 1, false);


--
-- TOC entry 2062 (class 0 OID 16438)
-- Dependencies: 179
-- Data for Name: profiles; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO profiles VALUES (1, 'Administrators', 'Y');
INSERT INTO profiles VALUES (2, 'Users', 'Y');
INSERT INTO profiles VALUES (3, 'Read-Only', 'Y');


--
-- TOC entry 2093 (class 0 OID 0)
-- Dependencies: 178
-- Name: profiles_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('profiles_id_seq', 1, false);


--
-- TOC entry 2064 (class 0 OID 16444)
-- Dependencies: 181
-- Data for Name: remember_tokens; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- TOC entry 2094 (class 0 OID 0)
-- Dependencies: 180
-- Name: remember_tokens_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('remember_tokens_id_seq', 1, false);


--
-- TOC entry 2066 (class 0 OID 16450)
-- Dependencies: 183
-- Data for Name: reset_passwords; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- TOC entry 2095 (class 0 OID 0)
-- Dependencies: 182
-- Name: reset_passwords_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('reset_passwords_id_seq', 1, false);


--
-- TOC entry 2068 (class 0 OID 16456)
-- Dependencies: 185
-- Data for Name: success_logins; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- TOC entry 2096 (class 0 OID 0)
-- Dependencies: 184
-- Name: success_logins_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('success_logins_id_seq', 1, false);


--
-- TOC entry 2070 (class 0 OID 16462)
-- Dependencies: 187
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO users VALUES (1, 'Bob Burnquist', 'bob@phalconphp.com', '$2a$08$Lx1577KNhPa9lzFYKssadetmbhaveRtCoVaOnoXXxUIhrqlCJYWCW', 'N', 1, 'N', 'N', 'Y');
INSERT INTO users VALUES (2, 'Erik', 'erik@phalconphp.com', '$2a$08$f4llgFQQnhPKzpGmY1sOuuu23nYfXYM/EVOpnjjvAmbxxDxG3pbX.', 'N', 1, 'Y', 'Y', 'Y');
INSERT INTO users VALUES (3, 'Veronica', 'veronica@phalconphp.com', '$2a$08$NQjrh9fKdMHSdpzhMj0xcOSwJQwMfpuDMzgtRyA89ADKUbsFZ94C2', 'N', 1, 'N', 'N', 'Y');
INSERT INTO users VALUES (4, 'Yukimi Nagano', 'yukimi@phalconphp.com', '$2a$08$cxxpy4Jvt6Q3xGKgMWIILuf75RQDSroenvoB7L..GlXoGkVEMoSr.', 'N', 2, 'N', 'N', 'Y');


--
-- TOC entry 2097 (class 0 OID 0)
-- Dependencies: 186
-- Name: users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('users_id_seq', 1, false);


--
-- TOC entry 1921 (class 2606 OID 16417)
-- Name: email_confirmations_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace:
--

ALTER TABLE ONLY email_confirmations
    ADD CONSTRAINT email_confirmations_pkey PRIMARY KEY (id);


--
-- TOC entry 1923 (class 2606 OID 16473)
-- Name: failed_logins_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace:
--

ALTER TABLE ONLY failed_logins
    ADD CONSTRAINT failed_logins_pkey PRIMARY KEY (id);


--
-- TOC entry 1925 (class 2606 OID 16475)
-- Name: password_changes_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace:
--

ALTER TABLE ONLY password_changes
    ADD CONSTRAINT password_changes_pkey PRIMARY KEY (id);


--
-- TOC entry 1927 (class 2606 OID 16477)
-- Name: permissions_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace:
--

ALTER TABLE ONLY permissions
    ADD CONSTRAINT permissions_pkey PRIMARY KEY (id);


--
-- TOC entry 1929 (class 2606 OID 16479)
-- Name: profiles_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace:
--

ALTER TABLE ONLY profiles
    ADD CONSTRAINT profiles_pkey PRIMARY KEY (id);


--
-- TOC entry 1931 (class 2606 OID 16481)
-- Name: remember_tokens_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace:
--

ALTER TABLE ONLY remember_tokens
    ADD CONSTRAINT remember_tokens_pkey PRIMARY KEY (id);


--
-- TOC entry 1933 (class 2606 OID 16483)
-- Name: reset_passwords_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace:
--

ALTER TABLE ONLY reset_passwords
    ADD CONSTRAINT reset_passwords_pkey PRIMARY KEY (id);


--
-- TOC entry 1935 (class 2606 OID 16485)
-- Name: success_logins_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace:
--

ALTER TABLE ONLY success_logins
    ADD CONSTRAINT success_logins_pkey PRIMARY KEY (id);


--
-- TOC entry 1937 (class 2606 OID 16487)
-- Name: users_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace:
--

ALTER TABLE ONLY users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- TOC entry 1938 (class 2606 OID 16488)
-- Name: email_confirmations_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY email_confirmations
    ADD CONSTRAINT email_confirmations_fk FOREIGN KEY ("usersId") REFERENCES users(id);


--
-- TOC entry 1939 (class 2606 OID 16493)
-- Name: failed_logins_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY failed_logins
    ADD CONSTRAINT failed_logins_fk FOREIGN KEY ("usersId") REFERENCES users(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 1940 (class 2606 OID 16498)
-- Name: password_changes_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY password_changes
    ADD CONSTRAINT password_changes_fk FOREIGN KEY ("usersId") REFERENCES users(id);


--
-- TOC entry 1941 (class 2606 OID 16503)
-- Name: permissions_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY permissions
    ADD CONSTRAINT permissions_fk FOREIGN KEY ("profilesId") REFERENCES profiles(id);


--
-- TOC entry 1942 (class 2606 OID 16508)
-- Name: remember_tokens_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY remember_tokens
    ADD CONSTRAINT remember_tokens_fk FOREIGN KEY ("usersId") REFERENCES users(id);


--
-- TOC entry 1943 (class 2606 OID 16513)
-- Name: reset_passwords_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY reset_passwords
    ADD CONSTRAINT reset_passwords_fk FOREIGN KEY ("usersId") REFERENCES users(id);


--
-- TOC entry 1944 (class 2606 OID 16518)
-- Name: success_logins_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY success_logins
    ADD CONSTRAINT success_logins_fk FOREIGN KEY ("usersId") REFERENCES users(id);


--
-- TOC entry 1945 (class 2606 OID 16523)
-- Name: users_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY users
    ADD CONSTRAINT users_fk FOREIGN KEY ("profilesId") REFERENCES profiles(id);


--
-- TOC entry 2078 (class 0 OID 0)
-- Dependencies: 5
-- Name: public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


-- Completed on 2014-12-16 09:40:50 EAT

--
-- PostgreSQL database dump complete
--


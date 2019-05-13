--
-- PostgreSQL database dump
--

-- Dumped from database version 11.1
-- Dumped by pg_dump version 11.1

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: article; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.article (
    id_article integer NOT NULL,
    titre character varying(100) NOT NULL,
    texte character varying(10000) NOT NULL,
    id_membre integer NOT NULL,
    date date NOT NULL,
    compte_rendu boolean DEFAULT false
);


ALTER TABLE public.article OWNER TO postgres;

--
-- Name: article_id_article_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.article_id_article_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.article_id_article_seq OWNER TO postgres;

--
-- Name: article_id_article_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.article_id_article_seq OWNED BY public.article.id_article;


--
-- Name: equipe; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.equipe (
    id_jeu integer NOT NULL,
    id_membre integer NOT NULL,
    role character varying(30)
);


ALTER TABLE public.equipe OWNER TO postgres;

--
-- Name: jeux; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.jeux (
    id_jeu integer NOT NULL,
    titre character varying(50) NOT NULL,
    git character varying(100),
    telechargement character varying(100),
    description character varying(10000)
);


ALTER TABLE public.jeux OWNER TO postgres;

--
-- Name: jeux_id_jeu_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.jeux_id_jeu_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.jeux_id_jeu_seq OWNER TO postgres;

--
-- Name: jeux_id_jeu_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.jeux_id_jeu_seq OWNED BY public.jeux.id_jeu;


--
-- Name: media; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.media (
    id_media integer NOT NULL,
    id_jeu integer,
    id_maj integer,
    id_article integer,
    id_membre integer,
    lien character varying(200),
    CONSTRAINT only_one_id CHECK ((((id_jeu IS NOT NULL) AND (id_maj IS NULL) AND (id_article IS NULL) AND (id_membre IS NULL)) OR ((id_jeu IS NULL) AND (id_maj IS NOT NULL) AND (id_article IS NULL) AND (id_membre IS NULL)) OR ((id_jeu IS NULL) AND (id_maj IS NULL) AND (id_article IS NOT NULL) AND (id_membre IS NULL)) OR ((id_jeu IS NULL) AND (id_maj IS NULL) AND (id_article IS NULL) AND (id_membre IS NOT NULL))))
);


ALTER TABLE public.media OWNER TO postgres;

--
-- Name: media_id_media_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.media_id_media_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.media_id_media_seq OWNER TO postgres;

--
-- Name: media_id_media_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.media_id_media_seq OWNED BY public.media.id_media;


--
-- Name: membre; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.membre (
    id_membre integer NOT NULL,
    nom character varying(50),
    prenom character varying(50),
    surnom character varying(50) NOT NULL,
    password character varying(72) NOT NULL,
    promo integer,
    role character varying(20)
);


ALTER TABLE public.membre OWNER TO postgres;

--
-- Name: membre_id_membre_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.membre_id_membre_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.membre_id_membre_seq OWNER TO postgres;

--
-- Name: membre_id_membre_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.membre_id_membre_seq OWNED BY public.membre.id_membre;


--
-- Name: miseajour; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.miseajour (
    id_maj integer NOT NULL,
    id_jeu integer NOT NULL,
    texte character varying(10000),
    date date NOT NULL
);


ALTER TABLE public.miseajour OWNER TO postgres;

--
-- Name: miseajour_id_maj_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.miseajour_id_maj_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.miseajour_id_maj_seq OWNER TO postgres;

--
-- Name: miseajour_id_maj_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.miseajour_id_maj_seq OWNED BY public.miseajour.id_maj;


--
-- Name: tuto; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tuto (
    id_tuto integer NOT NULL,
    titre character varying(100) NOT NULL,
    texte character varying(1000),
    pdf character varying(100) NOT NULL
);


ALTER TABLE public.tuto OWNER TO postgres;

--
-- Name: tuto_id_tuto_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tuto_id_tuto_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tuto_id_tuto_seq OWNER TO postgres;

--
-- Name: tuto_id_tuto_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tuto_id_tuto_seq OWNED BY public.tuto.id_tuto;


--
-- Name: article id_article; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.article ALTER COLUMN id_article SET DEFAULT nextval('public.article_id_article_seq'::regclass);


--
-- Name: jeux id_jeu; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.jeux ALTER COLUMN id_jeu SET DEFAULT nextval('public.jeux_id_jeu_seq'::regclass);


--
-- Name: media id_media; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.media ALTER COLUMN id_media SET DEFAULT nextval('public.media_id_media_seq'::regclass);


--
-- Name: membre id_membre; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.membre ALTER COLUMN id_membre SET DEFAULT nextval('public.membre_id_membre_seq'::regclass);


--
-- Name: miseajour id_maj; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.miseajour ALTER COLUMN id_maj SET DEFAULT nextval('public.miseajour_id_maj_seq'::regclass);


--
-- Name: tuto id_tuto; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tuto ALTER COLUMN id_tuto SET DEFAULT nextval('public.tuto_id_tuto_seq'::regclass);


--
-- Data for Name: article; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.article VALUES (1, 'RealitIIE , ou l''assos qui ne fait pas que de la VR!', 'On ne fait pas que de la VR!!! On ne fait pas que de la VR!!!On ne fait pas que de la VR!!!On ne fait pas que de la VR!!!On ne fait pas que de la VR!!!On ne fait pas que de la VR!!!On ne fait pas que de la VR!!!On ne fait pas que de la VR!!!On ne fait pas que de la VR!!!On ne fait pas que de la VR!!!On ne fait pas que de la VR!!!On ne fait pas que de la VR!!!On ne fait pas que de la VR!!!On ne fait pas que de la VR!!!On ne fait pas que de la VR!!!On ne fait pas que de la VR!!!On ne fait pas que de la VR!!!On ne fait pas que de la VR!!!', 4, '2019-05-12', false);
INSERT INTO public.article VALUES (6, 'Pourquoi il faut interdire Carapuce!', '<p>Carapuce est un cancer. C''est suffisant pour l’interdire.</p>', 4, '2019-05-12', false);
INSERT INTO public.article VALUES (5, 'Organisation de l''année 2019-2020', '<p>Pas le temps de voir, on a des projets à finir!!!</p>

<h1>Panique!!!!</h1>', 4, '2019-05-12', false);
INSERT INTO public.article VALUES (2, 'Compte-rendu _/_/2018', '<p> Présentation de l’asso pour les nouveaux inscrits avec un message important 
à transmettre à tous : ”ON NE FAIT PAS QUE DE LA VR”. L’association souffre également 
d’un manque cruel d’artistes : des graphistes et pros du Blender. Si vous aimez les jeux viendez, 
on trouvera bien quelque chose pour vous occuper. </p> 

<p> Présentation également du nouveau bureau : 
<ul>
<li> Le président dictateur Altreon </li>
<li> Le trésorier malhonnête Jalik </li>
<li> Le secrétaire inutile DBA3 </li>
</ul>
</p> 



<p> Opinions sur le semestre 1 :  Pas assez de concret dans les objectifs de l’asso. 
Certains proposent d’organiser des démos des jeux réalisés en NJV. </p> 

<p> Opinions sur le semestre 2 : Intérêt prononcé pour la participation à une 
Game Jam (au moins une dizaine de personnes intéressés.). Pour pallier au manque 
de visibilité de Realitiie, le président et son équipe se proposent à créer un espace 
sur internet pour permettre le téléchargement des jeux réalisés dans l’association. 
Jalik, est également prêt à nous aider à aider pour organiser des expo CR durant les NJV. </p> 

</p>

<p> De par son infinie générosité, Deurstann propose de nous céder son  casque VR, (merci Deurstann). 

<p> La question de la visibilité de l’association se pose : Plusieurs solutions sont proposées,
voici les plus pertinentes : 

<ul>
 <li>Rénovation de l’ancien site de l’association  </li>
 <li>Trailer à faire passer pendant les proj, pour annoncer haut et fort ”ON NE FAIT PAS QUE DE LA VR” </li>
<li>Rédaction d’un article sur l’IIEmonde </li>
</ul>

</p>

<p> Les projet en cours:  Deux équipes travaillent encore sur 
leurs propres projets. Un RTS “zombie” et un hovercraft. 
</p>', 6, '2018-11-23', true);
INSERT INTO public.article VALUES (3, 'Compte rendu 25/04/2019', '<p>Première Réunion post Laval L’équipe envoyée :(Plou ,Prophet,Wikle,Zaphkiel)</p>

<p>Commentaires de Plou : « L’ENSIIE est la seule école à avoir envoyé des débutants»
	Proposition de changer les règles lors de la formtion des équipes : envoyer une équipe de 2As ou 
	encore les 1As  les plus compétents. Cela laissera plus de temps au nouveaux arrivant de s’entraîner, 
	et de se familiariser avec le matériel. Il faudra pour cela organiser un calendrier clair des formations .
</p>

<p>
	Dépenses à régler en cours, la consommation durant la Game Jam est remboursée.
	</p>

<p>
-Préparation des évènements futurs :
<ul>
	<li>NJV, organiser un stand RealitIIE,</li>
	<li>Proposition de Fiietz : réalisation sur le vif d’un projet pendant la NJV.</li>
	<li>HTC Vive, contraignant dans l’utilisation, réflexion  sur les détecteurs
	en cas d''utilisation dans</li>
</ul>
</p>

<p>
-Amélioration de l’image de l’association :
	<li>Ateliers proposés dans l’école rémunéré, ex(tutoriels basiques pour débutant)</li>
	<li>Ateliers pour Déclic rémunérés</li>
	<li>Proposition de changer le nom de l’association : plusieurs membres d’accord,
	mais pas sur le nom. La raison invoquée est le manque d’adéquation entre le nom de 
	l’association et son but. La réalité virtuelle n’étant plus le seul cadre d’activité proposées.</li>
	<li>Comme proposé à la dernière réunion le site est en restructuration dans le cadre du projet Web.</li>
	<li>Pour annoncer le changement de nom, certains proposent de réaliser une vidéo,</li>
	<li>Altreon, Rhum et 801 proposent de créer une banque d’assets Unity dans le site.</li>
</p>

<p>
Achat de Matériel
	Une manette du HTC VIVE nous a lâché récemment, il faudra donc penser à prévenir 
	le CRI ou le C19 . Ou encore acheter nos propres manettes avec le budget de l’association.</br>
	Le casque offert par Deustann est également incomplet, et comme propriété de l’association, 
	c’est à nous que revient le privilège d’acheter ce qui manque : notamment une protection en mousse et des manettes.
	Rhum nous a annoncé que dû à la non  000 euros dans le budget pour l’année prochaine
	</p>

	
<p>
Jeu prposé pour le Laval démo :Hervé le voleur RV
	Idée présentée par 801 et Rhum, un jeu d’infiltration où le but est de voler une œuvre d’art, 
	en utilisant des gadget  pour résoudre des puzzle en temps limité .
	</p>', 6, '2019-04-25', true);
INSERT INTO public.article VALUES (4, 'compte-rendu 02/05/2019', '<p>Information officielle l’actuel président Altreon part au Canada pour le S3, 
l’absence du président signifie qu’il fut élire un nouveau président. Deux membres 
se présentent au poste de président : Plou et Fiietz.
</p>

<p>
Les résultats du vote :            PLOU :   6              FIIETS : 3   </br>

Plou devient alors le nouveau président de l’association, à la tête de l’actuel bureau.
</p>


<p>
Détail pour la passation de la présidence : 
<ul>
<li>Plou devra recevoir de Tartare les droits d’administrateur 
sur le Discord de Realitiie mais également l''accès au compte SteamVR réservé 
aux membres de l’association.</li>
<li>On rappelle que le budget disponible  est de 450 € en 
plus du budget offert par le BDE. </li>
<li>L’achat de la memande manquante n’ayant toujours pas été fait, 
il faudra renouveler la demande au C19.</li>
</ul>


<p>
Pour la démo Laval 2020 , 801 partage son avis : « l’idée du projet est bien 
mais le problème du déplacement se pose ». Le jeu étant en VR l’immersion est perdue s’il faut 
se déplacer avec les manettes, et considérant les dimensions du jeu à réaliser, le déplacement ne peut 
pas se faire sur une distance limitée.   </br>
Rhum propose une idée: réaliser un jeu différent et mettre des capteurs sur un vélo et permettre donc au 
joueur de se déplacer suivant la rotation des roue. 
</p>

<p>
Pour Laval Virtual les membres de l’association sont d’accord pour envoyer les plus motivés,
 801 propose de demander des rendus après chaque tutoriel pour sélectionner les meilleurs.   
 Jalik propose que l’association fasse un tuto toutes les 2 semaines .
 Pour Laval 2020, Plou prévient qu’il faudra envoyer une équipe avec le casque VR, pour éviter de partager le matériel avec les autres participants.
</p>', 6, '2019-05-02', true);


--
-- Data for Name: equipe; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.equipe VALUES (1, 4, 'Dev & mod‚lisateur');
INSERT INTO public.equipe VALUES (2, 4, 'mod‚lisateur');
INSERT INTO public.equipe VALUES (2, 8, 'Developpeur');
INSERT INTO public.equipe VALUES (2, 9, 'Developpeur');


--
-- Data for Name: jeux; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.jeux VALUES (2, 'Restroom', NULL, 'Restroom.rar', NULL);
INSERT INTO public.jeux VALUES (3, 'Overcraft', '', '', NULL);
INSERT INTO public.jeux VALUES (1, 'Fight for the Door', ' ', 'fight_door.rar', NULL);
INSERT INTO public.jeux VALUES (4, 'Projet Piratage', '.', '.', '.');


--
-- Data for Name: media; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.media VALUES (1, NULL, NULL, NULL, 3, 'Altreon.png');


--
-- Data for Name: membre; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.membre VALUES (7, 'MACARIT', 'Jean-Loup', 'Plou', '$2y$10$kUM1m4nTDoBpIB7Jlow9EuBaYefr2RrUsAzUMeoos03fVYo2wgEUK', 2021, 'a');
INSERT INTO public.membre VALUES (8, 'PILLONEL', 'Matthis', '801', '$2y$10$f9BWBlatXL8dVH4sukt3MO3h258.W5zUTz6bNajWHBegI7pz4gOoq', 2020, 'r');
INSERT INTO public.membre VALUES (9, 'RIOUST', 'Lucas', 'Rhum', '$2y$10$fREIWObCRhh6Ta78sEXxDO5lw4BojEFIrqEujdfvJyrMUBEMcbxs6', 2020, 'r');
INSERT INTO public.membre VALUES (10, 'DUBARD', 'Loïc', 'Wikle', '$2y$10$R1BCy4MDZBdoIdIU62Fe7uu2OhW0d9C3HLrwLTR1cIb2ZqCPsf49W', 2021, 'r');
INSERT INTO public.membre VALUES (11, 'GABBAY', 'Milan', 'Jalik', '$2y$10$MxyToqUssyvDpEt2IbgJa.rdwmvfCHcc7c4q.BcXjOP1DmhrrYFtS', 2021, 'a');
INSERT INTO public.membre VALUES (4, 'VAN DER LEE', 'Rémi', 'fIIEts', '$2y$10$xnTJkXZ2CwPn52k/cxn4Xub9Lpk7GXQ9GWCMA0gVXmn9tieUT.77W', 2021, 'a');
INSERT INTO public.membre VALUES (3, 'BRANDI', 'Matteo', 'Altreon', '$2y$10$IyMJ5ciGxqwsaXc.Ws.KOuTift.uxkQ2f6wYJH7Rr4u.p7lDd4GuS', 2021, 'a');
INSERT INTO public.membre VALUES (6, 'ACHEROUFKEBIR', 'Yacine', 'DBA3', '$2y$10$.O1wReDPzxyo2mXVs3jbke4IXTodibdIlTa/t1HJGWt2Q.UdKDo7O', 2021, 'a');
INSERT INTO public.membre VALUES (12, 'INACO', 'Aurélien', 'Prophet', '$2y$10$tv7Xj9KponvVA70oiMZtg.9lGJEpmeU6r87u/XXvWXGqnCL.dSMRW', 2021, 'r');
INSERT INTO public.membre VALUES (13, 'MONNOT', 'Clément', 'Zaphkiel', '$2y$10$dlr6YKuALNktSx4ClknvS..z8hD0t0sRmMARYNKfqOaEx1RR9OPcq', 2021, 'r');


--
-- Data for Name: miseajour; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.miseajour VALUES (2, 1, 'Fin de la scène de départ! Ajout d''un deuxième niveau en cours. Il se passe devant un château et sur ces murailles. Ajout de la commande d action sur les deux personnages avec les touches E pour J1 et . pour J2.', '2019-02-01');
INSERT INTO public.miseajour VALUES (4, 3, 'Il faudrait que je pense à utiliser mes propres modèle 3D et nous ceux volés. Pour ça je recherche des gens fort en modélisation pour les exploiter 20h/jour sans pause (et sans les payer bien sur) afin de réaliser cette tâche ingrate.', '2019-05-13');
INSERT INTO public.miseajour VALUES (6, 3, 'Correction de l''IA. Il est maintenant plus performant, ne se prend plus les murs mais est bien trop fort pour être battu!', '2019-03-13');
INSERT INTO public.miseajour VALUES (3, 1, 'Projet un peu à l''arrêt à cause des projets de l''école mais je reprend dès la fin des cours soit mi-juin.
Au programme :
- Finir le 1er niveau en design
- Ajouter un compteur de point avec le bon affichage qui va bien
(- Commencer un autre niveau?)', '2019-05-13');


--
-- Data for Name: tuto; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.tuto VALUES (1, '[BLENDER] Squelettisation', 'Apprendre … ins‚erer un squelette sur un modŠle pour l animer.', 'squelettisation.pdf');
INSERT INTO public.tuto VALUES (2, '[Noob] Comment démarrer son pc', 'Enfin c''est simple...', 'noob.pdf');


--
-- Name: article_id_article_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.article_id_article_seq', 6, true);


--
-- Name: jeux_id_jeu_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.jeux_id_jeu_seq', 4, true);


--
-- Name: media_id_media_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.media_id_media_seq', 1, true);


--
-- Name: membre_id_membre_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.membre_id_membre_seq', 13, true);


--
-- Name: miseajour_id_maj_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.miseajour_id_maj_seq', 6, true);


--
-- Name: tuto_id_tuto_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tuto_id_tuto_seq', 2, true);


--
-- Name: article article_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.article
    ADD CONSTRAINT article_pkey PRIMARY KEY (id_article);


--
-- Name: article article_titre_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.article
    ADD CONSTRAINT article_titre_key UNIQUE (titre);


--
-- Name: equipe equipe_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.equipe
    ADD CONSTRAINT equipe_pkey PRIMARY KEY (id_jeu, id_membre);


--
-- Name: jeux jeux_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.jeux
    ADD CONSTRAINT jeux_pkey PRIMARY KEY (id_jeu);


--
-- Name: jeux jeux_titre_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.jeux
    ADD CONSTRAINT jeux_titre_key UNIQUE (titre);


--
-- Name: media media_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.media
    ADD CONSTRAINT media_pkey PRIMARY KEY (id_media);


--
-- Name: membre membre_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.membre
    ADD CONSTRAINT membre_pkey PRIMARY KEY (id_membre);


--
-- Name: miseajour miseajour_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.miseajour
    ADD CONSTRAINT miseajour_pkey PRIMARY KEY (id_maj, id_jeu);


--
-- Name: tuto tuto_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tuto
    ADD CONSTRAINT tuto_pkey PRIMARY KEY (id_tuto);


--
-- Name: tuto tuto_titre_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tuto
    ADD CONSTRAINT tuto_titre_key UNIQUE (titre);


--
-- Name: membre unique_surnom; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.membre
    ADD CONSTRAINT unique_surnom UNIQUE (surnom);


--
-- Name: article article_id_membre_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.article
    ADD CONSTRAINT article_id_membre_fkey FOREIGN KEY (id_membre) REFERENCES public.membre(id_membre);


--
-- Name: equipe equipe_id_jeu_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.equipe
    ADD CONSTRAINT equipe_id_jeu_fkey FOREIGN KEY (id_jeu) REFERENCES public.jeux(id_jeu);


--
-- Name: equipe equipe_id_membre_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.equipe
    ADD CONSTRAINT equipe_id_membre_fkey FOREIGN KEY (id_membre) REFERENCES public.membre(id_membre);


--
-- Name: media media_id_article_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.media
    ADD CONSTRAINT media_id_article_fkey FOREIGN KEY (id_article) REFERENCES public.article(id_article);


--
-- Name: media media_id_maj_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.media
    ADD CONSTRAINT media_id_maj_fkey FOREIGN KEY (id_maj, id_jeu) REFERENCES public.miseajour(id_maj, id_jeu);


--
-- Name: media media_id_membre_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.media
    ADD CONSTRAINT media_id_membre_fkey FOREIGN KEY (id_membre) REFERENCES public.membre(id_membre);


--
-- Name: miseajour miseajour_id_jeu_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.miseajour
    ADD CONSTRAINT miseajour_id_jeu_fkey FOREIGN KEY (id_jeu) REFERENCES public.jeux(id_jeu);


--
-- PostgreSQL database dump complete
--


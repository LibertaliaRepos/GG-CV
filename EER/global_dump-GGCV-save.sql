-- MySQL dump 10.13  Distrib 5.7.26, for Linux (x86_64)
--
-- Host: 192.168.10.1    Database: GGCV
-- ------------------------------------------------------
-- Server version	5.7.26

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `Society`
--

DROP TABLE IF EXISTS `Society`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Society` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contact_id` int(11) NOT NULL,
  `society_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_C2D9586EE7A1254A` (`contact_id`),
  CONSTRAINT `FK_C2D9586EE7A1254A` FOREIGN KEY (`contact_id`) REFERENCES `contact` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Society`
--

LOCK TABLES `Society` WRITE;
/*!40000 ALTER TABLE `Society` DISABLE KEYS */;
INSERT INTO `Society` VALUES (1,1,'Ggcv'),(2,2,'GG-CV'),(3,3,'GG-CV'),(4,4,'GG-CV');
/*!40000 ALTER TABLE `Society` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `author`
--

DROP TABLE IF EXISTS `author`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `author` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contact_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_BDAFD8C8E7A1254A` (`contact_id`),
  CONSTRAINT `FK_BDAFD8C8E7A1254A` FOREIGN KEY (`contact_id`) REFERENCES `contact` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `author`
--

LOCK TABLES `author` WRITE;
/*!40000 ALTER TABLE `author` DISABLE KEYS */;
INSERT INTO `author` VALUES (1,1,'Gandner'),(2,2,'Gandner'),(3,3,'Gandner'),(4,4,'GANDNER'),(5,5,'Gandner');
/*!40000 ALTER TABLE `author` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contact`
--

DROP TABLE IF EXISTS `contact`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contact` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `datetime` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contact`
--

LOCK TABLES `contact` WRITE;
/*!40000 ALTER TABLE `contact` DISABLE KEYS */;
INSERT INTO `contact` VALUES (1,'gillesgandner@gmail.com','Test depuis portable','<p>Ceci est un test depuis mon portable</p>','2018-11-19 18:26:40'),(2,'gillesgandner@gmail.com','Test emailing','<p>test azertyuioqsdfghjk</p>','2018-12-29 17:48:30'),(3,'gillesgandner@gmail.com','Test d\'un e-mail 2','<p>zqewsxrdctfvghubjnkxdctfvygbj,kluctdfvgb,&ugrave;klutxdcfyvguhbijno,&ugrave;kibhinjo,k</p>','2018-12-29 17:50:58'),(4,'gilles.gandner.auditeur@lecnam.net','Test d\'un e-mail 3','<p>wsrxdckbesxcytuvbionwexdtfchv jbweutxrfckuvlyhbrxiyctuvlhbmjk</p>','2018-12-29 17:55:48'),(5,'gilles.gandner.auditeur@lecnam.net','Test libertalia','<p>rxdtcfyvhjbkxeucybpiontxufcvghjbkl,rxicytuvhbjnoiycirtuvhbjk,l</p>','2018-12-29 17:56:32'),(6,'gillesgandner@gmail.com','Test d\'un e-mail 5','<p>Ceci est un test email</p>','2018-12-29 18:17:30'),(7,'gilles.gandner.auditeur@lecnam.net','zertyuiopdfghjkl','<p>yrxdcfvhbjn,kxdrcfvhjb,klcfvhjb,klm</p>','2018-12-29 18:19:13'),(8,'gillesgandner@gmail.com','Test d\'un e-mail 1','<p>rsedxytcufyvguhbnijotdcfyvguhbinjoguh</p>','2019-01-04 17:00:38'),(9,'gillesgandner@gmail.com','Test d\'un e-mail 1','<p>ewsxfdcghjbnedrtfyughoji</p>','2019-01-04 17:08:43'),(10,'titi@toto.com','Test d\'un e-mail 1','<p>srdhcykbjntxdcfyvgubhinjo,kl</p>','2019-01-04 17:10:33'),(11,'gillesgandner@gmail.com','Test d\'un e-mail 1','<p>sdwfxcgkb,klm</p>','2019-01-04 17:14:44'),(12,'titi@toto.com','Test d\'un e-mail 1','<p>dtfyguhinjokplgubhnji,kl</p>','2019-01-04 17:18:19'),(13,'titi@toto.com','Test d\'un e-mail 1','<p>tdryubhojikprfyugojikp</p>','2019-01-04 17:20:36'),(14,'gillesgandner@gmail.com','Test d\'un e-mail 1','<p>rdtfcyvguhbinjo,kjfkbl</p>','2019-01-04 17:23:20'),(15,'gillesgandner@gmail.com','Test d\'un e-mail 1','<p>dciuvghbinjo,kpigpojkl</p>','2019-01-04 17:26:27'),(16,'titi@toto.com','Test d\'un e-mail 1','<p>wsxdhfckbliyugojik</p>','2019-01-04 17:39:20'),(17,'gilles.gandner.auditeur@lecnam.net','Test d\'un e-mail 1','<p>zsterydtiupojkl&icirc;gpoj</p>','2019-01-05 10:01:03'),(18,'titi@toto.com','Test d\'un e-mail 1','<p>wsdfxckblfcyvuhjb,kl</p>','2019-01-05 10:14:18'),(19,'test@email.com','Test d\'un e-mail 1','<p>rwsxdcbl,km&ugrave;</p>','2019-01-05 10:18:24'),(20,'gillesgandner@gmail.com','Test d\'un e-mail 1','<p>rwsxdtcfghjbkl</p>','2019-01-05 10:22:13'),(21,'test@email.com','Test d\'un e-mail 1','<p>xreydtucfyvgbhinjokrxicytuvbpno</p>','2019-01-05 10:23:32'),(22,'test@email.com','Test d\'un e-mail 1','<p>zeqsrdtfyuhjiokpl</p>','2019-01-07 12:12:32'),(23,'test@email.ctom','Test d\'un e-mail 1','<p>zeqsrdtfyuhjiokpl</p>','2019-01-07 12:13:48');
/*!40000 ALTER TABLE `contact` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contractType`
--

DROP TABLE IF EXISTS `contractType`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contractType` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `short_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `long_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contractType`
--

LOCK TABLES `contractType` WRITE;
/*!40000 ALTER TABLE `contractType` DISABLE KEYS */;
/*!40000 ALTER TABLE `contractType` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `images`
--

DROP TABLE IF EXISTS `images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) DEFAULT NULL,
  `filename` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_E01FBE6A166D1F9C` (`project_id`),
  CONSTRAINT `FK_E01FBE6A166D1F9C` FOREIGN KEY (`project_id`) REFERENCES `project` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=99 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `images`
--

LOCK TABLES `images` WRITE;
/*!40000 ALTER TABLE `images` DISABLE KEYS */;
INSERT INTO `images` VALUES (23,NULL,'ac4d346b8b9e86129f9f7c804e6e603d.png'),(24,NULL,'5a54cf49797b451c0af0f97b45eb0bb4.png'),(25,NULL,'fd84eb98fb0904deb80c917f3f8ae635.png'),(38,4,'4c95e1bd070fda8efff845607b9c5da0.png'),(39,4,'5cdf20f24b4e496cd04bf5ffa92f75d1.png'),(40,4,'66512aa83d4d8b4ea5d66a677ca89569.png'),(41,4,'bdb1b2d59c439e1f299877226b1dfa2e.png'),(42,4,'249a07a7ec706c04e7d2cc1e077b2af7.png'),(43,4,'2d03b73bd89e173e03343fb74b607a55.png'),(53,5,'bb657d553b2f71ae677f334b7c791790.png'),(54,5,'c6382753dff006c12035b5d923ca78e0.png'),(55,5,'12481ec4b9e7f950e999eb8e929e420f.png'),(56,5,'57bfccb9992196d1cf23b4df1b4d90df.png'),(57,5,'cd65b2e7b528abfd85cee00b62516722.png'),(58,5,'a7ac664e231156b47277cdcd2def171a.png'),(59,5,'0c6b29b43d3804f39d2450cb30e99fe8.png'),(60,5,'cfeca6d668f3ed209a85f64201059959.png'),(61,5,'cf5d8b89f2b75c89ff814204bd97c31b.png'),(62,6,'b3bc8b34ade18dacca2eda6a327a1ce7.png'),(63,6,'91354cfbba62a7f403ca170ebdad4a98.png'),(64,6,'75d0b86fe10bc1fb68f3ead8377d149f.png'),(65,6,'1490363b2e85f5252c2a1a8f5de98370.png'),(66,6,'9d988309809643e94ed23b8f2a32d6dd.png'),(67,6,'da348a802cb691e939e023ee35e6e1f0.png'),(68,6,'6c11fbbf715f1a77fada4f51ac81d3c5.png'),(69,6,'75c50bbf1d404ea8de2672180234053d.png'),(70,6,'51a865a0ab3384af95f54dc38ae4b37f.png'),(71,6,'2d9c98885027764d4ed97addff90b3a2.png'),(72,6,'f644de29c3be24b454234293f976cf9b.png'),(73,6,'77e0bf1365aa07257eaf76d17518147c.png'),(74,6,'8ef0c23d713561b64338144427cdf54d.png'),(75,6,'315d4d6acedbe7d9a7a7bbaf490cfd61.png'),(76,6,'2623db4e73b4e0c574da56f204600cfc.png'),(77,6,'e9671a7a8c548ad4152e5c087926323a.png'),(78,6,'3e2f97223fabf8196b28042fac6de254.png'),(79,6,'ce6229651236565c9f2bd7b8f7172d9e.png'),(89,8,'9dc2474a7d0a68023ad4f4c6f931f21c.png'),(90,8,'af5a36749d853443891641ab289cb24b.png'),(91,8,'afdcc60a645224a3344687af0286c614.png'),(92,7,'d0be2d4d1bd6314b39525578eb9804b3.png'),(93,7,'6e5d522a947f7aa0cddb9f4a61d9bc9b.png'),(94,7,'aea7d7c0ea58b6d6a79f58a9c14ab323.png'),(95,7,'0f4d181ef7728699daba03cd7e45f729.png');
/*!40000 ALTER TABLE `images` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migration_versions`
--

DROP TABLE IF EXISTS `migration_versions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migration_versions` (
  `version` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migration_versions`
--

LOCK TABLES `migration_versions` WRITE;
/*!40000 ALTER TABLE `migration_versions` DISABLE KEYS */;
INSERT INTO `migration_versions` VALUES ('20190729120740'),('20190729121314'),('20190804103427'),('20190804143507'),('20190804144058');
/*!40000 ALTER TABLE `migration_versions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `phone`
--

DROP TABLE IF EXISTS `phone`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `phone` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contact_id` int(11) NOT NULL,
  `number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_444F97DDE7A1254A` (`contact_id`),
  CONSTRAINT `FK_444F97DDE7A1254A` FOREIGN KEY (`contact_id`) REFERENCES `contact` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `phone`
--

LOCK TABLES `phone` WRITE;
/*!40000 ALTER TABLE `phone` DISABLE KEYS */;
INSERT INTO `phone` VALUES (1,1,'060736'),(2,2,'0123456789'),(3,3,'0123456789'),(4,4,'0123456789'),(5,5,'012345789');
/*!40000 ALTER TABLE `phone` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `project`
--

DROP TABLE IF EXISTS `project`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `project` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `anchor` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `explanation` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `sorting` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `project_anchor_IDX` (`anchor`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `project`
--

LOCK TABLES `project` WRITE;
/*!40000 ALTER TABLE `project` DISABLE KEYS */;
INSERT INTO `project` VALUES (4,'LoupGapGoule','LoupGapRoule','<p><strong><a href=\"http://loupgaproule.franceserv.fr\">LoupGapRoule</a></strong> a &eacute;t&eacute; site recensant les parcours &agrave; v&eacute;lo propos&eacute;s en activit&eacute; par le <abbr title=\"Centre de Santé Mental\">CSM</abbr> de GAP.</p><ul><li>Mon premier site web con&ccedil;ut suivant l&#39;architecture <abbr title=\"Modèle Vue Contrôleur\">MVC</abbr>.</li><li>Utilisation du module <strong>open_ssl</strong> de PHP pour le cryptage des donn&eacute;es critiques des utilisateurs <em>(clefs et certificats auto-g&eacute;n&eacute;r&eacute;s)</em>.</li><li>Boite de messagerie en full AJAX</li></ul><p>Site a refondre avec les connaissances acquises depuis, avec comme objectif :</p><ul><li>Reduire drastiquement le temps de chargement de la page en appliquant une m&eacute;tode de chargement asynchrone des images.</li><li>G&eacute;n&eacute;rer moi-m&ecirc;me le trac&eacute; du parcours en exploitant directement les fichier .GPX (issue du GPS) et l&#39;afficher gr&acirc;ce l&#39;API GoogleMap.</li></ul>',4),(5,'Libertalia-pirateisland','pirateIsland','<p><span style=\"display:block;margin-bottom:1em;\"><strong><a href=\"http://libertalia-pirateisland.franceserv.com\">Libertalia-pirateisland</a></strong> est un site web r&eacute;alis&eacute; pendant ma formation au CNAM d&#39;Aix-en-Provences et fut l&#39;objet d&#39;une partie du suject d&#39;examen du module intitul&eacute; &quot;D&eacute;veloppement web (1) : architecture du web et d&eacute;veloppement c&ocirc;t&eacute; client&quot;.</span><br><span style=\"display:block;margin-bottom:1em;\">Le sujet de l&#39;examen fut de r&eacute;aliser un site web en langage cot&eacute; client (HTML5, CSS3) comprennant une partie curiculum vitae impos&eacute;e et une partie sur un sujet de notre choix.&nbsp;</span><em style=\"display:block;\">Il n&#39;y a aucun langage serveur sur ce site web, sauf la partie contact o&ugrave; il y a un petit script php qui &eacute;crit les messages dans un fichier XML</em>.</p>',5),(6,'Cat clinic','catClinic','<p><strong><a href=\"\">Cat Clinic</a></strong> est un site web qui fut un sujet d&#39;examen du module &quot;D&eacute;veloppement web (3) : mise en pratique&quot; de la formation du CNAM d&#39;Aix-en-Provence (certificat professionnel intitul&eacute;: &quot;Programmation de sites web&quot;). Le sujet de la clinique v&eacute;t&eacute;rinaire &eacute;tait impos&eacute;.</p><p>Ce site est enti&egrave;rement con&ccedil;ut suivant l&#39;architecture MVC avec l&#39;utilisation du framework CSS Foundation. Il y a une possibilit&eacute; de prendre rendez-vous depuis le site web avec la capacit&eacute; pour les employ&eacute;s de r&eacute;pondre par e-mail. Il y a une gestion des e-mails depuis le site. L&#39;application g&eacute;nere une convocation au format PDF joint &agrave; l&#39;e-mail en utilisant <a href=\"https://www.html2pdf.fr/\">html2pdf</a>.</p>',3),(7,'Maarch RM : authentification LDAP','Maarch-RM','<p>Sujet de stage r&eacute;alis&eacute; au sein du <strong>Service de la Navigation A&eacute;rienne - R&eacute;gion Parisienne</strong> appartenant &agrave; Direction G&eacute;n&eacute;rale de l&#39;Aviation Civile (DGAC) de Juillet &agrave; Septembre 2018 dont le but &eacute;tait d&#39;int&eacute;grer une authentification LDAP &agrave; l&#39;Open Source <a href=\"https://maarchrm.com/\">Maarch RM</a> et un syst&egrave;me permettant d&#39;identifier les archives r&eacute;cemment d&eacute;pos&eacute;es.<br>Il a n&eacute;cessit&eacute; l&#39;installation et le param&eacute;trage d&#39;un serveur LDAP servant de test pour le d&eacute;veloppement avec la cr&eacute;ation des objets gr&acirc;ce au format LDIF.</p><p><a href=\"/PDF/rapport-stage-UA3323-Gilles-Gandner.pdf\">Rapport de stage t&eacute;l&eacute;chargeable</a><em>(.pdf - 4.0mo)</em></p>',2),(8,'GG-CV','ggcv-proj','<p><strong><a href=\"/\">GG-CV.fr</a></strong> est un site portfolio. Il est enti&egrave;rement d&eacute;velopper en utilisant le Framework PHP Symfony 4 avec utilisation de l&#39;ORM Doctrine 2.<br><em>Le site en encore en cours de d&eacute;veloppement.</em></p>',1);
/*!40000 ALTER TABLE `project` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `skill`
--

DROP TABLE IF EXISTS `skill`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `skill` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `anchor` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `explanation` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_5E3DE4776751117D` (`anchor`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `skill`
--

LOCK TABLES `skill` WRITE;
/*!40000 ALTER TABLE `skill` DISABLE KEYS */;
INSERT INTO `skill` VALUES (9,'Côté client','client-side','<h3>HTML 5 / CSS 3 / Javascript</h3><p><span style=\"display:block;\">&nbsp;Ma&icirc;trise du pr&eacute;processeur Sass et les Frameworks Foundation et Compass&nbsp;</span> <span style=\"display:block;\">&nbsp;Bonne connaissance des @Media Queries&nbsp;</span> <span style=\"display:block;\">&nbsp;Respect des sp&eacute;cifications ARIA et des recommandations du W3C&nbsp;</span></p>'),(10,'Côté serveur','server-side','<h3>PHP &quot;~7.1&quot;</h3><p><span style=\"display:block;\">&nbsp;Bonne connaissance de la Programmation Orient&eacute; Objet (POO) ainsi que du mod&egrave;le MVC et de la technologie AJAX.&nbsp;</span> <span style=\"display:block;\">&nbsp;Quelques connaissances de la programmation de Bundles, utilis&eacute;s sous Symfony.&nbsp;</span></p><h3>Symfony 4.1</h3><p>Bonne notions du framework PHP Symfony v4.1, de ses templates TWIG ainsi de l&#39;ORM Doctrine 2.<br><em>Le site www.GG-CV.com enti&egrave;rement con&ccedil;ut sous Symfony v4.1</em>.</p><h3>Base de donn&eacute;es</h3><p><span style=\"display:block;\">&nbsp;Familiariser avec les SGBDRs MySQL et PostgreSQL en se servant des bases de donn&eacute;es relationnelles <em>(jointures, cl&eacute;es &eacute;trang&egrave;res, contraintes)</em>.&nbsp;</span> <span style=\"display:block;\">&nbsp;&Agrave; l&#39;aise avec l&#39;&eacute;laboration de <strong>MCD</strong> et de <strong>MLD</strong>.&nbsp;<br>&nbsp;Quelques notions dans l&#39;administration de bases de donn&eacute;es (droits utilisteurs).&nbsp;</span></p>'),(11,'Administration système','admin-comp','<ul><li>Mise en place de serveurs web Apache et gestion de serveurs virtuels ainsi que l&#39;application du protocole HTTPS comprennant certificats, et jeux de cl&eacute;es publique/priv&eacute;.</li><li>Bonne connaissance du syst&egrave;me d&#39;eploitation GNU/Linux (distribution DEBIAN).</li><li>Installation de serveur FTP gr&acirc;ce &agrave; ProFTP.</li><li>Installation et mise en place de serveur LDAP (OpenLDAP) pour authentification.</li><li>Pour les gestionnaires de versions:<ul><li>Installation de serveur GIT et administration gr&acirc;ce au GitLab.</li><li>Utilisation de Subversion (notions).</li></ul></li><li>Quelques notions sur les syst&egrave;mes de pare-feu.</li></ul>');
/*!40000 ALTER TABLE `skill` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `skill_image`
--

DROP TABLE IF EXISTS `skill_image`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `skill_image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `skill_id` int(11) NOT NULL,
  `image_id` int(11) NOT NULL,
  `sorting` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_E01597635585C142` (`skill_id`),
  UNIQUE KEY `UNIQ_E01597633DA5256D` (`image_id`),
  CONSTRAINT `FK_E01597633DA5256D` FOREIGN KEY (`image_id`) REFERENCES `images` (`id`),
  CONSTRAINT `FK_E01597635585C142` FOREIGN KEY (`skill_id`) REFERENCES `skill` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `skill_image`
--

LOCK TABLES `skill_image` WRITE;
/*!40000 ALTER TABLE `skill_image` DISABLE KEYS */;
INSERT INTO `skill_image` VALUES (9,9,23,2),(10,10,24,1),(11,11,25,3);
/*!40000 ALTER TABLE `skill_image` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649F85E0677` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (3,'admin','[\"ROLE_USER\", \"ROLE_ADMIN\"]','$2y$12$2Br2xWVw1RmXl4swLK55hutlVc17N7KXG/DLc/zLB0z2pC4ynDchG'),(4,'libertalia','[\"ROLE_USER\"]','$2y$12$okgmdqyYS2/M.1lqwq1W3eaPrVD/hvcAMdI1sdme4SvQtWI0Ozgnm');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `xppro`
--

DROP TABLE IF EXISTS `xppro`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `xppro` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `anchor` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `explanation` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `contract_type_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_F04AF3626751117D` (`anchor`),
  UNIQUE KEY `UNIQ_F04AF362CD1DF15B` (`contract_type_id`),
  CONSTRAINT `FK_F04AF362CD1DF15B` FOREIGN KEY (`contract_type_id`) REFERENCES `contractType` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `xppro`
--

LOCK TABLES `xppro` WRITE;
/*!40000 ALTER TABLE `xppro` DISABLE KEYS */;
/*!40000 ALTER TABLE `xppro` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `xppro_image`
--

DROP TABLE IF EXISTS `xppro_image`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `xppro_image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `xp_pro_id` int(11) NOT NULL,
  `image_id` int(11) NOT NULL,
  `sorting` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_44C0A7963DA5256D` (`image_id`),
  UNIQUE KEY `UNIQ_44C0A796A6CA38B4` (`xp_pro_id`),
  CONSTRAINT `FK_44C0A7963DA5256D` FOREIGN KEY (`image_id`) REFERENCES `images` (`id`),
  CONSTRAINT `FK_44C0A796A6CA38B4` FOREIGN KEY (`xp_pro_id`) REFERENCES `xppro` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `xppro_image`
--

LOCK TABLES `xppro_image` WRITE;
/*!40000 ALTER TABLE `xppro_image` DISABLE KEYS */;
/*!40000 ALTER TABLE `xppro_image` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'GGCV'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-08-04 17:35:39

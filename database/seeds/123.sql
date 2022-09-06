/*
SQLyog Ultimate v10.42 
MySQL - 5.5.5-10.4.11-MariaDB : Database - costdb
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`costdb` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `costdb`;

/*Table structure for table `cclients` */

DROP TABLE IF EXISTS `cclients`;

CREATE TABLE `cclients` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `companyname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `client_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `addline` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cclients_phone_unique` (`phone`),
  KEY `cclients_client_id_foreign` (`client_id`),
  CONSTRAINT `cclients_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `cclients` */

insert  into `cclients`(`id`,`name`,`companyname`,`phone`,`email`,`client_id`,`created_at`,`updated_at`,`addline`) values (1,'asdf','sadf','522132131231','123prin123ce1321399177@outlook.com',2,'2021-05-04 23:13:53','2021-05-04 23:13:53','123213');

/*Table structure for table `clients` */

DROP TABLE IF EXISTS `clients`;

CREATE TABLE `clients` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `companyname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `addline1` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `numberofemployees` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `service` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment` bigint(20) DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `user_id` bigint(20) NOT NULL,
  `stripe_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `card_brand` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `card_last_four` varchar(4) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `lat` double DEFAULT NULL,
  `lng` double DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `clients_companyname_unique` (`companyname`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `clients` */

insert  into `clients`(`id`,`companyname`,`addline1`,`country`,`cp`,`numberofemployees`,`service`,`payment`,`payment_date`,`user_id`,`stripe_id`,`card_brand`,`card_last_four`,`created_at`,`updated_at`,`lat`,`lng`) values (1,'BO','Church Street','Mexico','100001','1-5','[\"service\"]',3,'2021-04-09',2,NULL,'4242424242424242','123','2021-02-10 10:37:35','2021-04-09 14:50:00',NULL,NULL),(2,'BO1','Church Street','Mexico','100001','1-5','[\"service\"]',3,'2021-02-15',3,NULL,'4242424242424242','123','2021-02-10 12:03:02','2021-02-15 13:20:12',NULL,NULL);

/*Table structure for table `cmaterials` */

DROP TABLE IF EXISTS `cmaterials`;

CREATE TABLE `cmaterials` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `brand` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sku` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `partno` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` double(15,3) NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `client_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `provider` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `cmaterials_client_id_foreign` (`client_id`),
  CONSTRAINT `cmaterials_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=201 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `cmaterials` */

insert  into `cmaterials`(`id`,`description`,`brand`,`sku`,`partno`,`price`,`image`,`client_id`,`created_at`,`updated_at`,`provider`) values (195,'MADERA DE PINO CEPILLADA 244 X 10.1 CM BEIGE',NULL,NULL,NULL,659.000,NULL,2,'2021-04-25 17:28:49','2021-04-25 17:28:49','1'),(196,'MELAMINA MDP ROBLE D 15MM0.6X1.24M',NULL,NULL,NULL,1200.000,NULL,2,'2021-04-25 17:28:49','2021-04-25 17:28:49','1'),(197,'CUBRE CANTO DE MELANINA ENGOMADA BLANCO 5 M',NULL,NULL,NULL,31.000,NULL,2,'2021-04-25 17:28:49','2021-04-25 17:28:49','1'),(198,'tabla de madera',NULL,NULL,NULL,160.000,NULL,2,'2021-04-25 17:28:49','2021-04-25 17:28:49','1'),(199,'tabla de madera',NULL,NULL,NULL,160.000,NULL,2,'2021-04-25 17:28:49','2021-04-25 17:28:49','1'),(200,'Perfil cuadrado 2 x 2 calibre 18',NULL,NULL,NULL,461.000,NULL,2,'2021-04-25 17:28:50','2021-04-25 17:28:50','1');

/*Table structure for table `cquotes` */

DROP TABLE IF EXISTS `cquotes`;

CREATE TABLE `cquotes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `project_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `discount` tinyint(4) NOT NULL,
  `unprevented` tinyint(4) NOT NULL,
  `advance` tinyint(4) NOT NULL,
  `shopdays` double(10,2) NOT NULL,
  `total` double(15,2) NOT NULL,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'New',
  `quote_number` bigint(20) DEFAULT NULL,
  `invoice_number` bigint(20) DEFAULT NULL,
  `isInvoice` tinyint(1) NOT NULL DEFAULT 0,
  `isQuote` tinyint(1) NOT NULL DEFAULT 0,
  `invoice_status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'New',
  PRIMARY KEY (`id`),
  KEY `cquotes_project_id_foreign` (`project_id`),
  CONSTRAINT `cquotes_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `cquotes` */

/*Table structure for table `cservices` */

DROP TABLE IF EXISTS `cservices`;

CREATE TABLE `cservices` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `provider` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cost` double(15,3) NOT NULL,
  `utility` int(11) NOT NULL,
  `price` double(15,3) NOT NULL,
  `client_id` bigint(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `cservices` */

/*Table structure for table `db_status` */

DROP TABLE IF EXISTS `db_status`;

CREATE TABLE `db_status` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `str_key` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `str_value` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `db_status` */

/*Table structure for table `employees` */

DROP TABLE IF EXISTS `employees`;

CREATE TABLE `employees` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `salary` bigint(20) NOT NULL,
  `cycle` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `client_id` bigint(20) unsigned NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `employees_client_id_foreign` (`client_id`),
  CONSTRAINT `employees_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `employees` */

/*Table structure for table `expensetypes` */

DROP TABLE IF EXISTS `expensetypes`;

CREATE TABLE `expensetypes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `client_id` bigint(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `expensetypes_name_unique` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `expensetypes` */

/*Table structure for table `failed_jobs` */

DROP TABLE IF EXISTS `failed_jobs`;

CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `failed_jobs` */

/*Table structure for table `fixedexpenses` */

DROP TABLE IF EXISTS `fixedexpenses`;

CREATE TABLE `fixedexpenses` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cost` double(15,3) NOT NULL,
  `cycle` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `client_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `fixedexpenses_name_unique` (`name`),
  KEY `fixedexpenses_client_id_foreign` (`client_id`),
  CONSTRAINT `fixedexpenses_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `fixedexpenses` */

/*Table structure for table `materials` */

DROP TABLE IF EXISTS `materials`;

CREATE TABLE `materials` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `brand` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sku` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `partno` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` double(15,3) NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shop_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `materials_shop_id_foreign` (`shop_id`),
  CONSTRAINT `materials_shop_id_foreign` FOREIGN KEY (`shop_id`) REFERENCES `shops` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=33961 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `materials` */

insert  into `materials`(`id`,`description`,`brand`,`sku`,`partno`,`price`,`image`,`shop_id`,`created_at`,`updated_at`) values (33632,'JABONERA DE ABS (DE PLÁSTICO INDUSTRIAL)','BATH STYLES','500273','656001',89.000,'https://cdn.homedepot.com.mx/productos/500273/500273-d.jpg',1,'2021-04-23 15:47:18','2021-04-23 15:47:18'),(33633,'PORTACEPILLOS CASTLEBY 11 CM PLATA MOEN','MOEN','440378','Y2544CH',725.000,'https://cdn.homedepot.com.mx/productos/440378/440378-d.jpg',1,'2021-04-23 15:47:18','2021-04-23 15:47:18'),(33634,'JABONERA DE MONTAJE PARED CASTLEBY CROMO','MOEN','440213','Y2566CH',725.000,'https://cdn.homedepot.com.mx/productos/440213/440213-d.jpg',1,'2021-04-23 15:47:18','2021-04-23 15:47:18'),(33635,'CORTINERO EN ESCUADRA ALUMINIO BLANCO','OXAL','404407','Escuadra',429.000,'https://cdn.homedepot.com.mx/productos/404407/404407-d.jpg',1,'2021-04-23 15:47:18','2021-04-23 15:47:18'),(33636,'CORTINERO AJUSTABLE DE 73 A 110 CM BLANCO OXAL','OXAL','404395','Ajustable',169.000,'https://cdn.homedepot.com.mx/productos/404395/404395-d.jpg',1,'2021-04-23 15:47:19','2021-04-23 15:47:19'),(33637,'AHORRA ESPACIOS 3 REPISAS ACERO 164 CM PLATA BATH STYLES','BATH STYLES','376100','2523NN',699.000,'https://cdn.homedepot.com.mx/productos/376100/376100-d.jpg',1,'2021-04-23 15:47:19','2021-04-23 15:47:19'),(33638,'PORTARROLLO EMPOTRABLE CROMO','MOEN','373744','DN5075',640.000,'https://cdn.homedepot.com.mx/productos/373744/373744-d.jpg',1,'2021-04-23 15:47:19','2021-04-23 15:47:19'),(33639,'JABONERA EMPOTRABLE CROMO','MOEN','373736','DN5065',595.000,'https://cdn.homedepot.com.mx/productos/373736/373736-d.jpg',1,'2021-04-23 15:47:19','2021-04-23 15:47:19'),(33640,'CORTINERO AJUSTABLE DE 73 A 110 CM BEIGE OXAL','OXAL','351034','Ajustable',169.000,'https://cdn.homedepot.com.mx/productos/351034/351034-d.jpg',1,'2021-04-23 15:47:20','2021-04-23 15:47:20'),(33641,'CORTINERO AJUSTABLE DE 150-280 CM BLANCO','OXAL','350952','9800015',299.000,'https://cdn.homedepot.com.mx/productos/350952/350952-d.jpg',1,'2021-04-23 15:47:20','2021-04-23 15:47:20'),(33642,'CORTINERO AJUSTABLE 280 CENTÍMETROS BEIGE OXAL','OXAL','350944','Ajustable',319.000,'https://cdn.homedepot.com.mx/productos/350944/350944-d.jpg',1,'2021-04-23 15:47:20','2021-04-23 15:47:20'),(33643,'CORTINERO AJUSTABLE 105-183 CM CROMO','OXAL','350901','9700148',279.000,'https://cdn.homedepot.com.mx/productos/350901/350901-d.jpg',1,'2021-04-23 15:47:20','2021-04-23 15:47:20'),(33644,'CORTINERO AJUSTABLE DE 150 A 280 CM CAFÉ OXAL','OXAL','321223','Ajustable',299.000,'https://cdn.homedepot.com.mx/productos/321223/321223-d.jpg',1,'2021-04-23 15:47:21','2021-04-23 15:47:21'),(33645,'CORTINERO AJUSTABLE 105-183 CM CHOCOLATE','OXAL','320068','9700056',249.000,'https://cdn.homedepot.com.mx/productos/320068/320068-d.jpg',1,'2021-04-23 15:47:21','2021-04-23 15:47:21'),(33646,'TOALLERO DE 60 CM CROMADO','BATH ACCENTS','300608','HBA-3106SS',279.000,'https://cdn.homedepot.com.mx/productos/300608/300608-d.jpg',1,'2021-04-23 15:47:21','2021-04-23 15:47:21'),(33647,'PORTA VASO CROMADO CON VASO DE VIDRIO','BATH ACCENTS','300604','HBA-3103SG',189.000,'https://cdn.homedepot.com.mx/productos/300604/300604-d.jpg',1,'2021-04-23 15:47:22','2021-04-23 15:47:22'),(33648,'TOALLERO EN ARO CROMADO','BATH ACCENTS','300600','HBA-3105SS',199.000,'https://cdn.homedepot.com.mx/productos/300600/300600-d.jpg',1,'2021-04-23 15:47:22','2021-04-23 15:47:22'),(33649,'PORTA ROLLOS CROMADO','BATH ACCENTS','300596','HBA-3104SS',249.000,'https://cdn.homedepot.com.mx/productos/300596/300596-d.jpg',1,'2021-04-23 15:47:22','2021-04-23 15:47:22'),(33650,'JABONERA DE VIDRIO CON BASE CROMADA','BATH ACCENTS','300592','HBA-3102SG',199.000,'https://cdn.homedepot.com.mx/productos/300592/300592-d.jpg',1,'2021-04-23 15:47:22','2021-04-23 15:47:22'),(33651,'GANCHO PARA BAÑO CROMADO','BATH ACCENTS','300580','HBA-3101SS',99.000,'https://cdn.homedepot.com.mx/productos/300580/300580-d.jpg',1,'2021-04-23 15:47:23','2021-04-23 15:47:23'),(33652,'GANCHO DECORATIVO TRIPLE CROMO','MOEN','280637','7603CH',385.000,'https://cdn.homedepot.com.mx/productos/280637/280637-d.jpg',1,'2021-04-23 15:47:23','2021-04-23 15:47:23'),(33653,'PORTARROLLO CROMADO 16 CM PLATA I-HANGER','I-HANGER','211895','IHC-100',70.000,'https://cdn.homedepot.com.mx/productos/211895/211895-d.jpg',1,'2021-04-23 15:47:23','2021-04-23 15:47:23'),(33654,'PERCHA TRIPLE 10 PULGADAS GRIS MOEN','MOEN','211706','7603BN',395.000,'https://cdn.homedepot.com.mx/productos/211706/211706-d.jpg',1,'2021-04-23 15:47:23','2021-04-23 15:47:23'),(33655,'CORTINA PARA BAÑO POLIÉSTER TWIST BROWN','MENYRE','205238','LAV-CURPOL48',339.000,'https://cdn.homedepot.com.mx/productos/205238/205238-d.jpg',1,'2021-04-23 15:47:24','2021-04-23 15:47:24'),(33656,'CORTINA PARA BAÑO STRIPE AQUA 180 X 180 CM AZUL MENYRE','MENYRE','205232','LAV-CURPOL12',339.000,'https://cdn.homedepot.com.mx/productos/205232/205232-d.jpg',1,'2021-04-23 15:47:24','2021-04-23 15:47:24'),(33657,'CORTINA PARA BAÑO FLORAL DREAM 180 X 180 CM BLANCO MENYRE','MENYRE','205220','LAV-CURPOL51',329.000,'https://cdn.homedepot.com.mx/productos/205220/205220-d.jpg',1,'2021-04-23 15:47:24','2021-04-23 15:47:24'),(33658,'CORTINA PARA BAÑO CAPUCHINO REAL DE 180 X 180 CM CAFÉ MENYRE','MENYRE','205214','LAV-CURPOL07',339.000,'https://cdn.homedepot.com.mx/productos/205214/205214-d.jpg',1,'2021-04-23 15:47:24','2021-04-23 15:47:24'),(33659,'CORTINA PARA BAÑO TWISTER GREY DE 180 X 180 CM MULTICOLOR MENYRE','MENYRE','205208','LAV-CURPOL26',249.000,'https://cdn.homedepot.com.mx/productos/205208/205208-d.jpg',1,'2021-04-23 15:47:25','2021-04-23 15:47:25'),(33660,'CORTINA PARA BAÑO FROSTED LIGHT 180 x 180 CM BLANCO MENYRE','MENYRE','205196','LAV-CURPEV18',269.000,'https://cdn.homedepot.com.mx/productos/205196/205196-d.jpg',1,'2021-04-23 15:47:25','2021-04-23 15:47:25'),(33661,'CORTINA PARA BAÑO MOSAIC DE 180 X 180 CM BEIGE MENYRE','MENYRE','205190','LAV-CURPEV55',249.000,'https://cdn.homedepot.com.mx/productos/205190/205190-d.jpg',1,'2021-04-23 15:47:25','2021-04-23 15:47:25'),(33662,'TOALLERO EXPLORA DE 72.3 X 8.5 CM PLATA HELVEX','HELVEX','201683','HOT-105',1365.000,'https://cdn.homedepot.com.mx/productos/201683/201683-d.jpg',1,'2021-04-23 15:47:25','2021-04-23 15:47:25'),(33663,'PORTAPAPEL SENCILLO DE 21.3 CM LATÓN HELVEX','HELVEX','201677','HOT-117',869.000,'https://cdn.homedepot.com.mx/productos/201677/201677-d.jpg',1,'2021-04-23 15:47:26','2021-04-23 15:47:26'),(33664,'JABONERA EXPLORA DE 18 X 13 CM PLATA HELVEX','HELVEX','201653','HOT-108',669.000,'https://cdn.homedepot.com.mx/productos/201653/201653-d.jpg',1,'2021-04-23 15:47:26','2021-04-23 15:47:26'),(33665,'GANCHO PARA BAÑO EXPLORA 8.9 X 8.4 CM PLATA HELVEX','HELVEX','201650','HOT-106',459.000,'https://cdn.homedepot.com.mx/productos/201650/201650-d.jpg',1,'2021-04-23 15:47:26','2021-04-23 15:47:26'),(33666,'PORTACEPILLOS 18 CM PLATA HELVEX','HELVEX','201647','HOT-107',669.000,'https://cdn.homedepot.com.mx/productos/201647/201647-d.jpg',1,'2021-04-23 15:47:27','2021-04-23 15:47:27'),(33667,'MUEBLE AHORRADOR DE ESPACIO 161x63x25 CM MALAGA HD WENGUE','DIECSA','193330','MLW958',1209.000,'https://cdn.homedepot.com.mx/productos/193330/193330-d.jpg',1,'2021-04-23 15:47:27','2021-04-23 15:47:27'),(33668,'ORGANIZADOR ESQUINERO DE BAÑO HD WENGUE','DIECSA','193306','RLW953',1849.000,'https://cdn.homedepot.com.mx/productos/193306/193306-d.jpg',1,'2021-04-23 15:47:27','2021-04-23 15:47:27'),(33669,'BARRA MULTIUSOS ADHERIBLE DE 0.44 A 0.77 M PLATA NOVACORT','NOVACORT','173893','Adherible',106.000,'https://cdn.homedepot.com.mx/productos/173893/173893-d.jpg',1,'2021-04-23 15:47:27','2021-04-23 15:47:27'),(33670,'DESPACHADOR DE JABON LIQUIDO 600ML','ART & HOME','130143','HB 5839',349.000,'https://cdn.homedepot.com.mx/productos/130143/130143-d.jpg',1,'2021-04-23 15:47:28','2021-04-23 15:47:28'),(33671,'DESPACHADOR DE JABÓN LÍQUIDO DE 350 ML PLATA','ART & HOME','130141','Hb-5838',289.000,'https://cdn.homedepot.com.mx/productos/130141/130141-d.jpg',1,'2021-04-23 15:47:28','2021-04-23 15:47:28'),(33672,'DESPACHADOR DOBLE DE JABÓN 16.5 X 19 CM PLATA ART &amp; HOME','ART & HOME','127666','127666',297.000,'https://cdn.homedepot.com.mx/productos/127666/127666-d.jpg',1,'2021-04-23 15:47:28','2021-04-23 15:47:28'),(33673,'JUEGO DE ACCESORIOS MANILA PARA BAÑO DE ZINC 4 PIEZAS','FLOWELL','127006','KT464BM',929.000,'https://cdn.homedepot.com.mx/productos/127006/127006-d.jpg',1,'2021-04-23 15:47:28','2021-04-23 15:47:28'),(33674,'CORTINA PARA BAÑO 12 GANCHOS','MENYRE','126856','LAV-080',399.000,'https://cdn.homedepot.com.mx/productos/126856/126856-d.jpg',1,'2021-04-23 15:47:28','2021-04-23 15:47:28'),(33675,'TOALLERO PARA BAÑO DE 60 X 7 X 3 CM PLATA BATH ACCENTS','BATH ACCENTS','124142','BARPAL-2265',379.000,'https://cdn.homedepot.com.mx/productos/124142/124142-d.jpg',1,'2021-04-23 15:47:29','2021-04-23 15:47:29'),(33676,'PORTA VASO 10.3 X 13.2 CM PLATA BATH ACCENTS','BATH ACCENTS','124141','BAPVAL-2276',325.000,'https://cdn.homedepot.com.mx/productos/124141/124141-d.jpg',1,'2021-04-23 15:47:29','2021-04-23 15:47:29'),(33677,'JABONERA OVAL DE ALUMINIO','BATH ACCENTS','124140','BAPTAL2264',329.000,'https://cdn.homedepot.com.mx/productos/124140/124140-d.jpg',1,'2021-04-23 15:47:29','2021-04-23 15:47:29'),(33678,'PORTAROLLOS SENCILLO DE ALUMINIO','BATH ACCENTS','124138','BAPTAL-2261',189.000,'https://cdn.homedepot.com.mx/productos/124138/124138-d.jpg',1,'2021-04-23 15:47:29','2021-04-23 15:47:29'),(33679,'ESTANTERIA DE BAÑO MALAGA SIENA RTA DESIGN','DIECSA','121237','ELW2121',925.000,'https://cdn.homedepot.com.mx/productos/121237/121237-d.jpg',1,'2021-04-23 15:47:30','2021-04-23 15:47:30'),(33680,'ESQUINERO DE TENSIÓN COLOR CHOCOLATE','BATH ACCENTS','116359','2364ORB',559.000,'https://cdn.homedepot.com.mx/productos/116359/116359-d.jpg',1,'2021-04-23 15:47:30','2021-04-23 15:47:30'),(33681,'VASO CEPILLERO DE VIDRIO TRANSPARENTE FLOWELL','GRIFCO','116277','153TCM',75.000,'https://cdn.homedepot.com.mx/productos/116277/116277-d.jpg',1,'2021-04-23 15:47:30','2021-04-23 15:47:30'),(33682,'VASO CEPILLERO DE VIDRIO ESMERILADO FLOWELL','GRIFCO','116276','152TFM',75.000,'https://cdn.homedepot.com.mx/productos/116276/116276-d.jpg',1,'2021-04-23 15:47:30','2021-04-23 15:47:30'),(33683,'JABONERA DE VIDRIO FLOWELL','GRIFCO','116275','151DCM',75.000,'https://cdn.homedepot.com.mx/productos/116275/116275-d.jpg',1,'2021-04-23 15:47:31','2021-04-23 15:47:31'),(33684,'JABONERA DE VIDRIO ESMERILADO FLOWELL','GRIFCO','116272','150DFM',75.000,'https://cdn.homedepot.com.mx/productos/116272/116272-d.jpg',1,'2021-04-23 15:47:31','2021-04-23 15:47:31'),(33685,'TOALLERO DE ARGOLLA CONTEMPORÁNEO CROMO','DONNER','111816','2860',280.000,'https://cdn.homedepot.com.mx/productos/111816/111816-d.jpg',1,'2021-04-23 15:47:31','2021-04-23 15:47:31'),(33686,'CEPILLERA PARA BAÑO CROMO CONTEMPORÁNEO','DONNER','111815','2340',225.000,'https://cdn.homedepot.com.mx/productos/111815/111815-d.jpg',1,'2021-04-23 15:47:31','2021-04-23 15:47:31'),(33687,'TOALLERO DE BARRA DE 24 PULGADAS CROMO CONTEMPORÁNEO','DONNER','111813','2224',395.000,'https://cdn.homedepot.com.mx/productos/111813/111813-d.jpg',1,'2021-04-23 15:47:32','2021-04-23 15:47:32'),(33688,'PORTARROLLO PARA BAÑO CONTEMPORÁNEO CROMO','MOEN','111812','2050CH',310.000,'https://cdn.homedepot.com.mx/productos/111812/111812-d.jpg',1,'2021-04-23 15:47:32','2021-04-23 15:47:32'),(33689,'GANCHO DOBLE PARA BAÑO CONTEMPORÁNEO CROMO','DONNER','111811','2030',145.000,'https://cdn.homedepot.com.mx/productos/111811/111811-d.jpg',1,'2021-04-23 15:47:32','2021-04-23 15:47:32'),(33690,'TOALLERO ARGOLLA BANBURY NÍQUEL','MOEN','111809','Y2686BN',550.000,'https://cdn.homedepot.com.mx/productos/111809/111809-d.jpg',1,'2021-04-23 15:47:32','2021-04-23 15:47:32'),(33691,'TOALLERO DE BARRA DE 24 PULGADAS BANBURY NÍQUEL','MOEN','111808','Y2608CH',810.000,'https://cdn.homedepot.com.mx/productos/111808/111808-d.jpg',1,'2021-04-23 15:47:32','2021-04-23 15:47:32'),(33692,'PORTARROLLO BANBURY NÍQUEL','MOEN','111807','Y2608BN',705.000,'https://cdn.homedepot.com.mx/productos/111807/111807-d.jpg',1,'2021-04-23 15:47:33','2021-04-23 15:47:33'),(33693,'GANCHO PARA BAÑO BANBURY NÍQUEL','MOEN','111806','Y2603BN',410.000,'https://cdn.homedepot.com.mx/productos/111806/111806-d.jpg',1,'2021-04-23 15:47:33','2021-04-23 15:47:33'),(33694,'JABONERA PARA BAÑO CONTEMPORÁNEA CROMO','MOEN','111659','2360CH',215.000,'https://cdn.homedepot.com.mx/productos/111659/111659-d.jpg',1,'2021-04-23 15:47:33','2021-04-23 15:47:33'),(33695,'JUEGO DE ACCESORIOS PALMIRA PARA BAÑO DE ZINC 6 PIEZAS','FLOWELL','111645','KT6029M',999.000,'https://cdn.homedepot.com.mx/productos/111645/111645-d.jpg',1,'2021-04-23 15:47:33','2021-04-23 15:47:33'),(33696,'JUEGO DE ACCESORIOS DE BAÑO LEYVA 4 PIEZAS MADERA','FLOWELL','111642','KT1008M',505.000,'https://cdn.homedepot.com.mx/productos/111642/111642-d.jpg',1,'2021-04-23 15:47:33','2021-04-23 15:47:33'),(33697,'JUEGO DE ACCESORIOS DALENA PARA BAÑO DE ZINC 6 PIEZAS','FLOWELL','111641','KT1011BM',1525.000,'https://cdn.homedepot.com.mx/productos/111641/111641-d.jpg',1,'2021-04-23 15:47:34','2021-04-23 15:47:34'),(33698,'JUEGO DE ACCESORIOS BASEL PARA BAÑO DE ZINC 6 PIEZAS','FLOWELL','111639','KT1014BM',999.000,'https://cdn.homedepot.com.mx/productos/111639/111639-d.jpg',1,'2021-04-23 15:47:34','2021-04-23 15:47:34'),(33699,'JUEGO DE ACCESORIOS NEIVA PARA BAÑO DE ZINC 6 PIEZAS','FLOWELL','111638','KT1013M',939.000,'https://cdn.homedepot.com.mx/productos/111638/111638-d.jpg',1,'2021-04-23 15:47:34','2021-04-23 15:47:34'),(33700,'JUEGO DE ACCESORIOS PARA BAÑO DE ALEACIÓN DE ZINC 6 PIEZAS','FLOWELL','111633','KT6135M',699.000,'https://cdn.homedepot.com.mx/productos/111633/111633-d.jpg',1,'2021-04-23 15:47:34','2021-04-23 15:47:34'),(33701,'JUEGO DE ACCESORIOS DE BAÑO TALI 6 PIEZAS CROMO','FLOWELL','111632','KT6034M',939.000,'https://cdn.homedepot.com.mx/productos/111632/111632-d.jpg',1,'2021-04-23 15:47:34','2021-04-23 15:47:34'),(33702,'JUEGO DE ACCESORIOS IRIS PARA BAÑO DE ZINC 6 PIEZAS','FLOWELL','111630','KT6023M',815.000,'https://cdn.homedepot.com.mx/productos/111630/111630-d.jpg',1,'2021-04-23 15:47:35','2021-04-23 15:47:35'),(33703,'JUEGO DE ACCESORIOS EROS PARA BAÑO DE ZINC 6 PIEZAS','FLOWELL','111629','KT6020M',735.000,'https://cdn.homedepot.com.mx/productos/111629/111629-d.jpg',1,'2021-04-23 15:47:35','2021-04-23 15:47:35'),(33704,'Juego de Accesorios Cali','FLOWELL','111625','KT112BM',1325.000,'https://cdn.homedepot.com.mx/productos/111625/111625-d.jpg',1,'2021-04-23 15:47:35','2021-04-23 15:47:35'),(33705,'CORTINA GANCHO MÁGICO POLIÉSTER BRITHISH AIR','MENYRE','110970','LAV-061',399.000,'https://cdn.homedepot.com.mx/productos/110970/110970-d.jpg',1,'2021-04-23 15:47:35','2021-04-23 15:47:35'),(33706,'CORTINA PARA BAÑO GANCHO MÁGICO DPARIS 200 X 200 CM GRIS MENYRE','MENYRE','110968','LAV-060',399.000,'https://cdn.homedepot.com.mx/productos/110968/110968-d.jpg',1,'2021-04-23 15:47:35','2021-04-23 15:47:35'),(33707,'CORTINA POLIÉSTER SAFARI','MENYRE','110959','LAV-045',329.000,'https://cdn.homedepot.com.mx/productos/110959/110959-d.jpg',1,'2021-04-23 15:47:36','2021-04-23 15:47:36'),(33708,'CORTINA POLIÉSTER ALEGRÍA','MENYRE','110957','LAV-044',329.000,'https://cdn.homedepot.com.mx/productos/110957/110957-d.jpg',1,'2021-04-23 15:47:36','2021-04-23 15:47:36'),(33709,'CORTINERO DECORATIVO DE LUJO 183 CM PLATA OXAL','OXAL','110693','Decorativo',389.000,'https://cdn.homedepot.com.mx/productos/110693/110693-d.jpg',1,'2021-04-23 15:47:36','2021-04-23 15:47:36'),(33710,'ACCESORIOS PARA BAÑOS VENUE DE METAL GLACIER BAY 6 PIEZAS','GLACIER BAY','107834','20119-8704',1925.000,'https://cdn.homedepot.com.mx/productos/107834/107834-d.jpg',1,'2021-04-23 15:47:36','2021-04-23 15:47:36'),(33711,'GANCHO DOBLE PARA BATAS METAL PLATA 1 PIEZA','GLACIER BAY','107831','107831',235.000,'https://cdn.homedepot.com.mx/productos/107831/107831-d.jpg',1,'2021-04-23 15:47:36','2021-04-23 15:47:36'),(33712,'TOALLERO EDGEWOOD DE ARGOLLA CROMO GLACIER BAY','GLACIER BAY','107830','EDGEWOOD',325.000,'https://cdn.homedepot.com.mx/productos/107830/107830-d.jpg',1,'2021-04-23 15:47:37','2021-04-23 15:47:37'),(33713,'JUEGO DE ACCESORIOS DE BAÑO DANIKA 4 PIEZAS CROMO','MOEN','106362','BH2934CH',2250.000,'https://cdn.homedepot.com.mx/productos/106362/106362-d.jpg',1,'2021-04-23 15:47:37','2021-04-23 15:47:37'),(33714,'AGARRADERA PARA BAÑO DE 12 PULGADAS BLANCO',NULL,'105451','LR2308W',410.000,'https://cdn.homedepot.com.mx/productos/105451/105451-d.jpg',1,'2021-04-23 15:47:37','2021-04-23 15:47:37'),(33715,'BARRA DE SEGURIDAD DE 24 PULGADAS CON TOALLERO NÍQUEL','MOEN','105001','LR2350DBN',1119.000,'https://cdn.homedepot.com.mx/productos/105001/105001-d.jpg',1,'2021-04-23 15:47:37','2021-04-23 15:47:37'),(33716,'BARRA DE SEGURIDAD DE 16 PULGADAS CON REPISA ACABADO NÍQUEL','MOEN','105000','LR2356DBN',1039.000,'https://cdn.homedepot.com.mx/productos/105000/105000-d.jpg',1,'2021-04-23 15:47:37','2021-04-23 15:47:37'),(33717,'BARRA DE SEGURIDAD DE 8 PULGADAS CON PORTARROLLO NÍQUEL','MOEN','104998','LR2352DBN',1015.000,'https://cdn.homedepot.com.mx/productos/104998/104998-d.jpg',1,'2021-04-23 15:47:38','2021-04-23 15:47:38'),(33718,'BARRA DE AGARRE PARA BAÑO DE 36\" GLACIER BAY','GLACIER BAY','102894','GB-10036-21',979.000,'https://cdn.homedepot.com.mx/productos/102894/102894-d.jpg',1,'2021-04-23 15:47:38','2021-04-23 15:47:38'),(33719,'BARRA DE AGARRE DE 24\'\' PARA BAÑO ACERO INOXIDABLE GLACIER BAY','GLACIER BAY','102893','GB-10024-21',895.000,'https://cdn.homedepot.com.mx/productos/102893/102893-d.jpg',1,'2021-04-23 15:47:38','2021-04-23 15:47:38'),(33720,'BARRA DE AGARRE PARA BAÑO DE 24\'\' ACERO INOXIDABLE GLACIER BAY','GLACIER BAY','102891','GB-30024-21',895.000,'https://cdn.homedepot.com.mx/productos/102891/102891-d.jpg',1,'2021-04-23 15:47:38','2021-04-23 15:47:38'),(33721,'Barra de agarre de seguridad para baño 18\"','GLACIER BAY','102890','GB-20018-21',769.000,'https://cdn.homedepot.com.mx/productos/102890/102890-d.jpg',1,'2021-04-23 15:47:38','2021-04-23 15:47:38'),(33722,'BARRA DE AGARRE PARA BAÑOS DE 18\" ACERO INOXIDABLE GLACIER BAY','GLACIER BAY','102888','GB-30018-21',845.000,'https://cdn.homedepot.com.mx/productos/102888/102888-d.jpg',1,'2021-04-23 15:47:39','2021-04-23 15:47:39'),(33723,'BARRA CUADRADA DE AGARRE PARA BAÑO BLANCA DE 16\'\' GLACIER BAY','GLACIER BAY','102887','GB-GRS16-01',499.000,'https://cdn.homedepot.com.mx/productos/102887/102887-d.jpg',1,'2021-04-23 15:47:39','2021-04-23 15:47:39'),(33724,'BARRA DE AGARRE DE CUADRADA DE 16\'\' PARA BAÑO CROMO GLACIER BAY','GLACIER BAY','102885','GB-GRS16-07',559.000,'https://cdn.homedepot.com.mx/productos/102885/102885-d.jpg',1,'2021-04-23 15:47:39','2021-04-23 15:47:39'),(33725,'9\" BARRA CUADRADA DE AGARRE BLANCO','GLACIER BAY','102884','GB-GRS09-01',359.000,'https://cdn.homedepot.com.mx/productos/102884/102884-d.jpg',1,'2021-04-23 15:47:39','2021-04-23 15:47:39'),(33726,'BARRA CUADRADA DE AGARRE DE 9\'\' CROMO GLACIER BAY','GLACIER BAY','102882','GB-GRS09-07',435.000,'https://cdn.homedepot.com.mx/productos/102882/102882-d.jpg',1,'2021-04-23 15:47:39','2021-04-23 15:47:39'),(33727,'BARRA DE AGARRE DE 60.9 CM ACERO INOXIDABLE','GLACIER BAY','102881','20135-03202-24',845.000,'https://cdn.homedepot.com.mx/productos/102881/102881-d.jpg',1,'2021-04-23 15:47:40','2021-04-23 15:47:40'),(33728,'CORTINA DE BAÑO HOTELERA BLANCO POLYESTER 180 X 180 CM','MENYRE','101577','LAV-067',469.000,'https://cdn.homedepot.com.mx/productos/101577/101577-d.jpg',1,'2021-04-23 15:47:40','2021-04-23 15:47:40'),(33886,'ORGANIZADOR PARA REGADERA PLÁSTICO DE 66 CM TRANSPARENTE BATH ACCENTS','BATH ACCENTS','906738','BACDPL-2596',249.000,'https://cdn.homedepot.com.mx/productos/906738/906738-d.jpg',1,'2021-04-23 15:50:50','2021-04-23 15:50:50'),(33887,'CORTINERO AJUSTABLE 105-183 CM PLATA','OXAL','887836','9700124',259.000,'https://cdn.homedepot.com.mx/productos/887836/887836-d.jpg',1,'2021-04-23 15:50:50','2021-04-23 15:50:50'),(33888,'DESPACHADOR PARA BAÑO','ART & HOME','878087','HB-5523',229.000,'https://cdn.homedepot.com.mx/productos/878087/878087-d.jpg',1,'2021-04-23 15:50:51','2021-04-23 15:50:51'),(33889,'CORTINA PVC VENECIANO CAFÉ','MENYRE','877903','LAV-038',299.000,'https://cdn.homedepot.com.mx/productos/877903/877903-d.jpg',1,'2021-04-23 15:50:51','2021-04-23 15:50:51'),(33890,'ESQUINERO DE TENSIÓN POLIPROPILENO DE 246 CM BLANCO BATH ACCENTS','BATH ACCENTS','877623','BAEQPL-2593',329.000,'https://cdn.homedepot.com.mx/productos/877623/877623-d.jpg',1,'2021-04-23 15:50:51','2021-04-23 15:50:51'),(33891,'PORTARROLLO ISO CROMO','MOEN','876922','DN0708CH',690.000,'https://cdn.homedepot.com.mx/productos/876922/876922-d.jpg',1,'2021-04-23 15:50:51','2021-04-23 15:50:51'),(33892,'TOALLERO DE ARGOLLA ISO CROMO','MOEN','876827','DN0786CH',520.000,'https://cdn.homedepot.com.mx/productos/876827/876827-d.jpg',1,'2021-04-23 15:50:52','2021-04-23 15:50:52'),(33893,'TOALLERO DE BARRA DE 24 PULGADAS ISO CROMO','MOEN','876819','DN0724CH',785.000,'https://cdn.homedepot.com.mx/productos/876819/876819-d.jpg',1,'2021-04-23 15:50:52','2021-04-23 15:50:52'),(33894,'JABONERA ISO CROMO','MOEN','876764','DN0766CH',640.000,'https://cdn.homedepot.com.mx/productos/876764/876764-d.jpg',1,'2021-04-23 15:50:52','2021-04-23 15:50:52'),(33895,'GANCHO ISO CROMO','MOEN','876713','DN0703CH',365.000,'https://cdn.homedepot.com.mx/productos/876713/876713-d.jpg',1,'2021-04-23 15:50:52','2021-04-23 15:50:52'),(33896,'CEPILLERA ISO CROMO','MOEN','876693','DN0744CH',650.000,'https://cdn.homedepot.com.mx/productos/876693/876693-d.jpg',1,'2021-04-23 15:50:52','2021-04-23 15:50:52'),(33897,'JUEGO DE ACCESORIOS PARA BAÑO PRESTON 6 PIEZAS PEWTER MATE','MOEN','858325','ITLDN8494MPW',1650.000,'https://cdn.homedepot.com.mx/productos/858325/858325-d.jpg',1,'2021-04-23 15:50:53','2021-04-23 15:50:53'),(33898,'JUEGO DE ACCESORIOS PARA BAÑO PRESTON 6 PIEZAS CROMO','MOEN','858317','ITLDN8494CH',1455.000,'https://cdn.homedepot.com.mx/productos/858317/858317-d.jpg',1,'2021-04-23 15:50:53','2021-04-23 15:50:53'),(33899,'JUEGO DE ACCESORIOS PARA BAÑO ASPÉN 6 PIEZAS CROMO','MOEN','858262','ITL5894CH',1215.000,'https://cdn.homedepot.com.mx/productos/858262/858262-d.jpg',1,'2021-04-23 15:50:53','2021-04-23 15:50:53'),(33900,'TOALLERO EXPLORA CROMO HELVEX','HELVEX','803147',NULL,899.000,'https://cdn.homedepot.com.mx/productos/803147/803147-d.jpg',1,'2021-04-23 15:50:53','2021-04-23 15:50:53'),(33901,'PORTARROLLOS DE PAPEL HIGIÉNICO BUILDERS 23.7 X 4.9 CM PLATA GLACIER BAY','GLACIER BAY','800416','20058-2004',399.000,'https://cdn.homedepot.com.mx/productos/800416/800416-d.jpg',1,'2021-04-23 15:50:54','2021-04-23 15:50:54'),(33902,'PORTARROLLOS BUILDERS 9 1/2 PULGADAS PLATA GLACIER BAY','GLACIER BAY','800412','20058-2001',349.000,'https://cdn.homedepot.com.mx/productos/800412/800412-d.jpg',1,'2021-04-23 15:50:54','2021-04-23 15:50:54'),(33903,'PORTAROLLOS DE PAPEL HIGIÉNICO 24.1 X 5.1 CM CHOCOLATE GLACIER BAY','GLACIER BAY','800408','20058-2016',249.000,'https://cdn.homedepot.com.mx/productos/800408/800408-d.jpg',1,'2021-04-23 15:50:54','2021-04-23 15:50:54'),(33904,'BUILDERS TOALLERO DE 65.7 CM PLATA GLACIER BAY','GLACIER BAY','800404','800404',599.000,'https://cdn.homedepot.com.mx/productos/800404/800404-d.jpg',1,'2021-04-23 15:50:54','2021-04-23 15:50:54'),(33905,'TOALLERO BUILDERS DE 65.7 CM PLATA GLACIER BAY','GLACIER BAY','800400','20058-0201',535.000,'https://cdn.homedepot.com.mx/productos/800400/800400-d.jpg',1,'2021-04-23 15:50:54','2021-04-23 15:50:54'),(33906,'ARO PARA TOALLA GRIS GLACIER BAY','GLACIER BAY','800388','20058-0504',475.000,'https://cdn.homedepot.com.mx/productos/800388/800388-d.jpg',1,'2021-04-23 15:50:55','2021-04-23 15:50:55'),(33907,'TOALLERO ARO BUILDERS CROMO','GLACIER BAY','800384','20058-0501',435.000,'https://cdn.homedepot.com.mx/productos/800384/800384-d.jpg',1,'2021-04-23 15:50:55','2021-04-23 15:50:55'),(33908,'ARO PARA TOALLA 15.2 X 17.2 CM CHOCOLATE GLACIER BAY','GLACIER BAY','800380','20058-0516',299.000,'https://cdn.homedepot.com.mx/productos/800380/800380-d.jpg',1,'2021-04-23 15:50:55','2021-04-23 15:50:55'),(33909,'GANCHO PARA BATA ROBE HOOK DE 3.5 PULGADAS PLATA GLACIER BAY','GLACIER BAY','800348','20058-0304',349.000,'https://cdn.homedepot.com.mx/productos/800348/800348-d.jpg',1,'2021-04-23 15:50:55','2021-04-23 15:50:55'),(33910,'CORTINERO AJUSTABLE 183 CM BLANCO OXAL','OXAL','730540','-',259.000,'https://cdn.homedepot.com.mx/productos/730540/730540-d.jpg',1,'2021-04-23 15:50:56','2021-04-23 15:50:56'),(33911,'CORTINERO AJUSTABLE DE 105 A 183 CM BEIGE OXAL','OXAL','707987','Ajustable',259.000,'https://cdn.homedepot.com.mx/productos/707987/707987-d.jpg',1,'2021-04-23 15:50:56','2021-04-23 15:50:56'),(33912,'REPISA CHOCOLATE DOBLE NIVEL PARA PARED','BATH ACCENTS','601032','2331ORB',329.000,'https://cdn.homedepot.com.mx/productos/601032/601032-d.jpg',1,'2021-04-23 15:50:56','2021-04-23 15:50:56'),(33913,'AHORRA ESPACIOS DE 3 REPISAS CROMADO','BATH ACCENTS','600992','2349SS',719.000,'https://cdn.homedepot.com.mx/productos/600992/600992-d.jpg',1,'2021-04-23 15:50:56','2021-04-23 15:50:56'),(33914,'JUEGO DE ACCESORIOS PARA BAÑO METAL 6 PIEZAS','MOEN','600357','ITLDN8494BN',1595.000,'https://cdn.homedepot.com.mx/productos/600357/600357-d.jpg',1,'2021-04-23 15:50:56','2021-04-23 15:50:56'),(33915,'RIEL FLEXIBLE PARA CORTINA DE BAÑO BLANCO','DUSCHY','567789',NULL,749.000,'https://cdn.homedepot.com.mx/productos/567789/567789-d.jpg',1,'2021-04-23 15:50:57','2021-04-23 15:50:57'),(33916,'TOALLERO DE ARGOLLA VILLETA CROMO','MOEN','546666','Y3686CH',415.000,'https://cdn.homedepot.com.mx/productos/546666/546666-d.jpg',1,'2021-04-23 15:50:57','2021-04-23 15:50:57'),(33917,'JABONERA VILLETA CROMO','MOEN','546343','Y3666CH',370.000,'https://cdn.homedepot.com.mx/productos/546343/546343-d.jpg',1,'2021-04-23 15:50:57','2021-04-23 15:50:57'),(33918,'PORTACEPILLOS VILLETA 12.6 CM PLATA MOEN','MOEN','546256','Y3644CH',380.000,'https://cdn.homedepot.com.mx/productos/546256/546256-d.jpg',1,'2021-04-23 15:50:57','2021-04-23 15:50:57'),(33919,'TOALLERO DE BARRA DE 24 PULGADAS VILLETA CROMO','MOEN','545563','Y3624CH',685.000,'https://cdn.homedepot.com.mx/productos/545563/545563-d.jpg',1,'2021-04-23 15:50:58','2021-04-23 15:50:58'),(33920,'PORTARROLLO VILLETA CROMO','MOEN','544566','Y3608CH',540.000,'https://cdn.homedepot.com.mx/productos/544566/544566-d.jpg',1,'2021-04-23 15:50:58','2021-04-23 15:50:58'),(33921,'GANCHO DOBLE PARA BAÑO VILLETA CROMO','MOEN','544452','Y3603CH',305.000,'https://cdn.homedepot.com.mx/productos/544452/544452-d.jpg',1,'2021-04-23 15:50:58','2021-04-23 15:50:58'),(33922,'TOALLERO DE ARGOLLA CASTLEBY CROMO','INSPIRATIONS','544401','Y2586CH',375.000,'https://cdn.homedepot.com.mx/productos/544401/544401-d.jpg',1,'2021-04-23 15:50:58','2021-04-23 15:50:58'),(33923,'TOALLERO DE BARRA 24 PULGADAS CASTLEBY CROMO','MOEN','543849','Y2524CH',570.000,'https://cdn.homedepot.com.mx/productos/543849/543849-d.jpg',1,'2021-04-23 15:50:58','2021-04-23 15:50:58'),(33924,'TOALLERO DE BARRA 18 PULGADAS CASTLEBY CROMO','MOEN','543542','Y2518CH',540.000,'https://cdn.homedepot.com.mx/productos/543542/543542-d.jpg',1,'2021-04-23 15:50:59','2021-04-23 15:50:59'),(33925,'PORTARROLLO CASTLEBY CROMO','MOEN','543392','Y2508CH',465.000,'https://cdn.homedepot.com.mx/productos/543392/543392-d.jpg',1,'2021-04-23 15:50:59','2021-04-23 15:50:59'),(33926,'GANCHO CASTLEBY CROMO','MOEN','542746','Y2503CH',295.000,'https://cdn.homedepot.com.mx/productos/542746/542746-d.jpg',1,'2021-04-23 15:50:59','2021-04-23 15:50:59'),(33927,'TOALLERO DE ARGOLLA ASPEN BLANCO','MOEN','542675','5886W',289.000,'https://cdn.homedepot.com.mx/productos/542675/542675-d.jpg',1,'2021-04-23 15:50:59','2021-04-23 15:50:59'),(33928,'JABONERA ASPEN BLANCO','MOEN','542596','5836W',205.000,'https://cdn.homedepot.com.mx/productos/542596/542596-d.jpg',1,'2021-04-23 15:50:59','2021-04-23 15:50:59'),(33929,'CEPILLERA ASPEN BLANCO','MOEN','542431','5834W',209.000,'https://cdn.homedepot.com.mx/productos/542431/542431-d.jpg',1,'2021-04-23 15:51:00','2021-04-23 15:51:00'),(33930,'TOALLERO DE BARRA DE 24 PULGADAS ASPEN BLANCO','MOEN','541982','5824W',415.000,'https://cdn.homedepot.com.mx/productos/541982/541982-d.jpg',1,'2021-04-23 15:51:00','2021-04-23 15:51:00'),(33931,'PORTARROLLO ASPEN BLANCO','MOEN','541627','5808W',345.000,'https://cdn.homedepot.com.mx/productos/541627/541627-d.jpg',1,'2021-04-23 15:51:00','2021-04-23 15:51:00'),(33932,'GANCHO ASPEN BLANCO','MOEN','541339','5802W',165.000,'https://cdn.homedepot.com.mx/productos/541339/541339-d.jpg',1,'2021-04-23 15:51:00','2021-04-23 15:51:00'),(33933,'AGARRADERA PARA BAÑO DE 9 PULGADAS NÍQUEL','MOEN','506480','LR2250DBN',410.000,'https://cdn.homedepot.com.mx/productos/506480/506480-d.jpg',1,'2021-04-23 15:51:00','2021-04-23 15:51:00'),(33934,'AGARRADERA PARA BAÑO DE 9 PULGADAS CROMO','MOEN','506477','LR2250DCH',410.000,'https://cdn.homedepot.com.mx/productos/506477/506477-d.jpg',1,'2021-04-23 15:51:01','2021-04-23 15:51:01'),(33935,'AGARRADERA PARA BAÑO DE 9 PULGADAS BRONCE','MOEN','506474','LR2250DOWB',410.000,'https://cdn.homedepot.com.mx/productos/506474/506474-d.jpg',1,'2021-04-23 15:51:01','2021-04-23 15:51:01'),(33936,'PORTA ROLLOS DE ABS (DE PLÁSTICO INDUSTRIAL)','BATH STYLES','500315','7000000',115.000,'https://cdn.homedepot.com.mx/productos/500315/500315-d.jpg',1,'2021-04-23 15:51:01','2021-04-23 15:51:01'),(33937,'PORTA ROLLOS CROMADO PARA PISO','BATH ACCENTS','500308','2340SS',397.000,'https://cdn.homedepot.com.mx/productos/500308/500308-d.jpg',1,'2021-04-23 15:51:01','2021-04-23 15:51:01'),(33946,'JABONERA SENCILLA CLASICA CROMO','HELVEX','970069',NULL,569.000,'https://cdn.homedepot.com.mx/productos/970069/970069-d.jpg',1,'2021-04-23 15:51:38','2021-04-23 15:51:38'),(33947,'JABONERA SENCILLA 13.7 X 6.1 CM PLATA HELVEX','HELVEX','970050','208',615.000,'https://cdn.homedepot.com.mx/productos/970050/970050-d.jpg',1,'2021-04-23 15:51:38','2021-04-23 15:51:38'),(33948,'GANCHO DOBLE CLÁSICA II 6.1 X 9.6 X 5.4 CM PLATA HELVEX','HELVEX','970042','206',415.000,'https://cdn.homedepot.com.mx/productos/970042/970042-d.jpg',1,'2021-04-23 15:51:39','2021-04-23 15:51:39'),(33949,'PORTA TOALLAS MÚLTIPLE 62.5 X 22.4 CM PLATA HELVEX','HELVEX','965584','210',2489.000,'https://cdn.homedepot.com.mx/productos/965584/965584-d.jpg',1,'2021-04-23 15:51:39','2021-04-23 15:51:39'),(33950,'PORTA PAPEL 21.3 X 8.4 CM PLATA HELVEX','HELVEX','965568','217',859.000,'https://cdn.homedepot.com.mx/productos/965568/965568-d.jpg',1,'2021-04-23 15:51:39','2021-04-23 15:51:39'),(33951,'PORTACEPILLOS 12.7 CM PLATA HELVEX','HELVEX','959006','207',535.000,'https://cdn.homedepot.com.mx/productos/959006/959006-d.jpg',1,'2021-04-23 15:51:39','2021-04-23 15:51:39'),(33952,'CORTINERO AJUSTABLE DE 150 A 280 CM GRIS OSCURO OXAL','OXAL','937124','Ajustable',389.000,'https://cdn.homedepot.com.mx/productos/937124/937124-d.jpg',1,'2021-04-23 15:51:40','2021-04-23 15:51:40'),(33953,'TOALLERO DE BARRA DOBLE DE 24 PULGADAS ISO NÍQUEL','MOEN','995817','DN0722BN',1180.000,'https://cdn.homedepot.com.mx/productos/995817/995817-d.jpg',1,'2021-04-23 17:13:28','2021-04-23 17:13:28'),(33954,'TOALLERO DE ARGOLLA ISO NÍQUEL','MOEN','995797','DN0786BN',800.000,'https://cdn.homedepot.com.mx/productos/995797/995797-d.jpg',1,'2021-04-23 17:13:28','2021-04-23 17:13:28'),(33955,'TOALLERO DE BARRA DE 18 PULGADAS ISO NÍQUEL','MOEN','995770','DN0718BN',1055.000,'https://cdn.homedepot.com.mx/productos/995770/995770-d.jpg',1,'2021-04-23 17:13:28','2021-04-23 17:13:28'),(33956,'JABONERA ISO NÍQUEL','MOEN','995746','DN0766BN',860.000,'https://cdn.homedepot.com.mx/productos/995746/995746-d.jpg',1,'2021-04-23 17:13:28','2021-04-23 17:13:28'),(33957,'GANCHO SENCILLO DE ACERO MOEN','MOEN','995703','DN0703BN',495.000,'https://cdn.homedepot.com.mx/productos/995703/995703-d.jpg',1,'2021-04-23 17:13:28','2021-04-23 17:13:28'),(33958,'CEPILLERA ISO NÍQUEL','MOEN','995667','DN0744BN',890.000,'https://cdn.homedepot.com.mx/productos/995667/995667-d.jpg',1,'2021-04-23 17:13:29','2021-04-23 17:13:29'),(33959,'TOALLERO DE BARRA CLÁSICA II CROMO','HELVEX','971555',NULL,1245.000,'https://cdn.homedepot.com.mx/productos/971555/971555-d.jpg',1,'2021-04-23 17:13:29','2021-04-23 17:13:29'),(33960,'TOALLERO DE ARGOLLA CLÁSICA 21.1 X 11.9 CM PLATA HELVEX','HELVEX','971547','209',625.000,'https://cdn.homedepot.com.mx/productos/971547/971547-d.jpg',1,'2021-04-23 17:13:29','2021-04-23 17:13:29');

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `migrations` */

insert  into `migrations`(`id`,`migration`,`batch`) values (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_resets_table',1),(3,'2019_05_03_000001_create_customer_columns',1),(4,'2019_05_03_000002_create_subscriptions_table',1),(5,'2019_05_03_000003_create_subscription_items_table',1),(6,'2019_08_19_000000_create_failed_jobs_table',1),(7,'2020_08_28_122707_create_permission_tables',1),(8,'2020_08_28_172944_create_services_table',1),(9,'2020_08_31_215558_create_providers_table',1),(10,'2020_09_01_095947_create_shops_table',1),(11,'2020_09_02_004630_add_foreigns_to_services_table',1),(12,'2020_09_03_162639_add_currency_to_shops_table',1),(13,'2020_09_03_162952_create_materials_table',1),(14,'2020_09_10_124900_add_latlng_to_shops_table',1),(15,'2020_09_10_230531_add_spanish_to_services_table',1),(16,'2020_09_11_005250_create_payments_table',1),(17,'2020_09_15_121943_create_clients_table',1),(18,'2020_09_16_130401_create_smtps_table',1),(19,'2020_10_02_083103_create_employees_table',1),(20,'2020_10_04_201621_create_expensetypes_table',1),(21,'2020_10_04_201831_create_fixedexpenses_table',1),(22,'2020_10_05_115813_create_cclients_table',1),(23,'2020_10_05_120001_create_projects_table',1),(24,'2020_10_08_113404_create_cmaterials_table',1),(25,'2020_10_09_080111_add_image_to_users_table',1),(26,'2020_10_13_143120_create_cquotes_table',1),(27,'2020_10_16_121515_create_transactions_table',1),(28,'2020_10_29_094101_create_quotegroups_table',1),(29,'2020_11_02_112744_create_cservices_table',1),(30,'2020_11_03_102847_create_quoteservices_table',1),(31,'2020_11_04_123543_create_quoteemployees_table',1),(32,'2020_11_04_140621_add_logoimage_to_users_table',1),(33,'2020_11_10_093243_add_total_to_cquotes_table',1),(34,'2020_11_11_135849_create_quotecomments_table',1),(35,'2020_11_13_104449_create_quoteitems_table',1),(36,'2020_11_13_104624_create_quotematerials_table',1),(37,'2020_11_18_112546_create_terms_table',1),(38,'2020_11_27_083354_create_db_status_table',1),(39,'2020_11_27_094217_add_latlng_to_clients_table',1),(40,'2020_12_01_123112_create_public_quotes_table',1),(41,'2020_12_11_081150_add_invoice_number_to_cquotes_table',1),(42,'2020_12_11_131208_add_invoice_status_to_cquotes_table',1),(43,'2020_12_11_152223_add_is_quote_to_quotecomments_table',1),(44,'2021_01_06_170335_add_google_id_to_users_table',1),(45,'2021_01_06_201302_add_facebook_id_to_users_table',1),(46,'2021_01_20_090511_add_addline_to_cclients_table',1),(47,'2021_01_20_093436_add_api_token_to_providers_table',1),(48,'2021_01_25_084549_add_provider_to_cmaterials_table',1),(49,'2021_01_29_010810_create_promocodes_table',1);

/*Table structure for table `model_has_permissions` */

DROP TABLE IF EXISTS `model_has_permissions`;

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `model_has_permissions` */

/*Table structure for table `model_has_roles` */

DROP TABLE IF EXISTS `model_has_roles`;

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `model_has_roles` */

insert  into `model_has_roles`(`role_id`,`model_type`,`model_id`) values (1,'App\\User',1),(4,'App\\User',3),(5,'App\\User',2),(5,'App\\User',3);

/*Table structure for table `password_resets` */

DROP TABLE IF EXISTS `password_resets`;

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `password_resets` */

/*Table structure for table `payments` */

DROP TABLE IF EXISTS `payments`;

CREATE TABLE `payments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `country` varchar(70) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `numberofusers` bigint(20) NOT NULL,
  `currency` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` bigint(20) NOT NULL,
  `stripe_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stripeprice_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `payments` */

insert  into `payments`(`id`,`country`,`name`,`description`,`numberofusers`,`currency`,`price`,`stripe_id`,`stripeprice_id`,`created_at`,`updated_at`) values (1,'Mexico','Gold','<p>Good</p>',12,'USD',100,'prod_Iv765tpVnjHZJD','plan_Iv76GmHhHeMaZP','2021-02-10 10:38:27','2021-02-10 11:26:51'),(2,'Mexico','Silver','<p>Good</p>',5,'USD',10,'prod_Iv6Nu5ge88gfSa','plan_Iv6NLx1gL7lJ60','2021-02-10 10:38:40','2021-02-10 10:41:53'),(3,'Mexico','Bronze','<p>Good</p>',1,'USD',1,'prod_Iv6Q4EfIEWdcjl','plan_Iv6Qm7ycryRYgy','2021-02-10 10:39:35','2021-02-10 10:44:48');

/*Table structure for table `permissions` */

DROP TABLE IF EXISTS `permissions`;

CREATE TABLE `permissions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `permissions` */

insert  into `permissions`(`id`,`name`,`guard_name`,`created_at`,`updated_at`) values (1,'Access Admin','web','2021-02-10 10:35:07','2021-02-10 10:35:07'),(2,'Access Roles','web','2021-02-10 10:35:07','2021-02-10 10:35:07'),(3,'List Users','web','2021-02-10 10:35:07','2021-02-10 10:35:07'),(4,'New Users','web','2021-02-10 10:35:08','2021-02-10 10:35:08'),(5,'Edit Users','web','2021-02-10 10:35:08','2021-02-10 10:35:08'),(6,'Delete Users','web','2021-02-10 10:35:08','2021-02-10 10:35:08'),(7,'List Services','web','2021-02-10 10:35:08','2021-02-10 10:35:08'),(8,'New Services','web','2021-02-10 10:35:08','2021-02-10 10:35:08'),(9,'Edit Services','web','2021-02-10 10:35:08','2021-02-10 10:35:08'),(10,'Delete Services','web','2021-02-10 10:35:08','2021-02-10 10:35:08'),(11,'List Providers','web','2021-02-10 10:35:08','2021-02-10 10:35:08'),(12,'New Providers','web','2021-02-10 10:35:08','2021-02-10 10:35:08'),(13,'Edit Providers','web','2021-02-10 10:35:08','2021-02-10 10:35:08'),(14,'Delete Providers','web','2021-02-10 10:35:08','2021-02-10 10:35:08'),(15,'List Shops','web','2021-02-10 10:35:08','2021-02-10 10:35:08'),(16,'New Shops','web','2021-02-10 10:35:08','2021-02-10 10:35:08'),(17,'Edit Shops','web','2021-02-10 10:35:09','2021-02-10 10:35:09'),(18,'Delete Shops','web','2021-02-10 10:35:09','2021-02-10 10:35:09'),(19,'List Materials','web','2021-02-10 10:35:09','2021-02-10 10:35:09'),(20,'New Materials','web','2021-02-10 10:35:09','2021-02-10 10:35:09'),(21,'Edit Materials','web','2021-02-10 10:35:09','2021-02-10 10:35:09'),(22,'Delete Materials','web','2021-02-10 10:35:09','2021-02-10 10:35:09'),(23,'List Payments','web','2021-02-10 10:35:09','2021-02-10 10:35:09'),(24,'New Payments','web','2021-02-10 10:35:09','2021-02-10 10:35:09'),(25,'Edit Payments','web','2021-02-10 10:35:09','2021-02-10 10:35:09'),(26,'Delete Payments','web','2021-02-10 10:35:09','2021-02-10 10:35:09'),(27,'List Clients','web','2021-02-10 10:35:09','2021-02-10 10:35:09'),(28,'New Clients','web','2021-02-10 10:35:10','2021-02-10 10:35:10'),(29,'Edit Clients','web','2021-02-10 10:35:10','2021-02-10 10:35:10'),(30,'Delete Clients','web','2021-02-10 10:35:10','2021-02-10 10:35:10'),(31,'Employee Administrative','web','2021-02-10 10:35:10','2021-02-10 10:35:10'),(32,'Employee Sales','web','2021-02-10 10:35:10','2021-02-10 10:35:10');

/*Table structure for table `projects` */

DROP TABLE IF EXISTS `projects`;

CREATE TABLE `projects` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `client` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cclient_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `projects_name_unique` (`name`),
  KEY `projects_cclient_id_foreign` (`cclient_id`),
  CONSTRAINT `projects_cclient_id_foreign` FOREIGN KEY (`cclient_id`) REFERENCES `cclients` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `projects` */

/*Table structure for table `promocodes` */

DROP TABLE IF EXISTS `promocodes`;

CREATE TABLE `promocodes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `discount` double(10,2) NOT NULL,
  `duration` int(11) NOT NULL,
  `active` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `promocodes` */

/*Table structure for table `providers` */

DROP TABLE IF EXISTS `providers`;

CREATE TABLE `providers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `companyname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `addline1` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `addline2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `api_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `providers_companyname_unique` (`companyname`),
  UNIQUE KEY `providers_api_token_unique` (`api_token`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `providers` */

insert  into `providers`(`id`,`companyname`,`addline1`,`addline2`,`country`,`cp`,`user_id`,`created_at`,`updated_at`,`api_token`) values (1,'BO','London',NULL,'United Kingdom','123',3,NULL,'2021-04-19 00:37:17','hq_token_584e890a32a90031c05dd9e21672276f');

/*Table structure for table `public_quotes` */

DROP TABLE IF EXISTS `public_quotes`;

CREATE TABLE `public_quotes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quote_id` bigint(20) NOT NULL,
  `showMaterial` tinyint(1) NOT NULL,
  `showService` tinyint(1) NOT NULL,
  `showEmployee` tinyint(1) NOT NULL,
  `showOnlyTotal` tinyint(1) NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `public_quotes` */

/*Table structure for table `quotecomments` */

DROP TABLE IF EXISTS `quotecomments`;

CREATE TABLE `quotecomments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `cquote_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `isQuote` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `quotecomments_cquote_id_foreign` (`cquote_id`),
  CONSTRAINT `quotecomments_cquote_id_foreign` FOREIGN KEY (`cquote_id`) REFERENCES `cquotes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `quotecomments` */

/*Table structure for table `quoteemployees` */

DROP TABLE IF EXISTS `quoteemployees`;

CREATE TABLE `quoteemployees` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hours` double(15,2) NOT NULL,
  `cost` double(15,2) NOT NULL,
  `total` double(15,2) NOT NULL,
  `employee_id` bigint(20) unsigned NOT NULL,
  `cquote_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `quoteemployees_employee_id_foreign` (`employee_id`),
  KEY `quoteemployees_cquote_id_foreign` (`cquote_id`),
  CONSTRAINT `quoteemployees_cquote_id_foreign` FOREIGN KEY (`cquote_id`) REFERENCES `cquotes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `quoteemployees_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `quoteemployees` */

/*Table structure for table `quotegroups` */

DROP TABLE IF EXISTS `quotegroups`;

CREATE TABLE `quotegroups` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `color` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cquote_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `quotegroups_cquote_id_foreign` (`cquote_id`),
  CONSTRAINT `quotegroups_cquote_id_foreign` FOREIGN KEY (`cquote_id`) REFERENCES `cquotes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `quotegroups` */

/*Table structure for table `quoteitems` */

DROP TABLE IF EXISTS `quoteitems`;

CREATE TABLE `quoteitems` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` bigint(20) NOT NULL,
  `cost` double(15,2) NOT NULL,
  `utility` double(4,2) NOT NULL,
  `total` double(15,2) NOT NULL,
  `quote_group_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `quoteitems_quote_group_id_foreign` (`quote_group_id`),
  CONSTRAINT `quoteitems_quote_group_id_foreign` FOREIGN KEY (`quote_group_id`) REFERENCES `quotegroups` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `quoteitems` */

/*Table structure for table `quotematerials` */

DROP TABLE IF EXISTS `quotematerials`;

CREATE TABLE `quotematerials` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `material_id` bigint(20) NOT NULL,
  `isMine` tinyint(1) NOT NULL,
  `quantity` bigint(20) NOT NULL,
  `quote_item_id` bigint(20) unsigned NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` double(15,2) NOT NULL,
  `provider` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `quotematerials_quote_item_id_foreign` (`quote_item_id`),
  CONSTRAINT `quotematerials_quote_item_id_foreign` FOREIGN KEY (`quote_item_id`) REFERENCES `quoteitems` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `quotematerials` */

/*Table structure for table `quoteservices` */

DROP TABLE IF EXISTS `quoteservices`;

CREATE TABLE `quoteservices` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `provider` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cost` double(15,2) NOT NULL,
  `utility` double(4,2) NOT NULL,
  `price` double(15,2) NOT NULL,
  `cservice_id` bigint(20) unsigned NOT NULL,
  `cquote_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `quoteservices_cservice_id_foreign` (`cservice_id`),
  KEY `quoteservices_cquote_id_foreign` (`cquote_id`),
  CONSTRAINT `quoteservices_cquote_id_foreign` FOREIGN KEY (`cquote_id`) REFERENCES `cquotes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `quoteservices_cservice_id_foreign` FOREIGN KEY (`cservice_id`) REFERENCES `cservices` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `quoteservices` */

/*Table structure for table `role_has_permissions` */

DROP TABLE IF EXISTS `role_has_permissions`;

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `role_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `role_has_permissions` */

insert  into `role_has_permissions`(`permission_id`,`role_id`) values (1,1),(1,2),(3,2),(4,2),(5,2),(6,2),(7,2),(8,2),(9,2),(10,2),(11,2),(12,2),(13,2),(14,2),(15,2),(16,2),(17,2),(18,2),(19,2),(20,2),(21,2),(22,2),(23,2),(24,2),(25,2),(26,2),(27,2),(28,2),(29,2),(30,2),(31,2),(32,2);

/*Table structure for table `roles` */

DROP TABLE IF EXISTS `roles`;

CREATE TABLE `roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `roles` */

insert  into `roles`(`id`,`name`,`guard_name`,`created_at`,`updated_at`) values (1,'Super-Admin','web','2021-02-10 10:35:10','2021-02-10 10:35:10'),(2,'Admin','web','2021-02-10 10:35:10','2021-02-10 10:35:10'),(3,'User','web','2021-02-10 10:35:12','2021-02-10 10:35:12'),(4,'Provider','web','2021-02-10 10:35:12','2021-02-10 10:35:12'),(5,'Client','web','2021-02-10 10:35:12','2021-02-10 10:35:12'),(6,'Test','web','2021-02-10 10:35:12','2021-02-10 10:35:12');

/*Table structure for table `services` */

DROP TABLE IF EXISTS `services`;

CREATE TABLE `services` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `french` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `italian` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `russian` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `german` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `spanish` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `services` */

insert  into `services`(`id`,`name`,`created_at`,`updated_at`,`french`,`italian`,`russian`,`german`,`spanish`) values (1,'service',NULL,NULL,'service','service','service','service','service');

/*Table structure for table `shops` */

DROP TABLE IF EXISTS `shops`;

CREATE TABLE `shops` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `addline1` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `provider_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `currency` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lat` double NOT NULL,
  `lng` double NOT NULL,
  PRIMARY KEY (`id`),
  KEY `shops_provider_id_foreign` (`provider_id`),
  CONSTRAINT `shops_provider_id_foreign` FOREIGN KEY (`provider_id`) REFERENCES `providers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `shops` */

insert  into `shops`(`id`,`name`,`addline1`,`country`,`cp`,`provider_id`,`created_at`,`updated_at`,`currency`,`lat`,`lng`) values (1,'Shop1','London','United Kingdom','1234',1,'2021-04-09 15:14:04','2021-04-09 15:14:04','MXN',51.5183389,-0.1323173);

/*Table structure for table `smtps` */

DROP TABLE IF EXISTS `smtps`;

CREATE TABLE `smtps` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `server` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `port` bigint(20) NOT NULL,
  `security` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `smtps` */

/*Table structure for table `subscription_items` */

DROP TABLE IF EXISTS `subscription_items`;

CREATE TABLE `subscription_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `subscription_id` bigint(20) unsigned NOT NULL,
  `stripe_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stripe_plan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `subscription_items_subscription_id_stripe_plan_unique` (`subscription_id`,`stripe_plan`),
  KEY `subscription_items_stripe_id_index` (`stripe_id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `subscription_items` */

insert  into `subscription_items`(`id`,`subscription_id`,`stripe_id`,`stripe_plan`,`quantity`,`created_at`,`updated_at`) values (1,1,'si_Iv6Nt1UZliOkHp','plan_Iv6NLx1gL7lJ60',1,'2021-02-10 10:41:59','2021-02-10 10:41:59'),(5,2,'si_Iv7c5jcWSPC9Yz','plan_Iv6NLx1gL7lJ60',1,'2021-02-10 11:58:55','2021-02-10 11:58:55'),(7,3,'si_Iv7hUUiEY2EIcB','plan_Iv6NLx1gL7lJ60',1,'2021-02-10 12:04:07','2021-02-10 12:04:07'),(8,4,'si_Iv7r286RBJO5wH','plan_Iv6NLx1gL7lJ60',1,'2021-02-10 12:13:36','2021-02-10 12:13:36'),(10,5,'si_Iv7wEoYUWHl2Lz','plan_Iv6NLx1gL7lJ60',1,'2021-02-10 12:18:41','2021-02-10 12:18:41'),(11,6,'si_Iv8VoAq5keweq5','plan_Iv6Qm7ycryRYgy',1,'2021-02-10 12:54:15','2021-02-10 12:54:15'),(12,7,'si_Iv8cI2191ibVYA','plan_Iv6NLx1gL7lJ60',1,'2021-02-10 13:01:23','2021-02-10 13:01:23'),(13,8,'si_Iv8fwXMQjLLPau','plan_Iv6Qm7ycryRYgy',1,'2021-02-10 13:03:58','2021-02-10 13:03:58'),(14,9,'si_Iv8g5nvsB2y4uV','plan_Iv6NLx1gL7lJ60',1,'2021-02-10 13:05:15','2021-02-10 13:05:15'),(15,10,'si_IvQX0XxiZLjg06','plan_Iv6NLx1gL7lJ60',1,'2021-02-11 07:32:00','2021-02-11 07:32:00'),(16,11,'si_IvQZmFmIqO99n3','plan_Iv6NLx1gL7lJ60',1,'2021-02-11 07:33:48','2021-02-11 07:33:48'),(17,12,'si_IvQgxSdUqfrVT6','plan_Iv6NLx1gL7lJ60',1,'2021-02-11 07:41:24','2021-02-11 07:41:24'),(18,13,'si_Ix0z03jGf9WxIt','plan_Iv6NLx1gL7lJ60',1,'2021-02-15 13:15:52','2021-02-15 13:15:52'),(19,14,'si_Ix13zMjoGOxVYT','plan_Iv6Qm7ycryRYgy',1,'2021-02-15 13:19:55','2021-02-15 13:19:55'),(20,15,'si_Ix13Yevft0WRuF','plan_Iv6Qm7ycryRYgy',1,'2021-02-15 13:20:15','2021-02-15 13:20:15'),(21,16,'si_JGtTV7BB01Etsb','plan_Iv6Qm7ycryRYgy',1,'2021-04-09 14:50:00','2021-04-09 14:50:00');

/*Table structure for table `subscriptions` */

DROP TABLE IF EXISTS `subscriptions`;

CREATE TABLE `subscriptions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stripe_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stripe_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stripe_plan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `trial_ends_at` timestamp NULL DEFAULT NULL,
  `ends_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `subscriptions_user_id_stripe_status_index` (`user_id`,`stripe_status`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `subscriptions` */

insert  into `subscriptions`(`id`,`user_id`,`name`,`stripe_id`,`stripe_status`,`stripe_plan`,`quantity`,`trial_ends_at`,`ends_at`,`created_at`,`updated_at`) values (1,2,'default','sub_Iv6NKwpTi5RMIs','trialing','plan_Iv6NLx1gL7lJ60',1,'2021-02-12 10:41:56','2021-02-12 10:41:56','2021-02-10 10:41:59','2021-02-10 10:44:52'),(2,2,'default','sub_Iv6QuRdPvzqjRT','active','plan_Iv6NLx1gL7lJ60',1,NULL,'2021-03-10 11:40:06','2021-02-10 10:44:55','2021-02-15 13:41:46'),(3,3,'default','sub_Iv7gsjIvZemaC4','canceled','plan_Iv6NLx1gL7lJ60',1,NULL,'2021-02-10 12:10:43','2021-02-10 12:03:21','2021-02-10 12:10:43'),(4,3,'default','sub_Iv7r5YmwFydEuM','canceled','plan_Iv6NLx1gL7lJ60',1,'2021-02-12 12:13:32','2021-02-10 12:13:48','2021-02-10 12:13:36','2021-02-10 12:13:48'),(5,3,'default','sub_Iv7ufJ61u6xcle','active','plan_Iv6NLx1gL7lJ60',1,NULL,'2021-03-10 12:18:37','2021-02-10 12:16:42','2021-02-10 12:54:09'),(6,3,'default','sub_Iv8V4u1zwl7foV','canceled','plan_Iv6Qm7ycryRYgy',1,NULL,'2021-02-10 13:01:19','2021-02-10 12:54:15','2021-02-10 13:01:19'),(7,3,'default','sub_Iv8cCho3imkJdT','active','plan_Iv6NLx1gL7lJ60',1,NULL,'2021-03-10 13:03:16','2021-02-10 13:01:23','2021-02-10 13:03:10'),(8,3,'default','sub_Iv8fs8xTWRDy0T','canceled','plan_Iv6Qm7ycryRYgy',1,NULL,'2021-02-10 13:05:10','2021-02-10 13:03:58','2021-02-10 13:05:10'),(9,3,'default','sub_Iv8ghsE9mw9aoL','canceled','plan_Iv6NLx1gL7lJ60',1,NULL,'2021-02-11 07:31:56','2021-02-10 13:05:15','2021-02-11 07:31:56'),(10,3,'default','sub_IvQXneVXkFUkxf','canceled','plan_Iv6NLx1gL7lJ60',1,NULL,'2021-02-11 07:33:44','2021-02-11 07:32:00','2021-02-11 07:33:44'),(11,3,'default','sub_IvQZSSt97lEJUR','canceled','plan_Iv6NLx1gL7lJ60',1,NULL,'2021-02-11 07:41:20','2021-02-11 07:33:48','2021-02-11 07:41:20'),(12,3,'default','sub_IvQgB71YtsDfAn','canceled','plan_Iv6NLx1gL7lJ60',1,NULL,'2021-02-15 13:15:48','2021-02-11 07:41:24','2021-02-15 13:15:48'),(13,3,'default','sub_Ix0zCWHivjB7F6','active','plan_Iv6NLx1gL7lJ60',1,NULL,NULL,'2021-02-15 13:15:52','2021-02-15 13:15:52'),(14,3,'default','sub_Ix13ZBiiqdAhN2','trialing','plan_Iv6Qm7ycryRYgy',1,'2021-02-17 13:19:52',NULL,'2021-02-15 13:19:55','2021-02-15 13:19:55'),(15,3,'default','sub_Ix13QrEhVNkYIP','trialing','plan_Iv6Qm7ycryRYgy',1,'2021-02-17 13:20:12',NULL,'2021-02-15 13:20:15','2021-02-15 13:20:15'),(16,2,'default','sub_JGtTSWUouYzw8x','trialing','plan_Iv6Qm7ycryRYgy',1,'2021-04-11 14:49:55',NULL,'2021-04-09 14:50:00','2021-04-09 14:50:00');

/*Table structure for table `terms` */

DROP TABLE IF EXISTS `terms`;

CREATE TABLE `terms` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `terms` */

insert  into `terms`(`id`,`type`,`description`,`created_at`,`updated_at`) values (1,'Terms(English)','','2021-02-10 10:35:12','2021-02-10 10:35:12'),(2,'Terms(Spanish)','','2021-02-10 10:35:12','2021-02-10 10:35:12'),(3,'Terms(French)','','2021-02-10 10:35:12','2021-02-10 10:35:12'),(4,'Terms(Italian)','','2021-02-10 10:35:12','2021-02-10 10:35:12'),(5,'Terms(Russian)','','2021-02-10 10:35:12','2021-02-10 10:35:12'),(6,'Terms(German)','','2021-02-10 10:35:12','2021-02-10 10:35:12'),(7,'Conditions(English)','','2021-02-10 10:35:12','2021-02-10 10:35:12'),(8,'Conditions(Spanish)','','2021-02-10 10:35:12','2021-02-10 10:35:12'),(9,'Conditions(French)','','2021-02-10 10:35:12','2021-02-10 10:35:12'),(10,'Conditions(Italian)','','2021-02-10 10:35:12','2021-02-10 10:35:12'),(11,'Conditions(Russian)','','2021-02-10 10:35:12','2021-02-10 10:35:12'),(12,'Conditions(German)','','2021-02-10 10:35:13','2021-02-10 10:35:13');

/*Table structure for table `transactions` */

DROP TABLE IF EXISTS `transactions`;

CREATE TABLE `transactions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `transaction_date` datetime NOT NULL,
  `type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `currency` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` double(15,5) NOT NULL,
  `chargeid` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `client_id` bigint(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `transactions` */

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `isdelete` tinyint(1) NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `stripe_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `card_brand` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `card_last_four` varchar(4) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `trial_ends_at` timestamp NULL DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logoimage` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `google_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `facebook_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `users_stripe_id_index` (`stripe_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`name`,`phone`,`email`,`email_verified_at`,`password`,`isdelete`,`remember_token`,`created_at`,`updated_at`,`stripe_id`,`card_brand`,`card_last_four`,`trial_ends_at`,`image`,`logoimage`,`google_id`,`facebook_id`) values (1,'admin','0725684235','admin@gmail.com','2020-09-21 00:10:49','$2y$10$pyrbtjO.OAM3b8n5lCdPyubM28w8B0ffQJVdlTPpWS2P9wZdR8hXi',0,NULL,'2021-02-10 10:35:07','2021-02-10 10:35:07',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(3,'Kate Minghi',NULL,'prince199177@outlook.com','2020-09-21 00:10:49','$2y$10$VI6JadtE0gttJnVge3/8nuwHwhx0eFbJYD3BcpX8JLKqRR0r4m8Im',0,NULL,'2021-02-10 12:02:39','2021-04-19 00:37:34','cus_Iv7g2jvLjM8WqS','visa','4242',NULL,'/storage/avatars/b4dc9fb6f00037b6477f467056fb633c.png',NULL,NULL,NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

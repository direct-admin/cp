-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 18, 2015 at 09:49 PM
-- Server version: 5.6.12-log
-- PHP Version: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `zncp_core`
--
CREATE DATABASE IF NOT EXISTS `zncp_core` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `zncp_core`;

-- --------------------------------------------------------

--
-- Table structure for table `auth`
--

CREATE TABLE IF NOT EXISTS `auth` (
  `authid` bigint(12) NOT NULL AUTO_INCREMENT,
  `username` varchar(350) NOT NULL,
  `password` varchar(350) NOT NULL,
  `role` int(4) NOT NULL DEFAULT '0',
  `active` int(4) NOT NULL DEFAULT '0',
  `createdon` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`authid`),
  KEY `username` (`username`,`password`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `auth`
--

INSERT INTO `auth` (`authid`, `username`, `password`, `role`, `active`, `createdon`) VALUES
(1, 'administrator', 'EO6BXJ647BjiNN0FELCiZHoWKg8767shbNFLxxE20JI', 0, 0, '2015-05-26 16:37:58');

-- --------------------------------------------------------

--
-- Table structure for table `banip`
--

CREATE TABLE IF NOT EXISTS `banip` (
  `id` bigint(12) NOT NULL AUTO_INCREMENT,
  `ip` varchar(100) NOT NULL,
  `timestamp` varchar(250) NOT NULL,
  `createdon` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `ip` (`ip`,`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `cronjobs`
--

CREATE TABLE IF NOT EXISTS `cronjobs` (
  `jobid` bigint(12) NOT NULL AUTO_INCREMENT,
  `name` varchar(350) NOT NULL,
  `script` longtext NOT NULL,
  `comment` longtext NOT NULL,
  `time` varchar(300) NOT NULL,
  `fullpath` longtext NOT NULL,
  `createdon` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`jobid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `cron_timings`
--

CREATE TABLE IF NOT EXISTS `cron_timings` (
  `tid` bigint(12) NOT NULL AUTO_INCREMENT,
  `unix_timing` varchar(350) NOT NULL,
  `english_timing` varchar(350) NOT NULL,
  PRIMARY KEY (`tid`),
  KEY `unix_timing` (`unix_timing`,`english_timing`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `cron_timings`
--

INSERT INTO `cron_timings` (`tid`, `unix_timing`, `english_timing`) VALUES
(1, '* * * * *', 'Every 1 minute'),
(5, '0 * * * *', 'Every 1 hour'),
(9, '0 0 * * *', 'Every 1 day'),
(10, '0 0 * * 0', 'Every week'),
(11, '0 0 1 * *', 'Every month'),
(8, '0 0,12 * * *', 'Every 12 hours'),
(6, '0 0,2,4,6,8,10,12,14,16,18,20,22 * * *', 'Every 2 hours'),
(7, '0 0,8,16 * * *', 'Every 8 hours'),
(3, '0,10,20,30,40,50 * * * *', 'Every 10 minutes'),
(4, '0,30 * * * *', 'Every 30 minutes'),
(2, '0,5,10,15,20,25,30,35,40,45,50,55 * * * *', 'Every 5 minutes');

-- --------------------------------------------------------

--
-- Table structure for table `dns`
--

CREATE TABLE IF NOT EXISTS `dns` (
  `dnssetid` bigint(12) NOT NULL AUTO_INCREMENT,
  `domainid` bigint(12) NOT NULL,
  `dnsid` varchar(350) NOT NULL,
  `dns_type` varchar(350) NOT NULL,
  `dns_host` varchar(350) NOT NULL,
  `dns_ttl` varchar(350) NOT NULL,
  `dns_target` varchar(350) NOT NULL,
  `dns_texttarget` varchar(350) NOT NULL,
  `dns_priority` varchar(350) NOT NULL,
  `dns_weight` varchar(350) NOT NULL,
  `dns_port` varchar(350) NOT NULL,
  `createdon` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`dnssetid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `dnsmanager`
--

CREATE TABLE IF NOT EXISTS `dnsmanager` (
  `dnsid` bigint(12) NOT NULL AUTO_INCREMENT,
  `domainid` int(12) NOT NULL,
  `domain_name` varchar(350) NOT NULL,
  `createdon` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`dnsid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `domains`
--

CREATE TABLE IF NOT EXISTS `domains` (
  `domainid` bigint(12) NOT NULL AUTO_INCREMENT,
  `domain_name` varchar(500) NOT NULL,
  `www_path` varchar(500) NOT NULL,
  `type` int(4) NOT NULL DEFAULT '0',
  `createdon` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`domainid`),
  KEY `domain_name` (`domain_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ftpuser`
--

CREATE TABLE IF NOT EXISTS `ftpuser` (
  `ftpid` bigint(12) NOT NULL AUTO_INCREMENT,
  `ftpuser` varchar(500) NOT NULL,
  `password` varchar(500) NOT NULL,
  `homedir` varchar(500) NOT NULL,
  `domain` varchar(250) NOT NULL,
  `createdon` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ftpid`),
  KEY `ftpuser` (`ftpuser`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `installers`
--

CREATE TABLE IF NOT EXISTS `installers` (
  `installerid` bigint(12) NOT NULL AUTO_INCREMENT,
  `name` varchar(300) NOT NULL,
  `icon` varchar(350) NOT NULL,
  `file` longtext NOT NULL,
  `createdon` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`installerid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `installers`
--

INSERT INTO `installers` (`installerid`, `name`, `icon`, `file`, `createdon`) VALUES
(1, 'Wordpress', '<i class="fa fa-wordpress"></i>', 'wordpress-installer.php', '2015-08-17 21:09:37');

-- --------------------------------------------------------

--
-- Table structure for table `mailboxes`
--

CREATE TABLE IF NOT EXISTS `mailboxes` (
  `mailboxid` int(12) NOT NULL AUTO_INCREMENT,
  `mailboxname` varchar(500) NOT NULL,
  `password` varchar(250) NOT NULL,
  `domain` varchar(500) NOT NULL,
  `createdon` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`mailboxid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `mysqldb`
--

CREATE TABLE IF NOT EXISTS `mysqldb` (
  `dbid` bigint(12) NOT NULL AUTO_INCREMENT,
  `dbname` varchar(350) NOT NULL,
  `createdon` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`dbid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `mysqlusers`
--

CREATE TABLE IF NOT EXISTS `mysqlusers` (
  `mysqluserid` bigint(12) NOT NULL AUTO_INCREMENT,
  `dbname` varchar(350) NOT NULL,
  `username` varchar(350) NOT NULL,
  `password` varchar(350) NOT NULL,
  `createdon` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`mysqluserid`),
  KEY `dbname` (`dbname`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `session`
--

CREATE TABLE IF NOT EXISTS `session` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data` text CHARACTER SET utf8 NOT NULL,
  `key` tinytext CHARACTER SET utf8 NOT NULL,
  `browser` tinytext CHARACTER SET utf8 NOT NULL,
  `ip` varchar(16) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `webname` varchar(500) NOT NULL,
  `poweredby` varchar(150) NOT NULL,
  `poweredurl` varchar(150) NOT NULL,
  `emailid` varchar(250) NOT NULL,
  `defaultadminlang` varchar(50) NOT NULL DEFAULT 'en',
  `productname` varchar(250) NOT NULL,
  `version` varchar(100) NOT NULL,
  `timezone` varchar(100) NOT NULL,
  `defaultcountry` varchar(10) NOT NULL DEFAULT 'US',
  `dateformat` varchar(25) NOT NULL DEFAULT 'm-d-Y',
  `datetimeformat` varchar(25) NOT NULL,
  `rowsperpage` varchar(10) NOT NULL DEFAULT '25',
  `serialkey` varchar(200) NOT NULL DEFAULT '123456789',
  `failedlogintry` int(4) NOT NULL DEFAULT '3',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `webname`, `poweredby`, `poweredurl`, `emailid`, `defaultadminlang`, `productname`, `version`, `timezone`, `defaultcountry`, `dateformat`, `datetimeformat`, `rowsperpage`, `serialkey`, `failedlogintry`) VALUES
(1, 'Zincksoft Hosting Panel', 'Zincksoft.com', 'http://zincksoft.com', 'info@zincksoft.com', 'en', 'Zincksoft Control Panel', '3.1.0', '###TIMEZONE###', 'US', 'm-d-Y', 'l jS \\of F Y h:i:s A', '25', '###SERIALKEY###', 3);

-- --------------------------------------------------------

--
-- Table structure for table `subdomains`
--

CREATE TABLE IF NOT EXISTS `subdomains` (
  `subdomainid` bigint(12) NOT NULL AUTO_INCREMENT,
  `subname` varchar(500) NOT NULL,
  `domain_name` varchar(500) NOT NULL,
  `www_path` varchar(500) NOT NULL,
  `type` int(4) NOT NULL DEFAULT '0',
  `createdon` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`subdomainid`),
  KEY `domain_name` (`domain_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `system`
--

CREATE TABLE IF NOT EXISTS `system` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `fqdn` varchar(500) NOT NULL,
  `domain` varchar(500) NOT NULL,
  `systemip` varchar(100) NOT NULL,
  `panelport` varchar(12) NOT NULL DEFAULT '786',
  `postfix_access` varchar(500) NOT NULL,
  `proftpd_access` varchar(250) NOT NULL,
  `vhost_url` varchar(500) NOT NULL,
  `vhost_header` longtext NOT NULL,
  `services_namespace` varchar(250) NOT NULL DEFAULT 'service',
  `apache_namespace` varchar(250) NOT NULL DEFAULT 'httpd',
  `apache_reload` varchar(250) NOT NULL DEFAULT 'reload',
  `apache_restart` varchar(250) NOT NULL DEFAULT 'restart',
  `zcli_path` varchar(350) NOT NULL DEFAULT '/etc/zincksoft/cpanel/zcli',
  `refresh_ttl` varchar(200) NOT NULL DEFAULT '21600',
  `retry_ttl` varchar(200) NOT NULL DEFAULT '3600',
  `expire_ttl` varchar(200) NOT NULL DEFAULT '604800',
  `minimum_ttl` varchar(200) NOT NULL DEFAULT '86400',
  `named_path` varchar(350) NOT NULL DEFAULT '/etc/bind/named.conf',
  `zone_path` varchar(350) NOT NULL DEFAULT '/etc/bind/zones',
  `php_exe` varchar(200) NOT NULL DEFAULT 'php',
  `host_dir` varchar(250) NOT NULL DEFAULT '/var/www/html',
  `openbase_seperator` varchar(200) NOT NULL DEFAULT ':',
  `openbase_temp` varchar(200) NOT NULL DEFAULT '/var/tmp/',
  `cron_path` varchar(300) NOT NULL DEFAULT '/var/spool/cron/apache',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `system`
--

INSERT INTO `system` (`id`, `fqdn`, `domain`, `systemip`, `panelport`, `postfix_access`, `proftpd_access`, `vhost_url`, `vhost_header`, `services_namespace`, `apache_namespace`, `apache_reload`, `apache_restart`, `zcli_path`, `refresh_ttl`, `retry_ttl`, `expire_ttl`, `minimum_ttl`, `named_path`, `zone_path`, `php_exe`, `host_dir`, `openbase_seperator`, `openbase_temp`, `cron_path`) VALUES
(1, '###FQDN###', '###DOMAIN###', '###SERVERIP###', '786', '###POSTFIX###', '###PROFTPD###', '/etc/httpd/conf/httpd-vhosts.conf', 'IyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIw0KIyBBcGFjaGUgVkhPU1QgY29uZmlndXJhdGlvbiBmaWxlDQojIEF1dG9tYXRpY2FsbHkgZ2VuZXJhdGVkIGJ5IFppbmNrc29mdCBDb250cm9sIFBhbmVsICMjI1ZFUlNJT04jIyMNCiMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMNCg0KTmFtZVZpcnR1YWxIb3N0ICMjI1NZU1RFTUlQIyMjOiMjI1BPUlQjIyMNCg0KIyBDb25maWd1cmF0aW9uIGZvciBaaW5ja3NvZnQgQ29udHJvbCBQYW5lbCAjIyNWRVJTSU9OIyMjDQo8VmlydHVhbEhvc3QgIyMjU1lTVEVNSVAjIyM6IyMjUE9SVCMjIz4NClNlcnZlckFkbWluIGFkbWluQGxvY2FsaG9zdA0KRG9jdW1lbnRSb290ICIvZXRjL3ppbmNrc29mdC9jcGFuZWwvIg0KQWRkVHlwZSBhcHBsaWNhdGlvbi94LWh0dHBkLXBocCAucGhwDQo8RGlyZWN0b3J5ICIvZXRjL3ppbmNrc29mdC9jcGFuZWwvIj4NCk9wdGlvbnMgRm9sbG93U3ltTGlua3MNCglBbGxvd092ZXJyaWRlIEFsbA0KCU9yZGVyIGFsbG93LGRlbnkNCglBbGxvdyBmcm9tIGFsbA0KPC9EaXJlY3Rvcnk+DQoNCjwvVmlydHVhbEhvc3Q+DQoNCiMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMNCiMgWmluY2tzb2Z0IENvbnRyb2wgUGFuZWwgIyMjVkVSU0lPTiMjIyBnZW5lcmF0ZWQgVkhPU1QgY29uZmlndXJhdGlvbnMgYmVsb3cuLi4uLg0KIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIw==', '###SERVICE_NAMESPACE###', '###APACHE_NAMESPACE###', '###APACHE_RELOAD###', '###APACHE_RESTART###', '###ZCLI_PATH###', '21600', '3600', '604800', '86400', '/etc/bind/etc/named.conf', '/etc/bind/zones', 'php', '/var/www/html', ':', '/var/tmp/', '/var/spool/cron/apache');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

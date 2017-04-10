create database if not exists litcms character set utf8 collate utf8_unicode_ci;
use litcms;

grant all privileges on litcms.* to 'super_user'@'localhost' identified by 'secret';
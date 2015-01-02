<?php

/*

create database dotinstall_contacts_php;
grant all on dotinstall_contacts_php.* to dbuser@localhost identified by '********';

use dotinstall_contacts_php

create table entries (
    id int not null auto_increment primary key,
    name varchar(255),
    email varchar(255),
    memo text,
    created datetime,
    modified datetime
);

*/

define('DSN', 'mysql:host=localhost;dbname=dotinstall_contacts_php');
define('DB_USER', 'dbuser');
define('DB_PASSWORD', 'password');

define('SITE_URL', 'http://192.168.1.7/contact/');
define('ADMIN_URL', SITE_URL.'admin/');

error_reporting(E_ALL & ~E_NOTICE);

session_set_cookie_params(0, '/contact/');





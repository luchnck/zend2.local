<?

/*
Подключение к базе
*/
$user = 'root';
$pass = '';
$host = 'localhost';
//$dbname = 'bar_service';
try
{
$DBH = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);  
$DBH->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION ); 
/*
Подключились
*/
$DBH->prepare("
CREATE DATABASE IF NOT EXISTS bar_service;
USE bar_service;
CREATE TABLE IF NOT EXISTS cable_types (
  id int(11) NOT NULL AUTO_INCREMENT,
  name varchar(100) NOT NULL,
  table_with_marko varchar(30) NOT NULL,
  PRIMARY KEY (id));
INSERT INTO cable_types (name, table_with_marko)
    VALUES  ('Кабели городские телефонные c полиэтиленовой изоляцией (ТППэп)',  'tppep_marko');
INSERT INTO cable_types (name, table_with_marko)
    VALUES  ('Кабели городские высокочастотные для сетей абонентского доступа (КЦПП)',  'kcpp_marko');

CREATE TABLE IF NOT EXISTS tppep_marko (
  params varchar(12) NOT NULL,
  diameter REAL NOT NULL,
  weight int(5) NOT NULL,
  PRIMARY KEY (params));
INSERT INTO tppep_marko (params,diameter,weight)
	VALUES ('5х2х0.4',9.1,57);
INSERT INTO tppep_marko (params,diameter,weight)
	VALUES ('10х2х0.4',10.9,97);
INSERT INTO tppep_marko (params,diameter,weight)
	VALUES ('20х2х0.4',13.1,145);
INSERT INTO tppep_marko (params,diameter,weight)
	VALUES ('30х2х0.4',15.5,201);
INSERT INTO tppep_marko (params,diameter,weight)
	VALUES ('50х2х0.4',18.9,306);
INSERT INTO tppep_marko (params,diameter,weight)
	VALUES ('100х2х0.4',24.9,540);
	
CREATE TABLE IF NOT EXISTS kcppep_marko (
  params varchar(12) NOT NULL,
  diameter REAL NOT NULL,
  weight int(5) NOT NULL,
  PRIMARY KEY (params));
INSERT INTO kcpp_marko (params,diameter,weight)
	VALUES ('5х2х0.4',9.1,57);
INSERT INTO kcpp_marko (params,diameter,weight)
	VALUES ('10х2х0.4',10.9,97);
INSERT INTO kcpp_marko (params,diameter,weight)
	VALUES ('20х2х0.4',13.1,145);
INSERT INTO kcpp_marko (params,diameter,weight)
	VALUES ('30х2х0.4',15.5,201);
INSERT INTO kcpp_marko (params,diameter,weight)
	VALUES ('50х2х0.4',18.9,306);
INSERT INTO kcpp_marko (params,diameter,weight)
	VALUES ('100х2х0.4',24.9,540);
	")->execute();
}  
catch(PDOException $e) {  
    echo $e->getMessage();  
}
?>
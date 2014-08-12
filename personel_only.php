<?

/*
Подключение к базе
*/
$user = 'root';
$pass = '';
$host = 'localhost';
$dbname = 'u883112697_zend2';
try
{
$DBH = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);  
$DBH->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION ); 
/*
Подключились
*/
$DBH->prepare("CREATE TABLE album (
  id int(11) NOT NULL AUTO_INCREMENT,
  artist varchar(100) NOT NULL,
  title varchar(100) NOT NULL,
  PRIMARY KEY (id));
INSERT INTO album (artist, title)
    VALUES  ('The  Military  Wives',  'In  My  Dreams');
INSERT INTO album (artist, title)
    VALUES  ('Adele',  '21');
INSERT INTO album (artist, title)
    VALUES  ('Bruce  Springsteen',  'Wrecking Ball (Deluxe)');
INSERT INTO album (artist, title)
    VALUES  ('Lana  Del  Rey',  'Born  To  Die');
INSERT INTO album (artist, title)
    VALUES  ('Gotye',  'Making  Mirrors');")->execute();
}  
catch(PDOException $e) {  
    echo $e->getMessage();  
}
?>
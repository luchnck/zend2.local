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
USE bar_service;
CREATE TABLE IF NOT EXISTS baraban_types (
  type varchar(4),
  height int(5) NOT NULL,
  width int(5) NOT NULL,
  square REAL NOT NULL,
  volume REAL NOT NULL,
  weight_w_armor int(4) NOT NULL,
  light_weight int(4) NOT NULL,
  PRIMARY KEY (type));
INSERT INTO baraban_types (type,height,width,square,volume,weight_w_armor,light_weight)
    VALUES  ('8',838,350,0.29,0.2,43,34);
INSERT INTO baraban_types (type,height,width,square,volume,weight_w_armor,light_weight)
    VALUES  ('8а',838,520,0.44,0.3,51,37);
INSERT INTO baraban_types (type,height,width,square,volume,weight_w_armor,light_weight)
    VALUES  ('8б',838,620,0.52,0.34,53.5,37);
INSERT INTO baraban_types (type,height,width,square,volume,weight_w_armor,light_weight)
    VALUES  ('10',1044,646,0.67,0.55,56,39);
INSERT INTO baraban_types (type,height,width,square,volume,weight_w_armor,light_weight)
    VALUES  ('10а',1044,864,0.9,0.74,75,55);
	")->execute();
}  
catch(PDOException $e) {  
    echo $e->getMessage();  
}
?>
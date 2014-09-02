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
CREATE TABLE IF NOT EXISTS namotka (
  diameter int(4),
  num_8 int(6),
  num_8a int(6),
  num_8b int(6),
  num_10 int(6),
  num_12 int(6),
  num_12a int(6),
  num_14 int(6),
  num_16 int(6),
  num_17 int(6),
  num_18 int(6),
  num_22 int(6),  
  PRIMARY KEY (diameter));
INSERT INTO namotka (`diameter`, `num_8`, `num_8a`, `num_8b`, `num_10`, `num_12`, `num_12a`, `num_14`) VALUES (7,900,1550,1950,3650,6100,8700,11950);
INSERT INTO namotka (`diameter`, `num_8`, `num_8a`, `num_8b`, `num_10`, `num_12`, `num_12a`, `num_14`) VALUES (8,650,1200,1500,2800,4650,6650,9150);
	")->execute();
}  
catch(PDOException $e) {  
    echo $e->getMessage();  
}
?>
<?php  if(in_array("mysql",PDO::getAvailableDrivers())){
echo " You have PDO for MySQL driver installed ";
 }else{
echo "PDO driver for MySQL is not installed in your system";
 }?>
<!DOCTYPE html>
<html>
<head>
	<title>Applicazione sinistri</title>
</head>
<body>
	<h1>Applicazione sinistri</h1>
	<ul>
		<li><a href="aggiungi_proprietario.php">Aggiungi un proprietario</a></li>
		<li><a href="aggiungi_assicurazione.php">Aggiungi un'assicurazione</a></li>
		<li><a href="aggiungi_sinistro.php">Aggiungi un sinistro</a></li>
		<li><a href="aggiungi_auto.php">Aggiungi un'auto</a></li>
		<li><a href="aggiungi_auto_sinistro.php">Aggiungi un'auto coinvolta in un sinistro</a></li>
		<li><a href="modifica_importo_danno.php">Modifica l'importo del danno ad un'auto coinvolta</a></li>
		<li><a href="elimina_auto_sinistro.php">Elimina un'auto coinvolta in un sinistro</a></li>
		<li><a href="visualizza_sinistro.php">Visualizza i dati relativi ad un sinistro</a></li>
		<li><a href="elenco_sinistri.php">Visualizza l'elenco dei sinistri in un range di date</a></li>
		<li><a href="login.php">Login</a></li>
	</ul>
</body>
</html>

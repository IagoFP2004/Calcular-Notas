<?php
require 'vendor/autoload.php';
use TestClasses\Daw2\Categoria;

$electronica = new Categoria("Electronica");
$consolas = new Categoria("consolas",$electronica);
$microsoft = new Categoria("Microsoft",$consolas);
$seriesX = new Categoria("Series X",$microsoft);

echo $seriesX->getFullName();

?>
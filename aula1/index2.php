<?php
echo "Informe o raio do circulo";
$raio = (float) readline();

define("Pi",3.14159);

$area = Pi * pow($raio, 2);

if ($area > 50) {

    echo "A área circular é maior que 50";
}else{
    echo "A área circular é menor ou igual a 50";
}

?>
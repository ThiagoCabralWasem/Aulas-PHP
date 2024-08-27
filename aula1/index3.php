<?php
  function celsiusToFahrenheit($celsius) {
    return ($celsius * 9/5) + 32;
  }

  function fahrenheitToCelsius($fahrenheit) {
    return ($fahrenheit - 32) * 5/9;
  }

  echo "Insira a temperatura em Celsius: ";
  $celsius = (float) readline();
  echo "A temperatura em Fahrenheit é: " . celsiusToFahrenheit($celsius);

  echo "Insira a temperatura em Fahrenheit: ";
  $fahrenheit = (float) readline();
  echo "A temperatura em Celsius é: " . fahrenheitToCelsius($fahrenheit);

  function isPrime($number) {
    for ($i = 2; $i <= sqrt($number); $i++) {
      if ($number % $i == 0) return false;
    }
    return true;
  }

  echo "Insira um número: ";
  $number = (int) readline();
  echo isPrime($number) ? "O número é primo." : "O número não é primo.";

  function isEven($number) {
    return $number % 2 == 0;
  }

  echo "Insira um número: ";
  $number = (int) readline();
  echo isEven($number) ? "O número é par." : "O número é ímpar.";

  echo "Insira o ano de nascimento: ";
  $birthYear = (int) readline();
  echo "A idade é: " . (date("Y") - $birthYear);

  function minutesToHours($minutes) {
    return floor($minutes / 60) . " horas e " . ($minutes % 60) . " minutos";
  }

  echo "Insira o número de minutos: ";
  $minutes = (int) readline();
  echo "O tempo é: " . minutesToHours($minutes);

  function printTable($number) {
    for ($i = 1; $i <= 10; $i++) {
      echo "$number x $i = " . ($number * $i) . "\n";
    }
  }

  echo "Insira um número: ";
  $number = (int) readline();
  printTable($number);

  function factorial($number) {
    $result = 1;
    for ($i = 1; $i <= $number; $i++) {
      $result *= $i;
    }
    return $result;
  }

  echo "Insira um número: ";
  $number = (int) readline();
  echo "O fatorial é: " . factorial($number);
?>
<!DOCTYPE HTML>
<html lang = "pt-br">
<head>
   <title>Exemplo</title>
   <meta charset = "UTF-8">
</head>
<body>
   
<?php

   $a = $_POST['num1'];
   $b = $_POST['num2'];
   $op= $_POST['operacao'];

echo "Ola sejam bem vindos a minha primeira calculadora";


   if( !empty($op) ) {
      if($op == '+')
         $c = $a + $b;
      else if($op == '-')
         $c = $a - $b;
      else if($op == '*')
         $c = $a*$b;
      else
         $c = $a/$b;

      echo "Resultado;: $c";
   }

?>       
</body>
</html>

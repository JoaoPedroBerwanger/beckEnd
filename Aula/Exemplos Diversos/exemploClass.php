<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    class Fruit{

        public $name;
        public $color;

        function __construct($name, $color){
            $this->name = $name;
            $this->color = $color;
        }

        function set_name($name){
            $this->name = $name;
        }

        function get_name(){
            return $this->name;
        }

        function set_color($color){
            $this->color = $color;
        }

        function get_color(){
            return $this->color;
        }
    }

    $apple = new Fruit("Apple", "Red");
    $banana = new Fruit("Banana", "Yellow");
    $linha = "<br>";

    echo $apple->get_name() . " Color " . $apple->get_color();
    echo $linha;
    echo $banana->get_name() . " Color " . $banana->get_color();

    ?>
</body>
</html>
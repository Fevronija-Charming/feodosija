<?php
// Функция для загрузки переменных из .env файла
function loadEnv($path) {
    if (!file_exists($path)) {
        return;
    }
    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        // Пропуск комментариев
        if (strpos(trim($line), '#') === 0) {
            continue;
        }

        // Разделение по знаку =
        list($name, $value) = explode('=', $line, 2);
        
        $name = trim($name);
        $value = trim($value);

        // Удаление кавычек, если они есть
        if (preg_match('/^(\'|").*(\'|")$/', $value)) {
            $value = substr($value, 1, -1);
        }

        // Установка переменной окружения
        if (!getenv($name)) {
            putenv("$name=$value");
            $_ENV[$name] = $value;
        }
    }
}
// Загружаем файл из корня проекта
loadEnv(__DIR__ . '/.env');
echo "Здарова начальник!<br>";
echo "Начальник привет!<br>";
echo "У нас тут тепло:<br>";
echo "Котлетки в обед.<br>";
echo "<br>";
echo "<br>";
$host=getenv('HOST');
$dbname=getenv("DBNAME");
$password=getenv("PASSWORD");
$username=getenv("USERNAME");
$port=getenv("PORT");
$platok_predstav=["Артикул","Название","Автор платка","Колорит 1","Колорит 2","Колорит 3",
"Колорит 4","Колорит 5","Узор темени","Узор сердцевины","Узор сторон","Узор углов","Узор краёв",
"Соотношение рисунка и орнамента","Нарисованный цветок 1","Нарисованный цветок 2","Нарисованный цветок 3",
"Нарисованный цветок 4","Нарисованный цветок 5","Размер платка","Материал платка","Материал бахромы"];
try {$pdo= new PDO("pgsql:host=$host;dbname=$dbname;port=$port;",$username,$password);
} catch (PDOException $exception){
    echo "Error: {$exception->getMessage()}";
    }
$sql="SELECT * FROM ПППЛАТКИ order by Название asc";
$stmt=$pdo->query($sql);
while($platok=$stmt->fetch(PDO::FETCH_ASSOC)){
    $povtor_predstav=[];
    while($svoistvo=array_shift($platok)){
        $predstav=array_shift($platok_predstav);
        $povtor_predstav[]=$predstav;
        echo "$predstav: $svoistvo<br>";
    }
    $platok_predstav=$povtor_predstav;
    echo "<br>";
    echo "<br>";
    }
?>
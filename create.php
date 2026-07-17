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
//инициализация данных
$platok_predstav=["Артикул","Название","Автор платка","Колорит 1","Колорит 2","Колорит 3",
"Колорит 4","Колорит 5","Узор темени","Узор сердцевины","Узор сторон","Узор углов","Узор краёв",
"Соотношение рисунка и орнамента","Нарисованный цветок 1","Нарисованный цветок 2","Нарисованный цветок 3",
"Нарисованный цветок 4","Нарисованный цветок 5","Размер платка","Материал платка","Материал бахромы"];
$soobshenije0="Феодосия сообщает, добавлен новый платок";

$artikul=""; $nazvanije=""; $avtor=""; $kolorit_1=""; $kolorit_2=""; $kolorit_3=""; $kolorit_4=""; $kolorit_5="";
$uzor_tenemi=""; $uzor_serdcevina=""; $uzor_storon=""; $uzor_uglov=""; $uzor_kraja=""; $uzor_cvety_ornament="";
$cvetok_1=""; $cvetok_2=""; $cvetok_3=""; $cvetok_4=""; $cvetok_5=""; $razmer_platka=""; $material_platka="";
$material_bahromi="";
// 1. Самодельный PSR-4 автозагрузчик взамен composer autoload.php
spl_autoload_register(function ($class) {
    // Префикс пространства имен библиотеки
    $prefix = 'PhpAmqpLib\\';
    
    // Базовая директория для этого префикса
    $base_dir = __DIR__ . '/PhpAmqpLib/';

    // Проверяем, использует ли класс этот префикс

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return; // Если нет, передаем управление следующему автозагрузчику
    }

    // Получаем относительное имя класса
    $relative_class = substr($class, $len);

    // Заменяем разделители пространства имен на разделители директорий
    // и добавляем расширение .php
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    // Если файл существует, подключаем его
    if (file_exists($file)) {
        require_once $file;
    }
});
//дешифрация секретов
//обход отсуствия mbstlengh
function mb_substr($str, $start, $length = null, $encoding = 'UTF-8') {
    // Разбиваем строку на массив символов (учитывая многобайтовые кодировки)
    $chars = preg_split('//u', $str, -1, PREG_SPLIT_NO_EMPTY);
    
    // Получаем нужный срез
    $sliced_chars = array_slice($chars, $start, $length);
    
    // Собираем обратно в строку
    return implode('', $sliced_chars);
}
if (!function_exists('mb_strlen')) {
    function mb_strlen($str, $encoding = null) {
        if ($encoding === null) {
            $encoding = mb_internal_encoding();
        }
        return iconv_strlen($str, $encoding);
    }
}
//новый заяц
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Connection\AMQPSSLConnection;
use PhpAmqpLib\Wire\AMQPTable;
use PhpAmqpLib\Wire\AMQPWriter;
$url_str=getenv('CLOUDAMQP_URL') OR exit("CLOUDAMQP_URL not set");
$url=parse_url($url_str);
//$vhost=substr($url["path"],1);
//if($url["scheme"] === "amqps"){
    //$ssl_opts=array("capath"=>"/etc/ssl/certs"
    //);
    //$rabbit_connect=new AMQPStreamConnection($url["host"],5672,$url["user"],$url["pass"],$vhost);
//} else {
  //  $rabbit_connect=new AMQPStreamConnection($url["host"],5672,$url["user"],$url["pass"],$vhost);
//}
$rabbit_host=getenv('RABBITHOST');
$rabbit_port=getenv('RABBITPORT');
$rabbit_username=getenv('RABBITUSERNAME');
$rabbit_password=getenv('RABBITPASSWORD');
$rabbit_virtual_engine=getenv('RABBITVIRTUALENGINE');
$host=getenv('HOST');
$dbname=getenv("DBNAME");
$password=getenv("PASSWORD");
$username=getenv("USERNAME");
$port=getenv("PORT");
//подключение к БД
$db=parse_url(getenv("DATABASEURL"));
$pdo=new PDO("pgsql:".sprintf("host=%s;port=%s;user=%s;password=%s;dbname=%s",
$db["host"],$db["port"],$db["user"],$db["pass"],ltrim($db["path"],"/")));
//try {$pdo= new PDO("pgsql:host=$host;dbname=$dbname;port=$port;",$username,$password);
   // } catch (PDOException $exception){
//echo "Error: {$exception->getMessage()}";
//            };
//подключение к брокеру
try {$rabbit_connect=new AMQPStreamConnection($rabbit_host,$rabbit_port,$rabbit_username,$rabbit_password,$rabbit_virtual_engine);
    } catch (Exception $e) {
    echo 'Caught broker exception: ',  $e->getMessage(), "\n";
    }
//обработка отправки формы
if($_SERVER["REQUEST_METHOD"]=="POST"){
$artikul=$_POST["Артикул"];
$nazvanije=$_POST["Название_платка"];
$avtor=$_POST["Автор_платка"];

$kolorit_1=$_POST["Колорит_1"];
$kolorit_2=$_POST["Колорит_2"];
$kolorit_3=$_POST["Колорит_3"];
$kolorit_4=$_POST["Колорит_4"];
$kolorit_5=$_POST["Колорит_5"];

$uzor_tenemi=$_POST["Узор_темени"];
$uzor_serdcevina=$_POST["Узор_сердцевины"];
$uzor_storon=$_POST["Узор_сторон"];
$uzor_uglov=$_POST["Узор_углов"];
$uzor_kraja=$_POST["Узор_краёв"];

$uzor_cvety_ornament=$_POST["соотнцветыорнам"];

$cvetok_1=$_POST["Нарисованный_цветок_1"];
$cvetok_2=$_POST["Нарисованный_цветок_2"];
$cvetok_3=$_POST["Нарисованный_цветок_3"];
$cvetok_4=$_POST["Нарисованный_цветок_4"];
$cvetok_5=$_POST["Нарисованный_цветок_5"];

$razmer_platka=$_POST["Размер_платка"];
$material_platka=$_POST["Материал_платка"];
$material_bahromi=$_POST["Материал_бахромы"];
// проверка данных для Debug
//echo $artikul; echo $nazvanije; echo $avtor; echo $kolorit_1; echo $kolorit_2; echo $kolorit_3; echo $kolorit_4; echo $kolorit_5;
//echo $uzor_tenemi; echo $uzor_serdcevina; echo $uzor_storon; echo $uzor_uglov; echo $uzor_kraja; echo $uzor_cvety_ornament; echo $cvetok_1; 
//echo $cvetok_2; echo $cvetok_3; echo $cvetok_4; echo $cvetok_5; echo $razmer_platka; echo $material_platka; echo $material_bahromi;
//валидация данных выполнена в html цикл через if die не актуален
//проверка чтоб не внести платки с одинаковым названием или артикулом
$sql_raw1="SELECT * FROM ПППЛАТКИ WHERE id=:artikul_vvod";
$sql_stmt1=$pdo->prepare($sql_raw1);
$sql_stmt1->execute(["artikul_vvod"=>$artikul]);
$platok1=$sql_stmt1->fetch(PDO::FETCH_ASSOC);
if ($platok1 != FALSE){
    echo "Артикул занят!!!";
    die();
}
$sql_raw2="SELECT * FROM ПППЛАТКИ WHERE Название=:nazvanije_vvod";
$sql_stmt2=$pdo->prepare($sql_raw2);
$sql_stmt2->execute(["nazvanije_vvod"=>$nazvanije]);
$platok2=$sql_stmt2->fetch(PDO::FETCH_ASSOC);
if ($platok2 != FALSE){
    echo "Платок с таким названием уже есть!!!";
    die();
}
try {
$sql_raw="INSERT INTO ПППЛАТКИ(id,Название, Автор, Колорит_1,Колорит_2,Колорит_3,Колорит_4,Колорит_5,
Узор_темени,Узор_сердцевины,Узор_сторон,Узор_углов, Узор_края,Цветы_Орнамент,
Изображенный_Цветок_1, Изображенный_Цветок_2, Изображенный_Цветок_3, Изображенный_Цветок_4,
Изображенный_Цветок_5,Размер_Платка, Материал_Платка,Материал_Бахромы) 
VALUES (id=:artikul,Название=:nazvanije,Автор=:avtor,Колорит_1=:kolorit_1,Колорит_2=:kolorit_2,Колорит_3=:kolorit_3,Колорит_4=:kolorit_4,Колорит_5=:kolorit_5,
Узор_темени=:uzor_tenemi,Узор_сердцевины=:uzor_serdcevina,Узор_сторон=:uzor_storon,Узор_углов=:uzor_uglov,Узор_края=:uzor_kraja,
Цветы_Орнамент=:uzor_cvety_ornament,Изображенный_Цветок_1=:cvetok_1,Изображенный_Цветок_2=:cvetok_2,Изображенный_Цветок_3=:cvetok_3,
Изображенный_Цветок_4=:cvetok_4,Изображенный_Цветок_5=:cvetok_5,Размер_Платка=:razmer_platka, Материал_Платка=:material_platka,Материал_Бахромы=:material_bahromi)";
$sql_stmt=$pdo->prepare($sql_raw);
//$sql_stmt->execute(["artikul"=>$artikul,"nazvanije"=>$nazvanije,"avtor"=>$avtor,"kolorit_1"=>$kolorit_1,"kolorit_2"=>$kolorit_2,"kolorit_3"=>$kolorit_3,
//"kolorit_4"=>$kolorit_4,"kolorit_5"=>$kolorit_5,"uzor_serdcevina"=>$uzor_serdcevina,"uzor_storon"=>$uzor_storon,"uzor_uglov"=>$uzor_uglov,
//"uzor_kraja"=>$uzor_kraja,"uzor_cvety_ornament"=>$uzor_cvety_ornament,"cvetok_1"=>$cvetok_1,"cvetok_2"=>$cvetok_2,"cvetok_3"=>$cvetok_3,
//"cvetok_4"=>$cvetok_4,"cvetok_5"=>$cvetok_5,"razmer_platka"=>$razmer_platka,"material_platka"=>$material_platka,"material_bahromi"=>$material_bahromi]);
echo "Успешно добавлен новый платок";
echo "<br>";
} catch (PDOException $exception){
echo "Error: {$exception->getMessage()}";
            }
$platok_dannyje=[$artikul,$nazvanije,$avtor,$kolorit_1,$kolorit_2,$kolorit_3,$kolorit_4,$kolorit_5,$uzor_tenemi,$uzor_serdcevina,$uzor_storon,
$uzor_uglov,$uzor_kraja,$uzor_cvety_ornament,$cvetok_1,$cvetok_2,$cvetok_3,$cvetok_4,$cvetok_5,$razmer_platka,$material_platka,$material_bahromi];
$soobshenije="";
foreach($platok_dannyje as $svoistvo){
    $predstav=array_shift($platok_predstav);
    $stroka="$predstav: $svoistvo; ";
    $soobshenije .= $stroka;
    }
echo $soobshenije;
echo "<br>";
try {
$channel = $rabbit_connect->channel();
//Объявление очереди (убеждаемся, что она существует)
$channel->queue_declare('platoky_queue', false, false, false, false);
//Создание сообщения
$data =$soobshenije;
$msg = new AMQPMessage($data);
//Отправка сообщения
$channel->basic_publish($msg, '', 'platoky_queue');
echo "Сообщение отправлено!";
//Закрытие соединения
$channel->close();
$rabbit_connect->close();
} catch (Exception $e) {
    echo 'Caught broker exception: ',  $e->getMessage(), "\n";
}
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добавить платок</title>
</head>
<body>
    <div class="container">
        <header class="d-flex justify-content-between my-1">
        <h2>Добавить платок</h2>
        </header>  
        <form action="" method="post">
            <div class="form-element my-1">
                <span>Артикул платка_</span>
                <input type="integer" class="form-control" name="Артикул" placeholder="Артикул" required="true">
            </div>
            <br>
            <div class="form-element my-1">
                <span>Название платка</span>
                <input type="text" maxlength="64" minlength="5" class="form-control" name="Название_платка" placeholder="Название платка" required="true">
            </div>
            <br>
            <div class="form-element my-1">
                <span>Автор платка___</span>
                <input type="text" maxlength="64" minlength="5" class="form-control" name="Автор_платка" placeholder="Автор платка" required="true">
            </div>
            <br>
            <div class="form-element my-1">
                <span>Колорит_1_____</span>
                <input type="text" maxlength="64" minlength="5" class="form-control" name="Колорит_1" placeholder="Колорит 1" required="true">
            </div>
             <br>
            <div class="form-element my-1">
                <span>Колорит_2_____</span>
                <input type="text" maxlength="64" minlength="5" class="form-control" name="Колорит_2" placeholder="Колорит 2" required="true">
            </div>
             <br>
            <div class="form-element my-1">
                <span>Колорит_3_____</span>
                <input type="text" maxlength="64" minlength="5" class="form-control" name="Колорит_3" placeholder="Колорит 3" required="true">
            </div>
            <br>
            <div class="form-element my-4">
                <span>Колорит_4_____</span>
                <input type="text" maxlength="64" minlength="5" class="form-control" name="Колорит_4" placeholder="Колорит 4" required="true">
            </div>
            <br>
            <div class="form-element my-4">
                <span>Колорит_5_____</span>
                <input type="text" maxlength="64" minlength="5" class="form-control" name="Колорит_5" placeholder="Колорит 5" required="true">
            </div>
            <br>
            <div class="form-element my-4">
                <span>Узор темени____</span>
                <input type="text" maxlength="64" minlength="5" class="form-control" name="Узор_темени" placeholder="Узор_темени" required="true">
            </div>
            <br>
            <div class="form-element my-4">
                <span>Узор сердцевины</span>
                <input type="text" maxlength="64" minlength="5" class="form-control" name="Узор_сердцевины" placeholder="Узор сердцевины" required="true">
            </div>
            <br>
            <div class="form-element my-4">
                <span>Узор сторон____</span>
                <input type="text" maxlength="64" minlength="5" class="form-control" name="Узор_сторон" placeholder="Узор сторон" required="true">
            </div>
            <br>
            <div class="form-element my-4">
                <span>Узор углов_____</span>
                <input type="text" maxlength="64" minlength="5" class="form-control" name="Узор_углов" placeholder="Узор углов" required="true">
            </div>
            <br>
            <div class="form-element my-4">
                <span>Узор краёв_____</span>
                <input type="text" maxlength="64" minlength="5" class="form-control" name="Узор_краёв" placeholder="Узор краёв" required="true">
            </div>
            <br>
            <div class="form-element my-4">
                <span>Строен. узора и орнам_</span>
                <input type="text" maxlength="64" minlength="5" class="form-control" name="соотнцветыорнам" placeholder="соотнцветыорнам" required="true">
            </div>
            <br>
            <div class="form-element my-4">
                <span>Нарисованный цветок 1</span>
                <input type="text" maxlength="64" minlength="5" class="form-control" name="Нарисованный_цветок_1" placeholder="Нарисованный цветок 1" required="true">
            </div>
            <br>
            <div class="form-element my-4">
                <span>Нарисованный цветок 2</span>
                <input type="text" maxlength="64" minlength="5" class="form-control" name="Нарисованный_цветок_2" placeholder="Нарисованный цветок 2" required="true">
            </div>
            <br>
            <div class="form-element my-4">
                <span>Нарисованный цветок 3</span>
                <input type="text" maxlength="64" minlength="5" class="form-control" name="Нарисованный_цветок_3" placeholder="Нарисованный цветок 3" required="true">
            </div>
            <br>
            <div class="form-element my-4">
                <span>Нарисованный цветок 4</span>
                <input type="text" maxlength="64" minlength="5" class="form-control" name="Нарисованный_цветок_4" placeholder="Нарисованный цветок 4" required="true">
            </div>
            <br>
            <div class="form-element my-4">
                <span>Нарисованный цветок 5</span>
                <input type="text" maxlength="64" minlength="5" class="form-control" name="Нарисованный_цветок_5" placeholder="Нарисованный_цветок 5" required="true">
            </div>
            <br>
            <div class="form-element my-4">
                <span>Размер платка_____</span>
                <input type="text" maxlength="64" minlength="5" class="form-control" name="Размер_платка" placeholder="Размер_платка" required="true">
            </div>
            <br>
            <div class="form-element my-4">
                <span>Материал платка__</span>
                <input type="text" maxlength="64" minlength="5" class="form-control" name="Материал_платка" placeholder="Материал_платка" required="true">
            </div>
            <br>
            <div class="form-element my-4">
                <span>Материал бахромы_</span>
                <input type="text" maxlength="64" minlength="5" class="form-control" name="Материал_бахромы" placeholder="Материал_бахромы" required="true">
            </div>
            <br>
            <div class="form-element my-4">
                <input type="submit" class="btn btn-success" name="create" value="Создать запись">
            </div>
        </form>
    </div>
</body>
</html>
<?php
$ch=curl_init("https://pulherija-c47cb3169d8b.herokuapp.com/gamajun/api/add");
curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
curl_setopt($ch,CURLOPT_POST,true);
curl_setopt($ch,CURLOPT_POSTFIELDS,json_decode(["action"=>"click"]));
curl_setopt($ch,CURLOPT_HTTPHEADER,["Content-Type:application/json"]);

$response=curl_exec($ch);

$httpCode=curl_getinfo($ch,CURLINFO_HTTP_CODE);

curl_close($ch);

echo $httpCode
?>
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
//function mb_substr($str, $start, $length = null, $encoding = 'UTF-8') {
    // Разбиваем строку на массив символов (учитывая многобайтовые кодировки)
    //$chars = preg_split('//u', $str, -1, PREG_SPLIT_NO_EMPTY);
    
    // Получаем нужный срез
    //$sliced_chars = array_slice($chars, $start, $length);
    
    // Собираем обратно в строку
    //return implode('', $sliced_chars);
//}
//if (!function_exists('mb_strlen')) {
    //function mb_strlen($str, $encoding = null) {
        //if ($encoding === null) {
        //    $encoding = mb_internal_encoding();
        //}
        //return iconv_strlen($str, $encoding);
    //}
//}
//новый заяц
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Connection\AMQPSSLConnection;
use PhpAmqpLib\Wire\AMQPTable;
use PhpAmqpLib\Wire\AMQPWriter;
//$url_str=getenv('CLOUDAMQP_URL') OR exit("CLOUDAMQP_URL not set");
//$url=parse_url($url_str);
//$vhost=substr($url["path"],1);
//if($url["scheme"] === "amqps"){
    //$ssl_opts=array("capath"=>"/etc/ssl/certs"
    //);
    //$rabbit_connect=new AMQPStreamConnection($url["host"],5672,$url["user"],$url["pass"],$vhost);
//} else {
  //  $rabbit_connect=new AMQPStreamConnection($url["host"],5672,$url["user"],$url["pass"],$vhost);
//}
// сертификаты безопасности
$sslOptions = array(
  'cafile' => realpath(__DIR__ . '/isrgrootx1.pem'),
);

$rabbitmq_url = getenv('STACKHERO_RABBITMQ_AMQP_URL_TLS');

$parsed_url = parse_url($rabbitmq_url);
$host_rabbit = $parsed_url['host'];
$port_rabbit = $parsed_url['port'];
$user_rabbit = $parsed_url['user'];
$password_rabbit = $parsed_url['pass'];

//$connection_rabbit_new = new AMQPSSLConnection($host_rabbit, $port_rabbit, $user_rabbit, $password_rabbit, '/', $sslOptions);
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
//$rabbit_connect=new AMQPStreamConnection($rabbit_host,$rabbit_port,$rabbit_username,$rabbit_password,$rabbit_virtual_engine,$insist = false,
    //$login_method = 'AMQPLAIN',
    //$locale = null,
    //$connection_timeout = 5.0,
    //$read_write_timeout = 5.0,
    //$context = null,
    //$keepalive = true, // <-- Включите этот параметр
    //$heartbeat = 60);
    //} 
    //catch (Exception $e) {
    //echo 'Caught broker exception: ',  $e->getMessage(), "\n";
    //}
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
        <form action="https://pulherija-c47cb3169d8b.herokuapp.com/gamajun/api/add" method="post">
            <div class="form-element my-1">
                <span>Артикул платка_</span>
                <input type="integer" class="form-control" name="id" placeholder="id" required="true">
            </div>
            <br>
            <div class="form-element my-1">
                <span>Название платка</span>
                <input type="text" maxlength="64" minlength="5" class="form-control" name="Название_Платка" placeholder="Название платка" required="true">
            </div>
            <br>
            <div class="form-element my-1">
                <span>Автор платка___</span>
                <input type="text" maxlength="64" minlength="5" class="form-control" name="Автор_Платка" placeholder="Автор платка" required="true">
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
                <input type="text" maxlength="64" minlength="5" class="form-control" name="Узор_Темени" placeholder="Узор_темени" required="true">
            </div>
            <br>
            <div class="form-element my-4">
                <span>Узор сердцевины</span>
                <input type="text" maxlength="64" minlength="5" class="form-control" name="Узор_Сердцевины" placeholder="Узор сердцевины" required="true">
            </div>
            <br>
            <div class="form-element my-4">
                <span>Узор сторон____</span>
                <input type="text" maxlength="64" minlength="5" class="form-control" name="Узор_Сторон" placeholder="Узор сторон" required="true">
            </div>
            <br>
            <div class="form-element my-4">
                <span>Узор углов_____</span>
                <input type="text" maxlength="64" minlength="5" class="form-control" name="Узор_Углов" placeholder="Узор углов" required="true">
            </div>
            <br>
            <div class="form-element my-4">
                <span>Узор краёв_____</span>
                <input type="text" maxlength="64" minlength="5" class="form-control" name="Узор_Края" placeholder="Узор краёв" required="true">
            </div>
            <br>
            <div class="form-element my-4">
                <span>Строен. узора и орнам_</span>
                <input type="text" maxlength="64" minlength="5" class="form-control" name="Цветы_Орнамент" placeholder="соотнцветыорнам" required="true">
            </div>
            <br>
            <div class="form-element my-4">
                <span>Нарисованный цветок 1</span>
                <input type="text" maxlength="64" minlength="5" class="form-control" name="Изображённый_Цветок_1" placeholder="Нарисованный цветок 1" required="true">
            </div>
            <br>
            <div class="form-element my-4">
                <span>Нарисованный цветок 2</span>
                <input type="text" maxlength="64" minlength="5" class="form-control" name="Изображённый_Цветок_2" placeholder="Нарисованный цветок 2" required="true">
            </div>
            <br>
            <div class="form-element my-4">
                <span>Нарисованный цветок 3</span>
                <input type="text" maxlength="64" minlength="5" class="form-control" name="Изображённый_Цветок_3" placeholder="Нарисованный цветок 3" required="true">
            </div>
            <br>
            <div class="form-element my-4">
                <span>Нарисованный цветок 4</span>
                <input type="text" maxlength="64" minlength="5" class="form-control" name="Изображённый_Цветок_4" placeholder="Нарисованный цветок 4" required="true">
            </div>
            <br>
            <div class="form-element my-4">
                <span>Нарисованный цветок 5</span>
                <input type="text" maxlength="64" minlength="5" class="form-control" name="Изображённый_Цветок_5" placeholder="Нарисованный_цветок 5" required="true">
            </div>
            <br>
            <div class="form-element my-4">
                <span>Размер платка_____</span>
                <input type="text" maxlength="64" minlength="5" class="form-control" name="Размер_Платка" placeholder="Размер_платка" required="true">
            </div>
            <br>
            <div class="form-element my-4">
                <span>Материал платка__</span>
                <input type="text" maxlength="64" minlength="5" class="form-control" name="Материал_Платка" placeholder="Материал_платка" required="true">
            </div>
            <br>
            <div class="form-element my-4">
                <span>Материал бахромы_</span>
                <input type="text" maxlength="64" minlength="5" class="form-control" name="Материал_Бахромы" placeholder="Материал_бахромы" required="true">
            </div>
            <br>
            <div class="form-element my-4">
                <input type="submit" class="btn btn-success" name="create" value="Создать запись">
            </div>
        </form>
    </div>
</body>
</html>
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
<?php
$ch=curl_init("https://pulherija-c47cb3169d8b.herokuapp.com/gamajun/api/add");
curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
//curl_setopt($ch,CURLOPT_POST,true);
//curl_setopt($ch,CURLOPT_POSTFIELDS,json_decode(["action"=>"click"]));
//curl_setopt($ch,CURLOPT_HTTPHEADER,["Content-Type:application/json"]);

$response=curl_exec($ch);

$httpCode=curl_getinfo($ch,CURLINFO_HTTP_CODE);
if ($httpCode != 200){
    echo $httpCode;
}
curl_close($ch);

echo $httpCode;
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
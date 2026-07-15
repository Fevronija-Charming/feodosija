<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Таблица платков</title>
</head>
<body>
    <table border="1" "width=10px">
        <thead>
            <tr>
            <th> Название </th>
            <th> Автор платка </th>
            
            <th> Колорит 1 </th>
            <th> Колорит 2 </th>
            <th> Колорит 3 </th>
            <th> Колорит 4 </th>
            <th> Колорит 5 </th>

            <th> Узор темени </th>
            <th> Узор сердцевины </th>
            <th> Узор сторон </th>
            <th> Узор углов </th>
            <th> Узор края </th>

            <th> Соотношение рисунка и орнамента </th>

            <th> Нарисованный цветок 1 </th>
            <th> Нарисованный цветок 2 </th>
            <th> Нарисованный цветок 3 </th>
            <th> Нарисованный цветок 4 </th>
            <th> Нарисованный цветок 5 </th>

            <th> Размер платка </th>
            <th> Материал платка </th>
            <th> Материал бахромы </th>
            </tr>
        </thead>
        <tbody>
            <?php
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
            echo "
                <tr>
                    <td>$platok[Название] </td>
                    <td>$platok[Автор] </td>
                    <td>$platok[Колорит_1] </td>
                    <td>$platok[Колорит_2] </td>
                    <td>$platok[Колорит_3] </td>
                    <td>$platok[Колорит_4] </td>
                    <td>$platok[Колорит_5] </td>
                    <td>$platok[Узор_темени] </td>
                    <td>$platok[Узор_сердцевины] </td>
                    <td>$platok[Узор_сторон] </td>
                    <td>$platok[Узор_углов] </td>
                    <td>$platok[Узор_края] </td>
                    <td>$platok[Цветы_Орнамент]</td>
                    <td>$platok[Изображенный_Цветок_1] </td>
                    <td>$platok[Изображенный_Цветок_2] </td>
                    <td>$platok[Изображенный_Цветок_3] </td>
                    <td>$platok[Изображенный_Цветок_4] </td>
                    <td>$platok[Изображенный_Цветок_5] </td>
                    <td>$platok[Размер_Платка] </td>
                    <td>$platok[Материал_Платка] </td>
                    <td>$platok[Материал_Бахромы] </td>
                <tr>
                ";
    }
?>
        </tbody>
    
    </table>
</body>
</html>
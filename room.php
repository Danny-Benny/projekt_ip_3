<html>
    <head>    
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
        integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    </head>
    <body class="container">

<?php
$id = filter_input(INPUT_GET,
    'roomId',
    FILTER_VALIDATE_INT,
    ["options" => ["min_range"=> 1]]
);

if ($id === null || $id === false){
    http_response_code(400);
    $status = "bad_request";
}else{

require_once "inc/db.inc.php";

$stmt = $pdo->query("SELECT * 
FROM room 
WHERE room_id = $id");

$stmt2 = $pdo->query("SELECT employee.name, employee.surname, employee.employee_id 
FROM room 
INNER JOIN employee ON room.room_id = employee.room 
WHERE room_id = $id");

$stmt3 = $pdo->query("SELECT AVG(employee.wage) AS avWage 
FROM room 
INNER JOIN employee ON room.room_id = employee.room 
WHERE room_id = $id");

$stmt4 = $pdo->query("SELECT employee.name, employee.surname, employee.employee_id 
FROM employee  
INNER JOIN `key` ON `key`.employee = employee.employee_id 
INNER JOIN room ON `key`.room = room.room_id 
WHERE room_id = $id");

if ($stmt->rowCount() === 0){
    http_response_code(404);
    $status = "not_found";
}else{
    while ($row = $stmt->fetch()){
        echo "<h1>Mistnost c. {$row->no}</h1>";
        echo "<dl class=\"dl-horizontal\">";
        echo "<dt>Cislo</dt>";
        echo "<dd>{$row->no}</dd>";
        echo "<dt>Jmeno</dt>";
        echo "<dd>{$row->name}</dd>";
        echo "<dt>Telefone</dt>";
        echo "<dd>{$row->phone}</dd>";
        echo "<dt>Lide</dt>";
        while($row = $stmt2->fetch()){
            echo "<a href='employee.php?employeeId={$row->employee_id}'><dd>{$row->name} {$row->surname}</dd></a>";
        }
        echo "<dt>Prumerna mzda</dt>";
        foreach ($stmt3 as $row){
        echo "<dd>{$row->avWage}</dd>";
        }
        echo "<dt>Klice</dt>";
        while($row = $stmt4->fetch()){
                echo "<a href='employee.php?employeeId={$row->employee_id}'><dd>{$row->name} {$row->surname}</dd></a>";
        }
        echo "</dl>";
    }
        echo "<a href=\"rooms.php\"><span class=\"glyphicon glyphicon-arrow-left\" aria-hidden=\"true\"> Zpet na mistnosti</a>";
}
}

switch ($status){
    case "bad_request";
        echo "<h1>Bad Reguest</h1>";
        break;
    case "not_found";
        echo "<h1>Not found</h1>";
        break;
    case "OK";

        break;
}
?>
</body>
</html>
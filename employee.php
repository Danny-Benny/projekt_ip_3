<html>
    <head>    
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
        integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    </head>
    <body class="container">
    <?php

$id = filter_input(INPUT_GET,
    'employeeId',
    FILTER_VALIDATE_INT,
    ["options" => ["min_range"=> 1]]
);

if ($id === null || $id === false){
    http_response_code(400);
    $status = "bad_request";
}else{

require_once "inc/db.inc.php";

$stmt = $pdo->query("
    SELECT employee.surname, employee.name, employee.job, employee.wage, employee.room, employee.employee_id, 
            room.room_id, room.phone, room.name as roomName, room.no
    FROM employee 
    INNER JOIN room ON employee.room=room.room_id
    WHERE employee_id = $id ");

$stmt2 = $pdo->query("SELECT employee.name, employee.surname, employee.employee_id, room.room_id, room.name 
FROM employee  
INNER JOIN `key` on `key`.employee = employee.employee_id 
INNER JOIN room ON `key`.room = room.room_id 
WHERE employee_id = $id 
ORDER BY employee.surname");



if ($stmt->rowCount() === 0){
    http_response_code(404);
    $status = "not_found";
}else{
    while ($row = $stmt->fetch()) {
    echo "<h1>Karta osoby: {$row->name} {$row->surname}</h1>";
    echo "<dl class=\"dl-horizontal\">";
    echo "<dt>Jmeno</dt>";
    echo "<dd>{$row->name}</dd>";
    echo "<dt>Prijmeni</dt>";
    echo "<dd>{$row->surname}</dd>";
    echo "<dt>Pozice</dt>";
    echo "<dd>{$row->job}</dd>";
    echo "<dt>Mzda</dt>";
    echo "<dd>{$row->wage}</dd>";
    echo "<dt>Mistnost</dt>";
    echo "<dd><a href='room.php?roomId={$row->room_id}'>{$row->roomName }</a></dd>";
    echo "<dt>Klice</dt>";
    $status = "OK";
    }
    while ($row = $stmt2->fetch()) {
    echo "<dd><a href='room.php?roomId={$row->room_id}'>{$row->name}</a></dd>";
    }
    echo "</dl>";
    
    echo "<a href=\"employees.php\"><span class=\"glyphicon glyphicon-arrow-left\" aria-hidden=\"true\"> Zpet na osoby</a>";
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
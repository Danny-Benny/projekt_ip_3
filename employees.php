<!DOCTYPE html>

<html>

<head>
    <meta charset="UTF-8">
    <!-- Bootstrap-->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
        integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <title>Připojení k DB</title>
</head>

<body class="container">
    <?php
    require_once "inc/db.inc.php";

    $columns = array('name','no','phone', 'job');

    $column = isset($_GET['column']) && in_array($_GET['column'], $columns) ? $_GET['column'] : $columns[0];

    $sort_order = isset($_GET['order']) && strtolower($_GET['order']) == 'desc' ? 'DESC' : 'ASC';

    $stmt = 'SELECT employee.surname, employee.name, employee.job, employee.room, employee.employee_id, room.room_id, room.phone, room.name AS roomName, room.no 
    FROM employee 
    INNER JOIN room ON employee.room=room.room_id 
    ORDER BY ' . $column . ' ' . $sort_order;

    $result = $pdo->query($stmt);

if ($result->rowCount() === 0) {
    echo "Záznam neobsahuje žádná data";
} else{ 

	$up_or_down = str_replace(array('ASC','DESC'), array('up','down'), $sort_order); 
	$asc_or_desc = $sort_order == 'ASC' ? 'desc' : 'asc';

    echo "<h1>Seznam zamestnancu</h1>";
    echo "<table class='table table-striped'>";
        echo "<tr>";    
        echo "<th>Jmeno<a href=\"employees.php?column=name&order= $asc_or_desc; ?>\"><span class='glyphicon glyphicon-arrow-down $column == 'name' ? '-' . $up_or_down : '' aria-hidden='true'\"><a href='employees.php?column=name&order=$asc_or_desc' class='sorted'><span class='glyphicon glyphicon-arrow-up $column == 'name' ? '-' . $up_or_down : '' aria-hidden='true'></a></th>";
        echo "<th>Mistnost<a href=\"employees.php?column=no&order= $asc_or_desc; ?>\"><span class='glyphicon glyphicon-arrow-down $column == 'no' ? '-' . $up_or_down : '' aria-hidden='true'\"><a href='employees.php?column=no&order=$asc_or_desc' class='sorted'><span class='glyphicon glyphicon-arrow-up $column == 'no' ? '-' . $up_or_down : '' aria-hidden='true'></a></th>";
        echo "<th>Telefon<a href=\"employees.php?column=phone&order= $asc_or_desc; ?>\"><span class='glyphicon glyphicon-arrow-down $column == 'phone' ? '-' . $up_or_down : '' aria-hidden='true'\"><a href='employees.php?column=phone&order=$asc_or_desc' class='sorted'><span class='glyphicon glyphicon-arrow-up $column == 'phone' ? '-' . $up_or_down : '' aria-hidden='true'></a></th>";
        echo "<th>Pozice<a href=\"employees.php?column=job&order= $asc_or_desc; ?>\"><span class='glyphicon glyphicon-arrow-down $column == 'job' ? '-' . $up_or_down : '' aria-hidden='true'\"><a href='employees.php?column=job&order=$asc_or_desc' class='sorted'><span class='glyphicon glyphicon-arrow-up $column == 'job' ? '-' . $up_or_down : '' aria-hidden='true'></a></th>";
        echo "</tr>";
        while ($row = $result->fetch()) {
            echo "<tr>";
            echo "<td><a href='employee.php?employeeId={$row->employee_id}'>{$row->name}</a></td><td>{$row->no}</td><td>{$row->phone}</td><td>{$row->job}</td>";
            echo "</tr>";
        }
        echo "</table>";
}  
    unset($result);
    ?>
</body>

</html>
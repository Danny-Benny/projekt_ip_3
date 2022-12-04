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

    $columns = array('name','no','phone');

    $column = isset($_GET['column']) && in_array($_GET['column'], $columns) ? $_GET['column'] : $columns[0];

    $sort_order = isset($_GET['order']) && strtolower($_GET['order']) == 'desc' ? 'DESC' : 'ASC';

    $stmt = $pdo->query('SELECT * FROM room 
    ORDER BY ' . $column . ' ' . $sort_order);

    if ($stmt->rowCount() == 0) {
        echo "Záznam neobsahuje žádná data";
    } else {

        $up_or_down = str_replace(array('ASC','DESC'), array('up','down'), $sort_order); 
	    $asc_or_desc = $sort_order == 'ASC' ? 'desc' : 'asc';

        echo "<h1>Seznam mistnosti</h1>";
        echo "<table class='table table-striped'>";
            echo "<tr>";    
            echo "<th>Nazev<a href=\"rooms.php?column=name&order= $asc_or_desc; ?>\"><span class='glyphicon glyphicon-arrow-down $column == 'name' ? '-' . $up_or_down : '' aria-hidden='true'\"><a href='rooms.php?column=name&order=$asc_or_desc' class='sorted'><span class='glyphicon glyphicon-arrow-up $column == 'name' ? '-' . $up_or_down : '' aria-hidden='true'></a></th>";
            echo "<th>Cislo<a href=\"rooms.php?column=no&order= $asc_or_desc; ?>\"><span class='glyphicon glyphicon-arrow-down $column == 'no' ? '-' . $up_or_down : '' aria-hidden='true'\"><a href='rooms.php?column=no&order=$asc_or_desc' class='sorted'><span class='glyphicon glyphicon-arrow-up $column == 'no' ? '-' . $up_or_down : '' aria-hidden='true'></a></th>";
            echo "<th>Telefon<a href=\"rooms.php?column=phone&order= $asc_or_desc; ?>\"><span class='glyphicon glyphicon-arrow-down $column == 'phone' ? '-' . $up_or_down : '' aria-hidden='true'\"><a href='rooms.php?column=phone&order=$asc_or_desc' class='sorted'><span class='glyphicon glyphicon-arrow-up $column == 'phone' ? '-' . $up_or_down : '' aria-hidden='true'></a></th>";
        echo "</tr>";
        while ($row = $stmt->fetch()) {
            echo "<tr>";
            echo "<td><a href='employee.php?employeeId={$row->room_id}'>{$row->name}</a></td><td>{$row->no}</td><td>{$row->phone}</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
    unset($stmt);
    ?>
</body>

</html>
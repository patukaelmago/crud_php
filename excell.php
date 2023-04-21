<?php
header("Content-Type: applicatioon/xls");
header("Content-Disposition: attachment; filename=archivo.xls");

?>

<table class="table table-bordered" id="table_id">
        <thead>
            <tr>
                <th>Título</th>
                <th>Descripción</th>
                <th>Creado en</th>
                
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
    <?php

if(isset($_GET['from_date']) && isset($_GET['to_date'])) {
    $from_date = date("Y-m-d", strtotime($_GET['from_date']));
    $to_date = date("Y-m-d", strtotime($_GET['to_date'] . ' + 1 day'));
} else {
    // Establecer valores predeterminados para mostrar todas las tareas
    $from_date = '1970-01-01';
    $to_date = date("Y-m-d", strtotime("+100 years"));
}

        $query = "SELECT * FROM tasks WHERE created_at BETWEEN '$from_date' AND '$to_date'";
        $result_tasks = mysqli_query($conn, $query);

        while($row = mysqli_fetch_array($result_tasks)) { ?>
            <tr>
                <td><?php echo $row['title'] ?></td>
                <td><?php echo $row['description'] ?></td>
                <td><?php echo $row['created_at'] ?></td>
                
                
                <td>
                    <a href="edit.php?id=<?php echo $row['id']?>" class="btn btn-primary">
                        <i class="fas fa-marker"></i>
                    </a>
                    <a href="delete.php?id=<?php echo $row['id']?>" class="btn btn-danger">
                        <i class="far fa-trash-alt"></i>
                    </a>
                </td>
            </tr>
        <?php } ?>
</tbody>
    </table>
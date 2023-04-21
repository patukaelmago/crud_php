<?php include("db.php") ?>
<?php include("includes/header.php") ?>
<?php error_reporting(E_ALL) ?>


<div class="container-fluid p-4">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <!-- MESSAGES -->
            <?php if(isset($_SESSION['message'])) { ?>
                <div class="alert alert-<?= $_SESSION['message_type'];?> alert-dismissible fade show" role="alert">
                <?= $_SESSION['message'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                </button>
                </div>
            <?php session_unset(); } ?>


           <!--  SelectMultiple -->
            <?php
            /* if(isset($_POST['dias_semana'])){
                $dias_semana = $_POST['dias_semana'];
                foreach($dias_semana as $dia){
                echo $dia . "<br>";
                }
            } */
            ?>
            <h6>Para seleccionar mas de una opcion utilizar la tecla "Ctrl"</h6>
            <div class="card card-body">
            <form method="post" action="index.php" class="d-grid gap-2">
<select class="form-select" name="select_multiple[]" aria-label="Multiple select example" multiple >
  <option selected disabled style="background-color: gray, color:white;">LUNA</option>
  <option value="Magnetica 1">Magnetica</option>
  <option value="Lunar 2">Lunar</option>
  <option value="Electrica 3">Electrica</option>
  <option value="Autoexistente 4">Autoexistente</option>
  <option value="Entonada 5">Entonada</option>
  <option value="Ritmica 6">Ritmica</option>
  <option value="Resonante 7">Resonante</option>
  <option value="Galactica 8">Galactica</option>
  <option value="Solar 9">Solar</option>
  <option value="Planetaria 10">Planetaria</option>
  <option value="Espectral 11">Espectral</option>
  <option value="Cristal 12">Cristal</option>
  <option value="Cosmica 13">Cosmica</option>
</select>

 
 <div class="d-flex flex-wrap">
    <?php
if(isset($_POST['select_multiple'])){
    $selected_options = $_POST['select_multiple'];
    foreach($selected_options as $option){
     echo  '<div class="border-light p-2"> 
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <input type="checkbox" aria-label="Checkbox for following text input" name="selected_options[]">
                    </div>
        </div>
        <span class="text-info bg-dark rounded p-2" style="display: inline-block;">' . $option . '</span>
        </div><br>';
    }
}

?>
</div>

  <input type="submit" value="Mostrar opciones seleccionadas" class="btn btn-primary btn-block " name="submit_select">
</form>
</div>
 <?php
if (isset($_POST['submit_select'])) {
    if (isset($_POST['select_multiple'])) {
        $selected_options = implode(", ", $_POST['select_multiple']);
    } else {
        $selected_options = "";
    }
} else {
    $selected_options = "";
}
?>




            <!-- ADD TASK FORM -->
<div class="card card-body">
    <form action="save_task.php" method="POST" class="d-grid gap-2">
        <div class="form-group ">
            <input type="text" name="title" class="form-control" placeholder="Título de la tarea" autofocus>
        </div>
        <div class="form-group">
            <textarea name="description" rows="2" class="form-control" placeholder="Descripción de la tarea"></textarea>
        </div>
        <input type="submit" class="btn btn-success btn-block" name="save_task" value="Guardar tarea">
        <input type="hidden" name="selected_options" value="<?php echo $selected_options; ?>">

    </form>
</div>
<div class="card card-body">
<form action="" method="GET">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group text-center">
                                        <label><b >Del Dia</b></label>
                                        <input type="date" name="from_date" value="<?php if(isset($_GET['from_date'])){ echo $_GET['from_date']; } ?>" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group text-center">
                                        <label><b> Hasta  el Dia</b></label>
                                        <input type="date" name="to_date" value="<?php if(isset($_GET['to_date'])){ echo $_GET['to_date']; } ?>" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label><b></b></label> <br>
                                      <button type="submit" class="btn btn-primary">Buscar</button>
                                    </div>
                                </div>
                            </div>
                            <br>
            </form>
</div>
</div>
<div class="col-md-8">
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
    <br><br>
    <a href="./excell.php" class="btn btn-small btn-info z-depth-2">Descarga Excell</a>
</div>

<?php include("includes/footer.php") ?>

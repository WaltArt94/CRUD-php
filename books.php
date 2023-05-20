<?php include("template/cabecera.php"); ?>

<?php
include("administrador/config/conection.php");

//Consulta de libros a la Data Base
$sql = "SELECT * FROM books";
$sentenciaSQL = $conection->prepare($sql);
$sentenciaSQL->execute();
$listadoLibros = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
?>

<?php foreach($listadoLibros as $libro){ ?>

<div class="col-md-2">
    <div class="card">
        <img class="card-img-top " src="./img/<?php echo $libro["picture"]; ?>">
        <div class="card-body">
            <h4 class="card-title"><?php echo $libro["name"]; ?></h4>
            <a name="" id="" class="btn btn-primary" href="#" role="button">See more...</a>
        </div>
    </div>
</div>
<?php } ?>


<?php include("template/pie.php"); ?>
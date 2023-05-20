<?php include("../template/cabecera.php"); ?>


<?php  

$txtID=(isset($_POST['txtID']))?$_POST['txtID']:"";
$txtName=(isset($_POST['txtName']))?$_POST['txtName']:"";

$txtPicture=(isset($_FILES['txtPicture']['name']))?$_FILES['txtPicture']['name']:"";
$accion=(isset($_POST['action']))?$_POST['action']:"";



include("../config/conection.php");

switch($accion){
        case "add":
        $sql= "INSERT INTO `php-crud-basic`.`books` (`name`, `picture`) VALUES (:nombre, :imagen)";
        $sentenciaSQL=$conection->prepare($sql);
        $sentenciaSQL->bindParam(":nombre",$txtName);

        $fecha = new DateTime();
        $nombreArchivo = ($txtPicture!="")?$fecha->getTimestamp()."_".$_FILES["txtPicture"]["name"]:"imagen.jpg";
        
        $tmpImagen=$_FILES["txtPicture"]["tmp_name"];

        if($tmpImagen!=""){

            move_uploaded_file($tmpImagen,"../../img/".$nombreArchivo);
        }

        $sentenciaSQL->bindParam(":imagen",$nombreArchivo);
        //echo '<script language="javascript">alert("Added information");</script>';
        $sentenciaSQL->execute();
        header("Location:productos.php");
        break;

        case "edit":
        //echo "Edit success";
            $sql= "UPDATE  books SET name=:name WHERE id=:id";
            $sentenciaSQL=$conection->prepare($sql);
            $sentenciaSQL->bindParam(':name',$txtName);
            $sentenciaSQL->bindParam(':id',$txtID);
            $sentenciaSQL->execute();

            if($txtPicture !=""){

                $fecha = new DateTime();
                $nombreArchivo = ($txtPicture!="")?$fecha->getTimestamp()."_".$_FILES["txtPicture"]["name"]:"imagen.jpg";
                $tmpImagen=$_FILES["txtPicture"]["tmp_name"];

                move_uploaded_file($tmpImagen,"../../img/".$nombreArchivo);

                $sql= "SELECT picture FROM books WHERE id=:id";
                $sentenciaSQL=$conection->prepare($sql);
                $sentenciaSQL->bindParam(':id',$txtID);
                $sentenciaSQL->execute();
                $libro=$sentenciaSQL->fetch(PDO::FETCH_LAZY);

                if(isset($libro["picture"])&&($libro["picture"]!="imagen.jpg")){

                    if(file_exists("../../img/".$libro["picture"])){
                        
                        unlink("../../img/".$libro["picture"]);
                    }

                }

                $sql= "UPDATE  books SET picture=:picture WHERE id=:id";
                $sentenciaSQL=$conection->prepare($sql);
                $sentenciaSQL->bindParam(':picture',$nombreArchivo);
                $sentenciaSQL->bindParam(':id',$txtID);
                echo '<script language="javascript">alert("Modified information");</script>';
                $sentenciaSQL->execute();   
            }
            header("Location:productos.php");
        break;

        case "cancel":
            header("Location:productos.php");

        break;

        case "select":
            // echo "Select success";

            $sql= "SELECT * FROM books WHERE id=:id";
            $sentenciaSQL=$conection->prepare($sql);
            $sentenciaSQL->bindParam(':id',$txtID);
            $sentenciaSQL->execute();
            $libro=$sentenciaSQL->fetch(PDO::FETCH_LAZY);

            $txtName=$libro["name"];
            $txtPicture=$libro["picture"];
           
            break;

            case "delete":

                $sql= "SELECT picture FROM books WHERE id=:id";
                $sentenciaSQL=$conection->prepare($sql);
                $sentenciaSQL->bindParam(':id',$txtID);
                $sentenciaSQL->execute();
                $libro=$sentenciaSQL->fetch(PDO::FETCH_LAZY);

                if(isset($libro["picture"])&&($libro["picture"]!="imagen.jpg")){

                    if(file_exists("../../img/".$libro["picture"])){
                        
                        unlink("../../img/".$libro["picture"]);
                    }

                }

                
                $sql= "DELETE FROM books WHERE id=:id";
                $sentenciaSQL=$conection->prepare($sql);
                $sentenciaSQL->bindParam(':id',$txtID);
                echo '<script language="javascript">alert("Deleted information");</script>';
                $sentenciaSQL->execute();
                //echo "Delete success";
                header("Location:productos.php");
                break;
}
//Mostrando datos de la BD:

        $sql= "SELECT * FROM books";
        $sentenciaSQL=$conection->prepare($sql);
        $sentenciaSQL->execute();
        $listadoLibros=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);




?>



<div class="col-md-5">

    <div class="card">
        <div class="card-header">
            Book data
        </div>

        <div class="card-body">

            <form method="POST" enctype="multipart/form-data">

                <div class="form-group">
                    <label for="txtID">ID:</label>
                    <input type="text" required readonly class="form-control" value="<?php echo $txtID; ?>" name="txtID" id="txtID" placeholder="ID">
                </div>

                <div class="form-group">
                    <label for="txtName">Nombre:</label>
                    <input type="text" required class="form-control" value="<?php echo $txtName; ?>" name="txtName" id="txtName" placeholder="Name">
                </div>

                <div class="form-group">
                    <label for="txtPicture">Picture:</label>
                    <br>

                    <?php  
                        if($txtPicture!=""){
                    ?>

                    <img class="img-thumbnail rounded" src="../../img/<?php echo $txtPicture; ?>" width="50" alt="">

                    <?php }  ?>

                    <input type="file" class="form-control" name="txtPicture" id="txtPicture" placeholder="Picture">
                </div>

                <div class="btn-group" role="group" aria-label="">
                    <button type="submit" name="action" <?php echo($accion=="select")?"disabled":""; ?> value="add" class="btn btn-success">Add</button>

                    <button type="submit" name="action" <?php echo($accion!=="select")?"disabled":""; ?> value="edit" class="btn btn-warning">Save</button>

                    <button type="submit" name="action" <?php echo($accion!=="select")?"disabled":""; ?> value="cancel" class="btn btn-info">Cancel</button>
                </div>


          
            </form>
        </div>


    </div>







</div>

<div class="col-md-7">

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Picture</th>
                    <th>What do?</th>
                </tr>
            </thead>
            <tbody>

            <?php foreach($listadoLibros as $libro) { ?>
                <tr>
                    <td><?php echo $libro["id"] ?></td>
                    <td><?php echo $libro["name"] ?></td>
                    <td>
                        
                    <img class="img-thumbnail rounded" src="../../img/<?php echo $libro["picture"]; ?>" width="50" alt="">
                    
                
                    </td>
                    <td>
                        
                 
                    <form method="post">
                        
                        <input type="hidden" name="txtID" id="txtID" value="<?php echo $libro["id"] ?>">

                        <input type="submit" name="action" value="select" class="btn btn-primary"/>
                        <input type="submit" name="action" value="delete" class="btn btn-danger"/>

                    </form>
                    
                    </td>
                    
                </tr>
            <?php }  ?>
            </tbody>
        </table>


</div>


<?php include("../template/pie.php"); ?>
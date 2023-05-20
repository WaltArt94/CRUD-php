<?php
session_start();


    if($_POST){
        if(($_POST["user"]=="walter01")&&($_POST["password"]=="12345")){
            $_SESSION["user"]="ok";
            $_SESSION["nameUser"]="walter01";

            header("Location:inicio.php");
        }else{
            $mensaje="Error: user and password are incorrects";
        }
    }

   
?>


<!doctype html>
<html lang="en">
  <head>
    <title>Admin</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body>
      
        <div class="container">
            <div class="row">

            <div class="col-md-4">
                
            </div>

                <div class="col-md-4">
                <br>
                <br>
                    <div class="card">
                        <div class="card-header">
                            Login
                        </div>
                        <div class="card-body">

                        <?php if(isset($mensaje)) { ?>
                            <div class="alert alert-danger" role="alert">
                               <?php echo $mensaje; ?>
                            </div>
                        <?php } ?>
                            <form method="POST">
                            <div class = "form-group">
                            <label >User:</label>
                            <input type="text" class="form-control" value="user" name="user"  placeholder="Enter your user">
                            <small id="emailHelp" class="form-text text-muted">We'll never share your user with anyon else.</small>
                            </div>

                            <div class="form-group">
                            <label >Password:</label>
                            <input type="password" class="form-control " value="password" name="password"  placeholder="Password">
                            </div>

                          
                            <button type="submit" class="btn btn-primary ">Sign In</button>
                            </form>
                            
                            

                        </div>
                        
                    </div>
                    <a href="/CRUD-php/index.php"> Go to Web Site</a>
                </div>
                
                
            </div>
            
        </div>
        
  </body>
</html>
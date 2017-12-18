<?php
use PEAR2\Net\RouterOS;
require_once 'PEAR2/Autoload.php';
$username="";
$password="";
if(!isset($_SESSION['user_id'])){
    header("Location:admin-login/index.php");
}
if(isset($_POST['btnGenerate'])){ 
function GeraHash($qtd){ 
//Under the string $Caracteres you write all the characters you want to be used to randomly generate the code. 
$Caracteres = 'ABCDEFGHIJKLMOPQRSTUVXWYZ-abcdefghijklmnopqlrstuvwxyz_!@0123456789'; 
$QuantidadeCaracteres = strlen($Caracteres); 
$QuantidadeCaracteres--; 

$Hash=NULL; 
    for($x=1;$x<=$qtd;$x++){ 
        $Posicao = rand(0,$QuantidadeCaracteres); 
        $Hash .= substr($Caracteres,$Posicao,1); 
    } 

return $Hash; 
} 

//Here you specify how many characters the returning string must have 
$username = GeraHash(6);
$password = GeraHash(6);
}
if(isset($_POST['btnValidate'])){
    

$errors = array();

try {
    //Adjust RouterOS IP, username and password accordingly.
    $client = new RouterOS\Client('router_ip', 'router_username', 'router_password');
} catch(Exception $e) {
    $errors[] = $e->getMessage();
}


  
     
        //Here's the fun part - actually changing the password
        $setRequest = new RouterOS\Request('/ip hotspot user add');
        $client($setRequest
            ->setArgument('name', $_POST["username"])
            ->setArgument('password', $_POST["username"])
            ->setArgument('limit-uptime',$_POST['duration'].$_POST['expTime'])
            ->setArgument('profile',$_POST['profile'])
        );

}
if(isset($_POST['btnReset'])){
   $_POST['username']='';
   $_POST['password']='';
}
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title></title>
        <link rel="stylesheet" type="text/css" href="../hotspot/bootstrap/css/bootstrap.min.css"/>
    </head>
    <body>
        <div class="main">
             <!-- Fixed navbar -->
    <nav class="navbar navbar-default">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Classic Hotel Wifi</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="#">Home</a></li>
            <li><a href="#about">History</a></li>
            <li><a href="#contact">About</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li class="active"><a href="">Logout</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
             
            <div class="container">
                <div class="container">
                    <div class="page-header">
                        <h3>Generate Password</h3>
                    </div>
                </div>
                <div class="col-md-4 jumbotron">
                    <div>
                        <form class="form-horizontal" action="index.php" method="POST">
                            <div class="form-group">
                                <label>Username</label>
                                <b>
                                <input name="username" class="form-control" id="inputUsername" placeholder="Username" type="text" value="<?php echo $username?>"/>
                                </b>
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <b>
                                <input name="password" class="form-control" id="inputPassword" placeholder="Password" type="text" value="<?php echo $password;?>"/>
                                </b>
                            </div>
                            <div class="form-group">
                            <label>Expires on</label>  
                            </div>
                          
                            <div class="form-group">
                                
                                 <div class="col-xs-5">
                                     <input type="number" class="form-control"value="30" required="" name="duration" id="dura"/>
                                 </div>
                                    <div class="col-xs-5">
                                        <select class="form-control" id="expTime" name="expTime">
                                    <option value="m">minutes</option>
                                    <option value="h">Hours</option>
                                    <option value="d">Days</option>
                                </select>
                                    </div>
                            </div>
                            
                            <div class="form-group">
                                <label>Key type</label>
                                <select class="form-control" id="mode" name="profile">
                                    <option value="single">single user</option>
                                    <option value="group">Multiple users</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary" id="btnSubmit" name="btnGenerate">Generate</button>
                            <button type="submit" class="btn btn-success" id="btnValidate" name="btnValidate">Validate</button>
                            <button type="submit" class="btn btn-danger" id="btnnReset" name="btnReset">Reset</button>
                        </form>
                    </div>
                </div>
                <div class="col-md-8">
                    <table class="table table-hover">
    <thead>
      <tr>
        <th>Username</th>
        <th>Password</th>
        <th>Duration</th>
        <th>Type</th>
        <th>Created date</th>
        <th>Validator</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>John</td>
        <td>Doe</td>
        <td>30 min</td>
        <td>single</td>
        <td>30/12/2016</td>
        <td>Ndasilver</td>
        <td>
            <button type="button" class="btn btn-primary btn-xs" aria-label="Left Align">
            <span class="glyphicon glyphicon-print" aria-hidden="true"></span>
            </button>
            <button type="button" class="btn btn-primary btn-xs disabled" aria-label="Left Align">
            <span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span>
            </button>
        </td>
      </tr>
    </tbody>
  </table>
                </div>
            </div>
            
        </div>
    </body>
</html>
<script type="text/javascript" src="../hotspot/script/jquery-3.1.1.min.js"></script>
<script type="text/javascript" src="../hotspot/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../hotspot/script/script.js"></script>

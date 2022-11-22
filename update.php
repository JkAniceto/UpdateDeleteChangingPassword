<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Account Management</title>

    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script type="text/javascript" src="js/jquery-3.6.1.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>


</head>
<body class="bg-light">
        <div class="container text-center mt-5">
            <button class="btn btn-lg btn-dark col-12 mb-1" id="customer">Back</button>
            <button id="addButton" type="button" class="btn btn-lg btn-success col-12 mb-1" data-toggle="modal" data-target="#loginModal">Update</button>
              <script>document.getElementById("customer").onclick = function () {window.location.replace('accountManagement.php'); };</script>
        <div class="modal fade" role="dialog" id="loginModal">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-body ">
                    <form method="post" class="form-group">
                    <input type="text" class="form-control form-control-lg mb-3" name="username" placeholder="Enter New Username" required>
                    <input type="text" class="form-control form-control-lg mb-3" name="name" placeholder="Enter New Name" required>
                    <input type="email" class="form-control form-control-lg mb-3" name="email" placeholder="Enter New Email" required>
                    <input type="text" class="form-control form-control-lg mb-3" name="password" placeholder="Enter New Password" required>
                    <select name="accountType" class="form-control form-control-lg col-12 mb-3">
                        <option value="admin">Admin</option>
                        <option value="manager">Manager</option>
                        <option value="cashier">Cashier</option>
                    </select>
                        <button type="submit" class="btn btn-lg btn-success col-12" name="insert">Update</button>
                    </form>
                </div>
                </div>
            </div>
        </div>
          </div>
    </body>
</html>

<?php
    include('method/query.php');
    include('connection.php');
    $id=$_GET['updateid'];
    if(isset($_POST['insert'])){
        //initialization
        $name =  $_POST['name'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password =  $_POST['password'];
        $accountType = $_POST['accountType'];
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $userLinkId = uniqid('',true);

        //UPDATE
        $query1 = "UPDATE user_tb SET id='$id',username='$username',password='$hash',accountType='$accountType',userLinkId='$userLinkId' WHERE id='$id'";
        $query2 = " UPDATE userInfo_tb SET id='$id',name='$name',email='$email',userLinkId='$userLinkId' WHERE id='$id';";
        if(!Query($query1))
          echo "fail to save to database";
        elseif(!Query($query2))
          echo "fail to save to database";
        else
          echo ("<script>window.location.replace('accountManagement.php'); alert('Update Success');</script>");

    }
?>

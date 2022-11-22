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
            <button id="addButton" type="button" class="btn btn-lg btn-success col-12 mb-1" data-toggle="modal" data-target="#loginModal">Add new Account</button>

            <script>document.getElementById("customer").onclick = function () {window.location.replace('admin.php'); };</script>
            <?php
              $page = 'admin';
              include('method/checkIfAccountLoggedIn.php');
              include_once('method/query.php');
              $selectAllUser = "select * from user_tb";
              $resultSet =  getQuery($selectAllUser);
              ?>
              <div class="table-responsive col-lg-12">
                <table class="table table-striped table-bordered mb-5 col-lg-12">
                    <thead class="table-dark">
                        <tr>
                        <th scope="col">NAME</th>
                        <th scope="col">Account Type</th>
                        <th scope="col" colspan="2">Option</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    if($resultSet!= null)
                    foreach($resultSet as $rows){ ?>
                    <tr>
                        <td><?php echo $rows['username']; ?></td>
                        <td><?php echo $rows['accountType'];?></td>
                        <td><a class="btn btn-warning border-dark" href="update.php?updateid=<?php echo $rows['id'] ?>">Update</a></td>
                        <td><?php if($rows['username'] != 'admin'){?>
                            <a class="btn btn-danger border-dark" href="delete.php?deleteid=<?php echo $rows['id'] ?>">delete</a><?php }
                            else
                                echo "YOU CAN NOT DELETE </BR> ADMIN ACCOUNT!"?>
                        </td>
                    </tr>
                    <?php } ?>
                    </tbody>
                    </table>
                </div>
	    </div>
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
                    <button type="submit" class="btn btn-lg btn-success col-12" name="insert">Insert</button>
                    </form>
                </div>
                </div>
            </div>
        </div>
    </body>
</html>
<?php
    if(isset($_POST['insert'])){
        //initialization
        $name =  $_POST['name'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password =  $_POST['password'];
        $accountType = $_POST['accountType'];
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $userLinkId = uniqid('',true);

        //validation
        $query = "select * from user_tb where username = '$username'";
        if(getQuery($query) != null)
            die ("<script>alert('Name Already Exist!');</script>");
        $query = "select * from userInfo_tb where name = '$name'";
        if(getQuery($query) != null)
            die ("<script>alert('Name Already Exist!');</script>");
        $query = "select * from userInfo_tb where email = '$email'";
        if(getQuery($query) != null)
            die ("<script>alert('Email Already Exist!');</script>");

        //insert
        $query1 = "insert into user_tb(username, password, accountType, userLinkId) values('$username','$hash','$accountType','$userLinkId')";
        $query2 = "insert into userInfo_tb(name, email, otp, userLinkId) values('$name','$email','','$userLinkId')";
        if(!Query($query1))
          echo "fail to save to database";
        elseif(!Query($query2))
          echo "fail to save to database";
        else
          echo ("<script>window.location.replace('accountManagement.php'); alert('Sucess');</script>");

    }
?>

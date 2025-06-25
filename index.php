<?php include "./includes/header.php"; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Esace University</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
            text-decoration: none;
        }

        .container {
            width: 800px;
            max-width: 100%;
            margin: 50px auto;
            padding: 50px 30px;
            border-radius: 17px;
            background: rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }
        .container h1, p {
            margin: 10px 0;
        }
        .container h1{
            color: #007bff;
        }
        .container p{
            font-size: 17px;
        }
        .userbtn{
            display: flex;
            gap: 25px;
        }
        .btn{
            background: #007bff;
            color: #fff;
            border: none;
            margin-top: 20px;
            padding: 10px 15px;
            border-radius: 20px;
            transition: .5s ease-in-out;
        }
        a[class="admin btn"]{
            background: #04ad50;
        }
        a[class="admin btn"]:hover{
            color: #fff;
        }
        .btn:hover{
            transform: scale(1.07);
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Automated Clearance System</h1>
        <p>Welcome to Esace University Automated Clearance System</p>
        <p>Please select an account depending on your user role either as a student or an administrator</p>

        <div class="userbtn">
            <a href="student_login.php" class="student btn">Student Access</a>
            <a href="admin_login.php" class="admin btn">Admin Access</a>
        </div>
    </div>
</body>

</html>

<?php include "./includes/footer.php" ?>
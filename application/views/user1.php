<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Form</title>
    <style>
        .error{
            color:red;
        }
    </style>
</head>
<body>
    <?php
    //validation of data
    $UserID = $Name = $phoneNumber = $group = "";
    if($_SERVER["REQUEST_METHOD"]=="POST"){
    

        $UserID=val($_POST["UserID"]);
        $Name=val($_POST["Name"]);
        $phoneNumber=val($_POST["phoneNumber"]);
        $group=val($_POST["group"]);
        }
    
    function val($data){
        $data=trim($data);//remove unneccessary spaces
        $data=stripslashes($data);//remove unneccessary backslashes
        $data=htmlspecialchars($data);//secures data
        return $data;
    }
    ?>
    <form name="employment" action="<?php htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
        <table width="600" border="0" cellspacing="1" cellpading="1">
            <tr>
                <td><h2>user application</h2></td>
                <td></td>
            </tr>
            <tr>
                <td>UserID</td>
                <td><input type="text" name="UserID" maxlength="50"/></td>
            </tr>
            <tr>
                <td>Name</td>
                <td><input type="text" name="Name" maxlength="50"/></td>
            </tr>
            <tr>
                <td>phoneNumber</td>
                <td><input type="text" name="phoneNumber" maxlength="50"/></td>
            </tr>
            <tr>
                <td>group</td>
                <td>
                <input type="radio" name="group" value="employed" checked />group1
                <input type="radio" name="group" value="unemployed"/>group2
                </td>
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                <td><input type="submit" name="submit" value="submit"/></td>
                <td><input type="reset" name="reset" value="reset"/></td>
                </td>
            </tr>
        </table>
    </form>
    <?php
    echo "<h2>user input:</h2>";
    echo "UserID: ".$UserID;
    echo"<br>";
    echo "Name: ".$Name;
    echo"<br>";
    echo "phoneNumber: ".$phoneNumber;
    echo"<br>";
    echo "group: ".$group;
    echo"<br>";
    ?>
</body>
</html>

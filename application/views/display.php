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

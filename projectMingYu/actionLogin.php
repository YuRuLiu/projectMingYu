<?php 
    require_once("connect.php");
    header("content-type:text/html;chaset=utf-8");
    session_start();
    
    $userName = $_POST["userName"];
    $userPW = $_POST["userPW"];
    $btnlogin = $_POST["btnlogin"];
    
    if(isset ($btnlogin))
    {
        $sql = "SELECT `userName`,`userPW` FROM `employee` where userName='$userName'";
        $result = mysql_query($sql) or die('MySQL query error');
        
        $row = mysql_fetch_array($result);
        
            if($userName == $row['userName'] && $userPW ==$row['userPW'])
            {
                $_SESSION['userName'] = $userName;
                header("location: indexx.php"); 
            }
            else
                header("location: LoginFail.php");
        
    }
?>
<?php 
    require_once("connect.php");
    header("content-type:text/html;chaset=utf-8");
    
    function selectUser($userName)
    {
        $sql = "SELECT `userName`,`userPW` 
                FROM `employee` 
                where userName='$userName'";
        $result = mysql_query($sql) or die('MySQL query error');
        return mysql_fetch_array($result);
    }
?>
    
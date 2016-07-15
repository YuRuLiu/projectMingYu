<?php
    session_start();
    require_once("connect.php");
    header("content-type:text/html;charset=utf-8");
    
    
    /*--------------取得訂單資料，顯示於table----------------*/
    $sql = "SELECT `orderform`.`orderformID`,`client`.`clientName`,`client`.`deadline`,`orderform`.`total` 
            from `orderform`
            inner join `client`
            on `orderform`.`clientID`=`client`.`clientID`";
    $result = mysql_query($sql) or die('MySQL query error');
    $total = mysql_num_rows($result);       //取得資料的總數
    $pagesize=10;                           //單頁筆數
    $totalpages= ceil($total/ $pagesize);   //總頁數
    $orderpage = $_GET['orderpage'];
    if ($orderpage=="")
        $orderpage=0;
    $sql_limit = "SELECT `orderform`.`orderformID`,`client`.`clientName`,`client`.`deadline`,`orderform`.`total` 
             from `orderform`
             inner join `client`
             on `orderform`.`clientID`=`client`.`clientID`
             limit ".$orderpage*$pagesize.",".$pagesize."";
    $result_limit = mysql_query($sql_limit);
    
    /*--------------取得訂單資料，顯示於modal----------------*/
    $sql2 = "SELECT `orderform`.`orderformID`,`client`.`clientName`,`client`.`deadline`,`orderform`.`total` 
             from `orderform`
             inner join `client`
             on `orderform`.`clientID`=`client`.`clientID`";
    $result2 = mysql_query($sql2) or die('MySQL query error');
    
    /*--------------修改訂單--------------*/
    $updateOrderform = $_POST["updateOrderform"];
    $orderformID = $_POST["orderformID"];
    $clientName = $_POST["clientName"];
    $deadline = $_POST["deadline"];
    $totalPrice = $_POST["total"];
    
    if(isset ($updateOrderform))
    {         
        $updateOederform = "update `orderform`
                                    inner join `client`
                                    on `orderform`.`clientID`=`client`.`clientID`
                           set `orderform`.`orderformID`='".$orderformID."',`client`.`deadline`='".$deadline."',`orderform`.`total`='".$totalPrice."' 
                           where `client`.`clientName`='".$clientName."'";
        $oederformResult = mysql_query($updateOederform) or die('MySQL query error'); 
        $url = 'selectOrderform.php?p='.$orderpage; 
        header("refresh: 1;url='$url'"); 
    }
    
    /*--新增訂單--*/
    $insertOrderform = $_POST["insertOrderform"];
    $insertOrderformID = $_POST["insertOrderformID"];
    $insertClientName = $_POST["insertClientName"];
    $insertDeadline = $_POST["insertDeadline"];
    $insertTotal = $_POST["insertTotal"];
    
    /*--按下新增訂單--*/
    if(isset ($insertOrderform))
    {         
        /*--新增訂單編號、總金額--*/
        $insertIdTotal = "insert `orderform`(`orderformID`,`total`) value('".$insertOrderformID."','".$insertTotal."')";
        $IdTotalResult = mysql_query($insertIdTotal) or die('MySQL query error1');
        
        /*--新增案名、出殯日期--*/
        $insertNameDeadline = "insert `client`(`clientName`,`deadline`) value('".$insertClientName."','".$insertDeadline."')";
        $NameDeadlineResult = mysql_query($insertNameDeadline) or die('MySQL query error2');
        
        /*--新增案名編號--*/
        $selectClientID1 = "select `clientID` from `client` order by `clientID` DESC limit 1";
        $selectResult1 = mysql_query($selectClientID1) or die('MySQL query error1'); 
        $selectrow1 = mysql_fetch_row($selectResult1);
        $plusClientID = $selectrow1[0] + 1;
        
        if(strlen( $plusClientID )== 1)
            $plusClientID = "00000".$plusClientID;
        if(strlen( $plusClientID )== 2)
            $plusClientID = "0000".$plusClientID;
        if(strlen( $plusClientID )== 3)
            $plusClientID = "000".$plusClientID;
        if(strlen( $plusClientID )== 4)
            $plusClientID = "00".$plusClientID;
        if(strlen( $plusClientID )== 5)
            $plusClientID = "0".$plusClientID;
        if(strlen( $plusClientID )== 6)
            $plusClientID = "".$plusClientID;
            
        /*--結合案名編號及案名--*/
        $updateClientID = "update `client` set `clientID`='".$plusClientID."' where `clientID`=''";
        $updateClientIDResult = mysql_query($updateClientID) or die('MySQL query error6');
        
        $updateClientID2 = "update `orderform` set `clientID`='".$plusClientID."' where `clientID`=''";
        $updateClientIDResult2 = mysql_query($updateClientID2) or die('MySQL query error7');
        
        /*--刷新頁面--*/
        $url = 'selectOrderform.php?p='.$orderpage; 
        header("refresh: 1;url='$url'"); 
    }
    
    /*--刪除訂單--*/
    $selectOrderIDSql = "SELECT `orderform`.`orderformID`,`client`.`clientName`
                         from `orderform`
                         inner join `client`
                         on `orderform`.`clientID`=`client`.`clientID`";
    $selectOrderIDResult = mysql_query($selectOrderIDSql) or die('MySQL query error');
    
    $deleteOrderOK = $_POST["deleteOrderOK"];
    $deleteOrderID = $_POST["deleteOrderID"];
    
    if(isset($deleteOrderOK))
    {
        $deleteDetailSql = "DELETE `client` FROM `client` 
                            inner join `orderform`
                            on `client`.`clientID`=`orderform`.`clientID`
                            WHERE `orderformID` = '".$deleteOrderID."'";                    
        $deleteDetailResult = mysql_query($deleteDetailSql) or die('MySQL query error13');
        
        $deleteOrderSql = "DELETE FROM `orderform` 
                           WHERE `orderform`.`orderformID` = '".$deleteOrderID."'";
        $deleteOrderResult = mysql_query($deleteOrderSql) or die('MySQL query error11');
        
        $deleteDetailSql = "DELETE FROM `detail` 
                            WHERE `orderformID` = '".$deleteOrderID."'";
        $deleteDetailResult = mysql_query($deleteDetailSql) or die('MySQL query error12');
        
        $url = 'selectOrderform.php?orderform='.$deleteOrderID.'&p='.$page; 
        header("refresh: 1;url='$url'"); 
    }
?>
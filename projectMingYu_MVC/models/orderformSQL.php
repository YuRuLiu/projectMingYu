<?php
    require_once("connect.php");
    header("content-type:text/html;chaset=utf-8");
    
    
    function orderform_content()
    {
        $sql_orderform_content = "SELECT `orderform`.`orderformID`,`client`.`clientName`,`client`.`deadline`,`orderform`.`total` 
                                  from `orderform`
                                  inner join `client`
                                  on `orderform`.`clientID`=`client`.`clientID`";
        $result_orderform_content = mysql_query($sql_orderform_content) or die('MySQL query error1');
        return $result_orderform_content;
    }

    function orderform_paging($orderpage,$pagesize)
    {
        $sql_orderform_paging = "SELECT `orderform`.`orderformID`,`client`.`clientName`,`client`.`deadline`,`orderform`.`total` 
                                 from `orderform`
                                 inner join `client`
                                 on `orderform`.`clientID`=`client`.`clientID`
                                 limit ".$orderpage*$pagesize.",".$pagesize."";
        $result_orderform_paging = mysql_query($sql_orderform_paging) or die('MySQL query error2');
        return $result_orderform_paging;
    }
    
    function update_orderform($orderformID,$deadline,$totalPrice,$clientName)
    {
        $sql_update_orderform = "update `orderform`
                                 inner join `client`
                                 on `orderform`.`clientID`=`client`.`clientID`
                                 set `orderform`.`orderformID`='".$orderformID."',`client`.`deadline`='".$deadline."',`orderform`.`total`='".$totalPrice."' 
                                 where `client`.`clientName`='".$clientName."'";
        $result_update_orderform = mysql_query($sql_update_orderform) or die('MySQL query error3'); 
        return $result_update_orderform;
    }
    
    function insert_orderform_IDTotal($insertOrderformID,$insertTotal)
    {
        $sql_insert_orderform_IDTotal = "insert `orderform`(`orderformID`,`total`) 
                                         value('".$insertOrderformID."','".$insertTotal."')";
        $result_insert_orderform_IDTotal = mysql_query($sql_insert_orderform_IDTotal) or die('MySQL query error4');
        return $result_insert_orderform_IDTotal;     
    }
    
    function insert_orderform_NameDeadline($insertClientName,$insertDeadline)
    {
        $sql_insert_orderform_NameDeadline = "insert `client`(`clientName`,`deadline`) 
                                              value('".$insertClientName."','".$insertDeadline."')";
        $result_insert_orderform_NameDeadline = mysql_query($sql_insert_orderform_NameDeadline) or die('MySQL query error5');
        return $result_insert_orderform_NameDeadline;     
    }
    
    function select_clientID()
    {
        $sql_select_clientID = "select `clientID` 
                                from `client` 
                                order by `clientID` DESC 
                                limit 1";
        $result_select_clientID = mysql_query($sql_select_clientID) or die('MySQL query error6'); 
        $row_select_clientID = mysql_fetch_row($result_select_clientID);
        return $row_select_clientID;
    }
    
    function update_client_clientID($plusClientID)
    {
        $sql_update_client_clientID = "update `client` 
                                       set `clientID`='".$plusClientID."' 
                                       where `clientID`=''";
        $result_update_client_clientID = mysql_query($sql_update_client_clientID) or die('MySQL query error7');
        return $result_update_client_clientID;
    }
    
    function update_orderform_clientID($plusClientID)
    {
        $sql_update_orderform_clientID = "update `orderform` 
                                          set `clientID`='".$plusClientID."' 
                                          where `clientID`=''";
        $result_update_orderform_clientID = mysql_query($sql_update_orderform_clientID) or die('MySQL query error8');
        return $result_update_orderform_clientID;
    }
    
    function delete_client($deleteOrderID)
    {
        $sql_delete_client = "DELETE `client` FROM `client` 
                              inner join `orderform`
                              on `client`.`clientID`=`orderform`.`clientID`
                              WHERE `orderformID` = '".$deleteOrderID."'";                    
        $result_delete_client = mysql_query($sql_delete_client) or die('MySQL query error9');
        return $result_delete_client;
    }
    
    function delete_orderform($deleteOrderID)
    {
        $sql_delete_orderform = "DELETE FROM `orderform` 
                                 WHERE `orderform`.`orderformID` = '".$deleteOrderID."'";
        $result_delete_orderform = mysql_query($sql_delete_orderform) or die('MySQL query error10');
    }
    
    function delete_detail($deleteOrderID)
    {
        $sql_delete_detail = "DELETE FROM `detail` 
                            WHERE `orderformID` = '".$deleteOrderID."'";
        $result_delete_detail = mysql_query($sql_delete_detail) or die('MySQL query error11');
    }
?>
<?php
    session_start();
    header("content-type:text/html;charset=utf-8");
    include("../models/orderformSQL.php");
    
    /*--修改訂單POST的值--*/
    $updateOrderform = $_POST["updateOrderform"];
    $update_orderformID = $_POST["update_orderformID"];
    $update_clientName = $_POST["update_clientName"];
    $update_deadline = $_POST["update_deadline"];
    $update_total = $_POST["update_total"];
    
    /*--新增訂單POST的值--*/
    $insertOrderform = $_POST["insertOrderform"];
    $insert_orderformID = $_POST["insert_orderformID"];
    $insert_clientName = $_POST["insert_clientName"];
    $insert_deadline = $_POST["insert_deadline"];
    $insert_total = $_POST["insert_total"];
    
    /*--刪除訂單POST的值--*/
    $deleteOrderform = $_POST["deleteOrderform"];
    $delete_orderformID = $_POST["delete_orderformID"];
    
    /*--計算分頁--*/
    $result_orderform_content = orderform_content();
    $total = mysql_num_rows($result_orderform_content);//取得資料的總數
    $pagesize=10;                           //單頁筆數
    $totalpages= ceil($total/ $pagesize);   //總頁數
    $orderpage = $_GET['orderpage'];
    if ($orderpage=="")
        $orderpage=0;

    /*--顯示分頁於table--*/
    $result_orderform_paging = orderform_paging($orderpage,$pagesize);
    
    /*--修改訂單--*/
    $result_update_orderform_content = orderform_content();
    
    if(isset ($updateOrderform))
    {         
        $result_update_orderform = update_orderform($update_orderformID,$update_deadline,$update_total,$update_clientName);
        refresh_orderform();
    }
    
    /*--新增訂單--*/
    if(isset ($insertOrderform))
    {         
        $result_insert_orderform_IDTotal = insert_orderform_IDTotal($insert_orderformID,$insert_total);
        $result_insert_orderform_NameDeadline = insert_orderform_NameDeadline($insert_clientName,$insert_deadline);
        
        $plusClientID = increment_clientID();
        
        $result_update_client_clientID = update_client_clientID($plusClientID);
        $result_update_orderform_clientID = update_orderform_clientID($plusClientID);
        
        refresh_orderform();
    }
    
    /*--刪除訂單--*/
    $result_delete_orderform_content = orderform_content();
    
    if(isset($deleteOrderform))
    {
        $result_delete_client = delete_client($delete_orderformID);
        $result_delete_orderform = delete_orderform($delete_orderformID);
        $result_delete_detail = delete_detail($delete_orderformID);
        
        refresh_orderform();
    }
    
    /*--增加clientID--*/
    function increment_clientID()
    {
        $row_select_clientID = select_clientID();
        $plusClientID = $row_select_clientID[0] + 1;
        $plusClientID = str_pad($plusClientID,6,'0',STR_PAD_LEFT);
        return $plusClientID;
    }
    
    /*--刷新頁面--*/
    function refresh_orderform()
    {
        $url = '../views/orderform.php?p='.$orderpage; 
        header("refresh: 1;url='$url'"); 
    }
?>
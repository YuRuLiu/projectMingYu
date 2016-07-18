<?php 
    session_start();
    header("content-type:text/html;charset=utf-8");
    include("../models/detailSQL.php");
    
    /*--取得此筆訂單編號--*/
    $orderform=$_GET['orderform'];
    
    /*--修改明細POST的值--*/
    $updateDetailOK = $_POST["updateDetailOK"];
    $update_quantity = $_POST["update_quantity"];
    $update_productID = $_POST["update_productID"];
    $update_orderformID = $_POST["update_orderformID"];
    $page = $_POST["p"];
    
    /*--新增明細POST的值--*/
    $insertDetailOK=$_POST["insertDetailOK"];
    $product = $_POST ["product"];
    $insertQuantity = $_POST["insertQuantity"];
    $insert_orderformID = $_POST["insert_orderformID"];
    $insert_clientID = $_POST["clientID"];
    
    /*--刪除明細POST的值--*/
    $deleteDetailOK = $_POST["deleteDetailOK"];
    $delete_productID = $_POST["delete_productID"];
    $delete_orderformID = $_POST["delete_orderformID"];
    
    /*--取得案名--*/
    $row_select_clientName = select_clientName($orderform);
    
    /*--計算分頁--*/
    $result_detail_content = detail_content($orderform);
    $total = mysql_num_rows($result_detail_content); //取得資料的總數
    $pagesize=10;                           //單頁筆數
    $totalpages= ceil($total/ $pagesize);   //總頁數
    $detailPage = $_GET['detailPage'];
    if ($detailPage=="")
        $detailPage=0;
    
    /*--顯示分頁於table--*/
    $result_detail_paging = detail_paging($orderform,$detailPage,$pagesize);
    
    /*--修改明細數量--*/
    $result_update_orderform_content = detail_content($orderform);
    
    if(isset ($updateDetailOK))
    {
        $result_update_detail_quantity = update_detail_quantity($update_quantity,$update_productID);
        refresh_detail($update_orderformID,$page);
    }
    
    /*--新增明細--*/
    $result_select_product = select_product();//顯示商品清單
    $quantityNotNull = @array_filter($insertQuantity); //將空值濾掉，保留有值的元素
    $insertDetail = @array_combine($product, $quantityNotNull); //結合2個陣列，2個陣列元素的數量須相同
    
    if(isset($insertDetailOK))
    {
        foreach ($insertDetail as $key => $value)
        {    
            $result_insert_detail = insert_detail($insert_orderformID,$key,$value,$insert_clientID);
        }
        refresh_detail($insert_orderformID,$page);
    }
    
    /*--刪除明細--*/
    $result_delete_orderform_content = detail_content($orderform);
    
    if(isset($deleteDetailOK))
    {
        $result_delete_detail = delete_detail($delete_orderformID,$delete_productID);
        refresh_detail($delete_orderformID,$page);
    }
    
    function refresh_detail($orderID,$page)
    {
        $url = '../views/detail.php?orderform='.$orderID.'&detailPage='.$page; 
        header("refresh: 1;url='$url'"); 
    }
?>
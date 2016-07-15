<?php 
    session_start();
    require_once("connect.php");
    header("content-type:text/html;charset=utf-8");
    
    /*--取得此筆訂單編號--*/
    $orderform=$_GET['orderform'];
    
    /*--取得案名--*/
    $clientNameSql = "SELECT `client`.`clientName`,`client`.`clientID` 
                      from `orderform`
                      inner join `client`
                      on `orderform`.`clientID`=`client`.`clientID`
                      where `orderformID`='".$orderform."'";
    $clientNameResult = mysql_query($clientNameSql) or die('MySQL query error');
    $clientNameRow = mysql_fetch_row($clientNameResult);
    /*--頁數--*/
    $p = $_GET['p'];
    $pagesize=10;//每頁10筆
    
    if ($p=="" || $p<0)
        $p=0;
        
    /*--取得此筆訂單明細資料--*/
    $sql="SELECT `detail`.`productID`,`product`.`productName`,`detail`.`quantity` 
           from `detail` 
           INNER JOIN  `product`
           on `detail`.`productID` = `product`.`productID`
           where `detail`.`orderformID`= '".$orderform."'";
    $result = mysql_query($sql) or die('MySQL query error');
    
    /*--取得每頁顯示的訂單明細資料--*/
    $sql_limit = " select `detail`.`productID`,`product`.`productName`,`detail`.`quantity` 
                   from `detail` 
                   inner join  `product`
                   on `detail`.`productID` = `product`.`productID`
                   where `detail`.`orderformID`= '".$orderform."'
                   limit ".($p * $pagesize).", ".$pagesize."";
    $result_limit = mysql_query($sql_limit) or die('MySQL query error');
    
    /*--取得此筆訂單的資料總數--*/
    $total = mysql_num_rows($result);
    
    /*--總頁數--*/
    $totalpages= ceil($total/ $pagesize);
    
    /*--取得此筆訂單明細資料--*/
    $sql2="SELECT `detail`.`productID`,`product`.`productName`,`detail`.`quantity`,`detail`.`orderformID` 
           from `detail` 
           INNER JOIN  `product`
           on `detail`.`productID` = `product`.`productID`
           where `detail`.`orderformID`= '".$orderform."'";
    $result2 = mysql_query($sql2) or die('MySQL query error'); 
    
    /*--修改數量--*/
    $btnstore = $_POST["btnstore"];
    $quantity = $_POST["quantity"];
    $productID = $_POST["productID"];
    $orderformID = $_POST["orderformID"];
    $page = $_POST["p"];
    
    if(isset ($btnstore))
    {
        $updateQuantity = "update `detail` 
                           set `quantity`='".$quantity."'
                           where `productID`='".$productID."'";
        $quantityResult = mysql_query($updateQuantity) or die('MySQL query error'); 
        $url = 'detail.php?orderform='.$orderformID.'&p='.$page; 
        header("refresh: 1;url='$url'"); 
    }
    
    /*--新增明細--*/
    $productSql = "select `productID`,`productName` 
                   from `product` 
                   where `placeID`='2'";
    $productResult = mysql_query($productSql) or die('MySQL query error8'); 
    
    $insertDetailOK=$_POST["insertDetailOK"];
    $product = $_POST ["product"];
    $insertQuantity = $_POST["insertQuantity"];
    $orderID = $_POST["orderform"];
    $clientID = $_POST["clientID"];
    
    $quantityNotNull = @array_filter($insertQuantity); //將空值濾掉，保留有值的元素
    $insertDetail = @array_combine($product, $quantityNotNull); //結合2個陣列，2個陣列元素的數量須相同
    
    if(isset($insertDetailOK))
    {
        foreach ($insertDetail as $key => $value)
        {    
            $insertDetailSql = "insert into `detail`
                                (`orderformID`,`productID`,`quantity`,`clientID`)
                                values('".$orderID."','".$key."','".$value."','".$clientID."')";
            $insertDetailResult = mysql_query($insertDetailSql) or die('MySQL query error9');
        }
        
        $url = 'detail.php?orderform='.$orderID.'&p='.$page; 
        header("refresh: 1;url='$url'"); 
    }
    /*--刪除明細--*/
    $selectDetailSql = "SELECT `detail`.`productID`,`product`.`productName`,`detail`.`quantity` 
                        from `detail` 
                        INNER JOIN  `product`
                        on `detail`.`productID` = `product`.`productID`
                        where `detail`.`orderformID`= '".$orderform."'";
    $selectDetailResult = mysql_query($selectDetailSql) or die('MySQL query error10');
    
    $deleteDetailOK = $_POST["deleteDetailOK"];
    $deleteProductID = $_POST["deleteProductID"];
    $deleteOrderformID = $_POST["deleteOrderformID"];
    
    if(isset($deleteDetailOK))
    {
        $deleteDetailSql = "DELETE FROM `detail` WHERE `orderformID` = '".$deleteOrderformID."' AND `productID` = '$deleteProductID'";
        $deleteDetailResult = mysql_query($deleteDetailSql) or die('MySQL query error11');
        $url = 'detail.php?orderform='.$deleteOrderformID.'&p='.$page; 
        header("refresh: 1;url='$url'"); 
    }
?>
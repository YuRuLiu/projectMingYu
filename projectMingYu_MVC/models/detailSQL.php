<?php
    require_once("connect.php");
    header("content-type:text/html;chaset=utf-8");
    
    function select_clientName($orderform)
    {
        $sql_select_clientName = "SELECT `client`.`clientID`,`client`.`clientName` 
                                  from `orderform`
                                  inner join `client`
                                  on `orderform`.`clientID`=`client`.`clientID`
                                  where `orderformID`='".$orderform."'";
        $result_select_clientName = mysql_query($sql_select_clientName) or die('MySQL query error1');
        $row_select_clientName = mysql_fetch_row($result_select_clientName);
        return $row_select_clientName;
    }
    
    function detail_content($orderform)
    {
        $sql_detail_content = "SELECT `detail`.`productID`,`product`.`productName`,`detail`.`quantity`,`detail`.`orderformID` 
                               from `detail` 
                               INNER JOIN  `product`
                               on `detail`.`productID` = `product`.`productID`
                               where `detail`.`orderformID`= '".$orderform."'";
        $result_detail_content = mysql_query($sql_detail_content) or die('MySQL query error2');
        return $result_detail_content;
    }
    
    function detail_paging($orderform,$p,$pagesize)
    {
        $sql_detail_paging = "select `detail`.`productID`,`product`.`productName`,`detail`.`quantity` 
                              from `detail` 
                              inner join  `product`
                              on `detail`.`productID` = `product`.`productID`
                              where `detail`.`orderformID`= '".$orderform."'
                              limit ".($p * $pagesize).", ".$pagesize."";
        $result_detail_paging = mysql_query($sql_detail_paging) or die('MySQL query error3');
        return $result_detail_paging;
    }
    
    function update_detail_quantity($quantity,$productID)
    {
        $sql_update_detail_quantity = "update `detail` 
                                       set `quantity`='".$quantity."'
                                       where `productID`='".$productID."'";
        $result_update_detail_quantity = mysql_query($sql_update_detail_quantity) or die('MySQL query error4'); 
        return $result_update_detail_quantity;
    }
    
    function select_product()
    {
        $sql_select_product = "select `productID`,`productName` 
                               from `product` 
                               where `placeID`='2'";
        $result_select_product = mysql_query($sql_select_product) or die('MySQL query error5');
        return $result_select_product;
    }
    
    function insert_detail($orderID,$key,$value,$clientID)
    {
        $sql_insert_detail = "insert into `detail`
                              (`orderformID`,`productID`,`quantity`,`clientID`)
                              values('".$orderID."','".$key."','".$value."','".$clientID."')";
        $result_insert_detail = mysql_query($sql_insert_detail) or die('MySQL query error6');
        return $result_insert_detail;
    }
    
    function delete_detail($deleteOrderformID,$deleteProductID)
    {
        $sql_delete_detail = "DELETE FROM `detail` 
                            WHERE `orderformID` = '".$deleteOrderformID."' AND `productID` = '$deleteProductID'";
        $result_delete_detail = mysql_query($sql_delete_detail) or die('MySQL query error7');
        return $result_delete_detail;
    }

?>
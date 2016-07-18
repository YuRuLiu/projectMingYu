<?php 
    require_once("../controllers/actionDetail.php");
?>
<!DOCTYPE html>
<html lang="zh-Hant-TW">
    <head>
        
        <title>明昱生命禮儀-訂單明細</title>
        
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
    
        <!-- Bootstrap Core CSS -->
        <link href="bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    
        <!-- MetisMenu CSS -->
        <link href="bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">
    
        <!-- Custom CSS -->
        <link href="dist/css/sb-admin-2.css" rel="stylesheet">
    
        <!-- Custom Fonts -->
        <link href="bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

        <!-- DataTables CSS -->
        <link href="../bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet">

        <!-- DataTables Responsive CSS -->
        <link href="../bower_components/datatables-responsive/css/dataTables.responsive.css" rel="stylesheet">
        
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        <script src="js/jquery.js"></script>
        <script src="js/bootstrap.js"></script>
    </head>
    
    <body>
        <!--------------公司名稱---------------->
        <div class="container-fluid">
            <div class="col-md-4 col-md-offset-5">
                <font size="7" face="微軟正黑體"><strong>明昱生命禮儀</strong></font>
            </div>
        </div>
        <!--------------功能列---------------->
        <div class="container-fluid col-md-offset-3">
            <div class="row">
                <div class="col-md-3">
                    <h4><a href="indexx.php">行事曆</a></h4>
                </div>
                <div class="col-md-3"><h4><a href="orderform.php">訂單列表</a></h4></div>
                <div class="col-md-3"><h4>使用者身分：<?php echo $_SESSION['userName'];?></h4></div>
                <div class="col-md-3"><h4><a href="Logout.php">登出</a></h4></div>
            </div>
        </div>
        <hr>
        <!--------------訂單明細---------------->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">訂單明細<br>
                                               訂單編號：<?php echo $orderform;?><br>
                                               案名：<?php echo $row_select_clientName[1];?><br>
                                               <button type="button" class="btn btn-info" data-toggle="modal" data-target="#detailModal">
                                                    新增明細
                                               </button> 
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="dataTable_wrapper">
                            <div class="row">
                                <div class="col-sm-6"></div>
                            </div>
                            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>編輯</th>
                                        <th>商品編號</th>
                                        <th>品名</th>
                                        <th>數量</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        /*顯示訂單明細資料*/   
                                        while($row_detail_paging = mysql_fetch_row($result_detail_paging)){ ?>    
                                            <tr class="odd gradeX">
                                                <td>
                                                    <button type="button" class="btn-primary" data-toggle="modal" data-target="#myModal<?php echo $row_detail_paging[0];?>">
                                                        修改
                                                    </button> 
                                                    <button type="button" class="btn-danger" data-toggle="modal" data-target="#deleteDetail<?php echo $row_detail_paging[0];?>">
                                                        刪除
                                                    </button>     
                                                </td>
                                                <td><?php echo $row_detail_paging[0]?></td>
                                                <td><?php echo $row_detail_paging[1]?></td>
                                                <td><?php echo $row_detail_paging[2]?></td>
                                            </tr>
                                    <?php } ?> 
                                </tbody>
                            </table>
                        </div>
                        <!--明細總筆數-->    
                        <div class="col-sm-6">
                            <div class="dataTables_info" id="dataTables-example_info" role="status" aria-live="polite">共 <?php echo $total?> 筆</div>
                        </div>
                        <!--分頁-->
                        <div class="col-sm-4">
                            <div class="dataTables_paginate paging_simple_numbers" id="dataTables-example_paginate">
                                <ul class="pagination">
                                    <?php 
                                        for($i=0;$i<$totalpages;$i++){
                                            if($i==$detailPage){?>    
                                                <li class="paginate_button active" aria-controls="dataTables-example" tabindex="0"><a href="detail.php?orderform=<?php echo $orderform ?>&detailPage=<?php echo $i ?>"><?php echo $i+1?></a></li>
                                            <?php }
                                            else{?>
                                                <li class="paginate_button" aria-controls="dataTables-example" tabindex="0"><a href="detail.php?orderform=<?php echo $orderform ?>&detailPage=<?php echo $i ?>"><?php echo $i+1?></a></li>
                                            <?php }
                                    }?>
                                    <input style="visibility:hidden" name="p" value="<?php echo $detailPage;?>"/>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
        <?php
            while($row_update_orderform_content = mysql_fetch_row($result_update_orderform_content)){ ?>
            <!-- 修改明細的Modal -->
            <div class="modal fade" id="myModal<?php echo $row_update_orderform_content[0];?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form method="post" action="../controllers/actionDetail.php">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                <h4 class="modal-title" id="myModalLabel">修改數量</h4>
                            </div>
                            <div class="modal-body">    
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>    
                                        <tr>
                                            <th>商品編號</th>
                                            <th>品名</th>
                                            <th>數量</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><?php echo $row_update_orderform_content[0];?></td>
                                            <td><?php echo $row_update_orderform_content[1];?></td>
                                            <td>
                                                <button type="button" class="btn btn-default" aria-label="Left Align">
                                                    <span class="glyphicon glyphicon-minus-sign" aria-hidden="true"></span>
                                                </button>
                                                <input type="text" name="update_quantity" value="<?php echo $row_update_orderform_content[2];?>"></input>
                                                <button type="button" class="btn btn-default" aria-label="Left Align">
                                                    <span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span>
                                                </button>    
                                            </td>
                                        </tr>    
                                    </tbody>
                                </table>
                            </div>
                            <div class="modal-footer">
                                <input style="visibility:hidden" name="update_productID" value="<?php echo $row_update_orderform_content[0];?>"/>
                                <input style="visibility:hidden" name="update_orderformID" value="<?php echo $row_update_orderform_content[3];?>"/>
                                <button type="submit" class="btn btn-primary" name="updateDetailOK">儲存變更</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php }?>
        <?php 
            while($row_delete_orderform_content = mysql_fetch_row($result_delete_orderform_content)){ ?>
            <!-- 刪除明細的Modal -->
            <div class="modal fade bs-example-modal-sm" id="deleteDetail<?php echo $row_delete_orderform_content[0];?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form method="post" action="../controllers/actionDetail.php">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                <h4 class="modal-title" id="myModalLabel">確定刪除此筆品項嗎？</h4>
                            </div>
                            <div class="modal-body">
                                商品編號：<?php echo $row_delete_orderform_content[0];?><br>
                                品名：<?php echo $row_delete_orderform_content[1];?><br>
                                數量：<?php echo $row_delete_orderform_content[2];?>
                            </div>
                            <div class="modal-footer">
                                <input style="visibility:hidden" name="delete_orderformID" value="<?php echo $orderform;?>"/>
                                <input style="visibility:hidden" name="delete_productID" value="<?php echo $row_delete_orderform_content[0];?>"/>
                                <button type="submit" class="btn btn-primary" name="deleteDetailOK">確定刪除</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php }?>
        <!-- 新增明細的Modal -->
        <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="post" action="../controllers/actionDetail.php">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <h4 class="modal-title" id="myModalLabel">新增明細</h4>
                        </div>
                        <div class="modal-body">
                            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>    
                                        <tr>
                                            <th>品名</th>
                                            <th>數量</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while($row_select_product = mysql_fetch_row($result_select_product)){?>
                                        <tr>
                                            <td>    
                                                <input type="checkbox" value="<?php echo $row_select_product[0];?>" name="product[]"><?php echo $row_select_product[1];?>
                                            </td>
                                            <td>
                                                <input type="text" value="" name="insertQuantity[]">
                                            </td>    
                                        </tr> 
                                        <?php }?>
                                    </tbody>
                                </table>
                        </div>
                        <div class="modal-footer">
                            <input style="visibility:hidden" name="insert_orderformID" value="<?php echo $orderform;?>"/>
                            <input style="visibility:hidden" name="$insert_clientID" value="<?php echo $row_select_clientName[0];?>"/>
                            <button type="submit" class="btn btn-primary" name="insertDetailOK">確定新增</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>
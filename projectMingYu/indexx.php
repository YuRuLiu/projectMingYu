<?php session_start();?>
<!DOCTYPE html>
<html lang="zh-Hant-TW">
    <head>
        
        <title>明昱生命禮儀-首頁</title>
        
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

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    
    <body>
        <!--------------公司名稱---------------->
        <div class="col-md-4 col-md-offset-5">
            <font size="7" face="微軟正黑體"><strong>明昱生命禮儀</strong></font>
        </div>
        <!--------------功能列---------------->
        <div class="row">
            <div class="col-md-2 col-md-offset-3"><h4><a href="selectOrderform.php">訂單管理</a></h4></div>
            <div class="col-md-2 col-md-offset-3"><h4>使用者身分：<?php echo $_SESSION['userName'];?></h4></div>
            <div class="col-md-1"><h4><a href="Logout.php">登出</a></h4></div>
        </div>
        <hr>
        <!--------------google行事曆---------------->
        <div class="row">
            <iframe src="https://calendar.google.com/calendar/embed?title=%E6%98%8E%E6%98%B1%E7%94%9F%E5%91%BD%E7%A6%AE%E5%84%80&amp;height=600&amp;wkst=1&amp;bgcolor=%23ffffcc&amp;src=gm.nfu.edu.tw_8mg6nfs45s1aatq590910skim0%40group.calendar.google.com&amp;color=%230F4B38&amp;ctz=Asia%2FTaipei" style="border:solid 1px #777" width="800" height="600" frameborder="0" scrolling="no" class="col-md-offset-3"></iframe>
        </div>

    </body>
</html>
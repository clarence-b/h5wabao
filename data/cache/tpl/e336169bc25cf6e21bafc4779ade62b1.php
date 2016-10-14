<?php exit;?>001506686813948efa32c2ce9923c6874ab5fb412478s:4027:"a:2:{s:8:"template";s:3963:"<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no">
    <meta content="telephone=no, address=no" name="format-detection">
    <meta name="apple-mobile-web-app-capable" content="yes"> 
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <title>“丰”收赢大奖</title>
    <link rel="stylesheet" href="<?php echo PUBLIC_URL;?>assets/css/reset.css">
    <link rel="stylesheet" href="<?php echo PUBLIC_URL;?>assets/css/animate.css">
    <link rel="stylesheet" href="<?php echo PUBLIC_URL;?>assets/css/app.css">
    <script>
        var html = document.getElementsByTagName('html')[0];
        var pageWidth = html.getBoundingClientRect().width;
        html.style.fontSize = pageWidth / 10 + "px";
    </script>
</head>
<body>
    
    <img id="pathimg" src="<?php echo ROOT_URL;?>share.jpg" alt="“丰”收赢大奖">

    <section id="loading">
        <div id="caseBlanche">
          <div id="rond">
            <div id="test"></div>
          </div>
          <div id="load">loading</div>
        </div>
    </section>

    <section id="page1">
        <img src="<?php echo PUBLIC_URL;?>assets/images/01_page_bg.jpg" class="bg">
        <div class="box animated"></div>
        <div class="title animated"></div>
        <a href="javascript:;" id="go">开启神秘宝箱</a>
    </section>

    <section id="page2" class="hide">
        <a href="javascript:;" id="logLink" class="logLink">中奖记录</a>
        <img src="<?php echo PUBLIC_URL;?>assets/images/02_page_bg.jpg" class="bg">
        <span id="oppor">0</span>
        <div class="fields">
            <div class="row1">
                <div class="col"></div>
                <div class="col"></div>
                <div class="col"></div>
            </div>
            <div class="row2">
                <div class="col"></div>
                <div class="col"></div>
                <div class="col"></div>
            </div>
            <div class="row3">
                <div class="col"></div>
                <div class="col"></div>
                <div class="col"></div>
            </div>
        </div>
        <a href="javascript:;" id="start" class="animated">
            <div class="wrap">
                <span class="scoop animated tada"></span>
                <span class="tu animated bounce"></span>
                <span class="box animated tada"></span>
            </div>
        </a>
        <img id="prize" class="prize animated flash hide">
    </section>

    <section id="page3" class="hide">
        <header class="header">
            中奖记录
        </header>
        <div class="content">
            <div class="opticon">
                <span>奖品名称</span>
                <span>状态</span>
            </div>
            <div class="item">
                <div id="prize_name" class="name"></div>
                <div id="prize_state" class="state">
                    <span class="accept hide">已领奖</span>
                    <button type="button" id="btnAccept" class="btn">领奖</button>
                </div>
            </div>
        </div>
        <footer class="footer">
            <button type="button" id="btnClose" class="btn2">关闭</button>
            <div class="info">
                兑换地址：请到N2厅/B馆/B1展台丰田展区 进行礼品兑换
            </div>
        </footer>
        <div class="acceptWrap hide">
            <div class="wrap">
                <input type="text" id="code" placeholder="验证码">
                <button type="button" id="btnOk" class="btn3">确认</button>
            </div>
        </div>
    </section>
    
    <script src="//cdn.bootcss.com/jquery/3.1.0/jquery.min.js"></script>
    <script> var baseUrl = '<?php echo PUBLIC_URL;?>'; </script>
    <script src="<?php echo PUBLIC_URL;?>assets/js/app.min.js"></script>
</body>
</html>";s:12:"compile_time";i:1475150813;}";
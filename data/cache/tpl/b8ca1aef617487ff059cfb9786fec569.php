<?php exit;?>00150658565299b8a84c4d0c2ca9b626959e88dd2e2as:2616:"a:2:{s:8:"template";s:2552:"<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <title>礼品后台管理</title>
  <link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <style>
      .item {
        margin-bottom: 20px;
      }
  </style>
</head>
<body>
  
    <div class="container">
        <div class="page-header">
            <h3>“丰”收赢大奖 <small>奖品库存后台设置</small></h3>
            <a href="<?php echo ROOT_URL;?>index.php?r=admin/default/log" class="btn btn-success">用户中奖列表</a>
        </div>
        <form class="form-inline" role="form">
            <?php if( is_array($prizes) ) { foreach($prizes as $vo){ ?>
            <div class="row item">
                <div class="form-group col-md-2">
                    <p class="form-control-static"><?php echo $vo['prize_name']; ?></p>
                </div>
                <div class="form-group col-md-3">
                    <input type="number" min="0" value="<?php echo $vo['prize_stock']; ?>" class="form-control" placeholder="库存">
                </div>
                <button type="button" data-id="<?php echo $vo['prize_id']; ?>" class="btn btn-default">保存</button>
            </div>
            <?php }} ?>
        </form>

        <div id="success" class="alert alert-success" style="display: none">修改成功!</div>
        <div id="danger" class="alert alert-danger" style="display: none">修改失败!</div>
    </div>
    
    <script src="//cdn.bootcss.com/jquery/3.1.0/jquery.min.js"></script>
    <script>
        $(function(){
            $('button').on('click', function() {
                var _id = $(this).data('id');
                var _stock = $(this).parent().find('input[type=number]').val();
                $.post('index.php?r=admin/default/update', {pid: _id, stock: _stock}, function(data) {
                    if(data) {
                        $('#success').fadeIn(300);
                        setTimeout(function(){
                            $('#success').fadeOut(300);
                        }, 2000);
                    }else{
                        $('#danger').fadeIn(300);
                        setTimeout(function(){
                            $('#danger').fadeOut(300);
                        }, 2000);
                    }
                });
            });
        });
    </script>
</body>
</html>";s:12:"compile_time";i:1475049652;}";
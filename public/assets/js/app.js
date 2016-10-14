;(function(){
    var app = {
        localStor: window.localStorage
        ,GuID: window.localStorage.getItem('GuID')
        ,elemLoad: $('#loading')
        ,page1: $('#page1')
        ,page2: $('#page2')
        ,homeBox: $('#page1 .box')
        ,homeTitle: $('#page1 .title')
        ,btnGo: $('#go')
        ,btnStart: $('#start')
        ,fieldsCol: $('.fields .col')
        ,disX: 0
        ,disY: 0
        ,pageX: 0
        ,pageY: 0
        ,elemPrize: $('#prize')
        ,elemOppor: $('#oppor')
        ,elemLogLink: $('#logLink')
        ,elemBtnAccept: $('#btnAccept')
        ,elemBtnClose: $('#btnClose')
        ,elemBtnOK: $('#btnOk')
        ,init: function(){
            this.guid();
            this.imgInit();
            this.goto();
            this.start();
            this.showAccept();
        }
        ,imgInit: function(){
            var _that = this;
            var imgBg1 = $('#page1 img').eq(0);
            var imgBg2 = $('#page2 img').eq(0);
            var pathimg = $('#pathimg');
            imgBg1.attr('src', imgBg1.data('src'));
            imgBg2.attr('src', imgBg2.data('src'));
            pathimg.attr('src', pathimg.data('src'));

            var loadSt = setTimeout(function(){
                _that.elemLoad.hide();
                _that.homeTitle.addClass('fadeInLeft delay500');
                _that.homeBox.addClass('tada delay1200');
                clearTimeout(loadSt);
            }, 1000);
        }
        ,newGuid: function(){
            var _that = this;
            $.get('index.php?r=main/api/apiCteateNewUser', {}, function(res) {
                _that.localStor.setItem('GuID', res);
                _that.elemOppor.text(3);

                _that.GuID = _that.localStor.getItem('GuID');
                console.log('NEW GUID: ' + res);
            });
        }
        ,guid: function(){
            var _that = this;
            if (_that.GuID) {
                $.get('index.php?r=main/api/apiGetUserByGuID', {guid: _that.GuID}, function(res) { 
                    if (res.code > 0) {
                        var data = $.parseJSON(res.data);
                        _that.elemOppor.text(data.oppor);
                    }else{
                        _that.newGuid();
                    }
                },'JSON');
                console.log('GUID: ' + _that.GuID);
            }else{
                //alert('Not Find GuID');
                _that.newGuid();
            }
        }
        ,goto: function(){
            var _that = this;
            _that.btnGo.on('click', function() {
                _that.page1.hide();
                _that.page2.fadeIn('slow');
            });
        }
        ,start: function(){
            var _that = this;
            var isOn = true;
            _that.fieldsCol.on('click', function() {
                if(isOn) {
                    $('.wrap span').hide();
                    pageX = event.pageX;
                    pageY = event.pageY;
                    disX = pageX - $(this).offset().left;
                    disY = pageY - $(this).offset().top;

                    //抽奖
                    app.getPrize();
                    isOn = false;
                }
                var st = setTimeout(function(){isOn = true; clearTimeout(st);}, 5000);
            });
        }
        ,startScoop: function(callback){
            var _that = this;
            _that.btnStart.fadeIn().css({
                left: pageX - disX,
                top: pageY - disY - 20
            });
            setTimeout(function(){
                $('.scoop').fadeIn(300);
            }, 500);
            setTimeout(function(){
                $('.tu').fadeIn(300);
            }, 1000);
            setTimeout(function(){
                $('.box').fadeIn(300);
                $('.scoop').fadeOut(300);
            }, 2000);

            if (callback) {
                setTimeout(callback, 3500);
            }
        }
        ,notScoop: function(callback){
            var _that = this;
            _that.btnStart.fadeIn().css({
                left: pageX - disX,
                top: pageY - disY - 20
            });
            setTimeout(function(){
                $('.scoop').fadeIn(300);
            }, 500);
            setTimeout(function(){
                $('.tu').fadeIn(300);
            }, 1000);

            if (callback) {
                setTimeout(callback, 2000);
            }
        }
        ,getPrize: function(){
            var _that = this;
            var oppor = parseInt(_that.elemOppor.text());
            if( oppor == 0 ) {
                _that.dialogMsg('您没有抽奖机会了!');
            }
            else if (oppor > 0) {
                $.post('index.php?r=main/api/apiGetSeckill', {guid:_that.GuID}, function(res) {
                    console.log(res);
                    if(res.code == -1){
                        _that.notScoop(function(){
                            _that.dialogMsg(res.message);
                        });                        
                    }else{
                        var data = $.parseJSON(res.data);
                        //console.log(data);
                        if (res.code) {
                            _that.startScoop(function(){
                                _that.elemPrize.attr('src', baseUrl + 'assets/images/prize_0' + data.prize_id + '.png').fadeIn('slow');
                                $('#prize_state').show();
                            });
                            _that.startScoop(function(){_that.dialogForm();});
                        }else{
                            _that.notScoop(function(){
                                _that.dialogMsg(res.message);
                            });
                        }
                        _that.elemOppor.text(parseInt(_that.elemOppor.text())-1);
                    }
                },'JSON');
            }
        }
        ,dialogMsg: function(msg){
            var html = '<div class="dialogMsg">\
                <span>{{msg}}</span>\
            </div>';
            $('body').append( html.replace(/{{msg}}/, msg) );
            setTimeout(function() {
                $('.dialogMsg').remove();
            }, 3000)
        }
        ,dialogForm: function(){
            var html = '<div id="bindUser" class="bindWrap">\
                            <div class="bindWrap-title">提交用户信息</div>\
                            <div class="bindWrap-content">\
                                <input type="text" placeholder="姓名" name="username" id="username">\
                                <input type="tel" placeholder="电话" name="telephone" id="telephone">\
                            </div>\
                            <button type="button" class="bindWrap-btn" id="subUser">提交信息</button>\
                        </div>';
            $('body').append( html );

            $('#subUser').on('click', function() {
                var _username = $('#username').val();
                var _telephone = $('#telephone').val();
                if (_username.length > 0 && _telephone.length > 0) {

                    var reg_name = /^[\u4E00-\u9FA5]{2,4}$/;
                    var reg_tel = /^0?1[3|4|5|7|8][0-9]\d{8}$/;

                    if (!reg_name.test(_username)) {
                        app.dialogMsg('用户名必须2-4位汉字!');
                        return false;
                    }
                    if (!reg_tel.test(_telephone)) {
                        app.dialogMsg('手机号码格式不正确!');
                        return false;
                    }

                    $.ajax({
                        url: 'index.php?r=main/api/apiOnSubmit',
                        type: 'POST',
                        dataType: 'json',
                        data: {guid: app.GuID,username: _username,telephone: _telephone},
                    })
                    .done(function(data) {
                        //data && app.dialogMsg('提交成功!');
                        //$('#bindUser').remove();
                        if (data) {
                            app.dialogMsg('提交成功!');
                            $('#bindUser').remove();
                        }else{
                            app.dialogMsg('失败!!!');
                        }
                    })
                    .fail(function() {
                        app.dialogMsg('submit error!');
                    });
                }else{
                    app.dialogMsg('请填写用户信息!');
                }
            });
        }
        ,showAccept: function(){
            var _that = this;
            var _acceptWrap = $('.acceptWrap');
            _that.elemLogLink.on('click', function() {
                $.getJSON('index.php?r=main/api/apiViewUserByPrizes', {guid:app.GuID}, function(json) {
                    if( json.code ) {
                        var data = $.parseJSON(json.data);
                        $('#prize_name').html(data.prize_name);

                        if(parseInt(data.accept) == 1) {
                            $('#prize_state > #btnAccept').hide();
                            $('#prize_state > .accept').show();
                        }else{
                            $('#prize_state > #btnAccept').show();
                            $('#prize_state > .accept').hide();
                        }
                    }else{
                        $('#prize_state').hide();
                    }
                });
                $('#page2').fadeOut(300, function() {
                    $('#page3').fadeIn(300);
                });
            });
            _that.elemBtnAccept.on('click', function() {
                $.get('index.php?r=main/api/apiGetSubmitStatus', {guid:app.GuID}, function(state) {
                    if(state == 0) {
                        //app.dialogMsg('请先填写用户信息!');
                        _that.dialogForm();
                    }else{
                        _acceptWrap.fadeIn(300);
                    }
                });
                
            });
            _that.elemBtnClose.on('click', function() {
                $('#page3').fadeOut(300, function(){
                    $('#page2').fadeIn(300);
                });
            });
            _that.elemBtnOK.on('click', function() {
                var _code = $('#code').val();
                if(_code.length > 0) {
                    $.post('index.php?r=main/api/apiUpdateUserByAccept', {guid:app.GuID,code: _code}, function(data) {
                        if(data.code) {
                            _acceptWrap.hide();
                            $('#prize_state').html('<span class="accept">已领奖</span>');
                        }
                        app.dialogMsg(data.message);
                    }, 'json');
                }
            });
        }
    };

    /*document.onreadystatechange = function () {
        if(document.readyState=="complete") {
            app.init();
        }
    }*/

    window.onload = function(){
        app.init();
    }

})();
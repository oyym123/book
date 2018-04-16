<link rel="stylesheet" href="../../public/css/weui.css"/>
<div class="weui-mask" id="mask" style="display: none;"></div>
<div class="page">
    <div id="dialogs">
        <!--BEGIN dialog2-->
        <div class="js_dialog" id="iosDialog1" style="display: none;">
            <div class="weui-dialog">
                <div class="weui-dialog__bd"></div>
                <div class="weui-dialog__ft">
                    <a href="javascript:;" class="weui-dialog__btn weui-dialog__btn_primary">知道了</a>
                </div>
            </div>
        </div>
        <!--END dialog2-->
    </div>
</div>


<div class="page">
    <div class="weui-navbar">
        <div id="register" class="weui-navbar__item weui-bar__item_on">
            注册
        </div>
        <div id="login" class="weui-navbar__item">
            登入
        </div>
    </div>
    <div class="page__bd">

        <form action="../../index.php?c=user&a=register" method="post">
            <div class="weui-cell">
                <div class="weui-cell__hd"><label class="weui-label"><span style="color:red">*</span> </label>
                </div>
                <div class="weui-cell__bd">
                    <input class="weui-input" type="text" placeholder=""/>
                </div>
            </div>
            <div class="weui-cell weui-cell_vcode">
                <div class="weui-cell__hd">
                    <label class="weui-label"><span style="color:red">*</span> 手机号 </label>
                </div>
                <div class="weui-cell__bd">
                    <input class="weui-input code" name="phone_number" id="mobile" type="number"
                           placeholder="请输入手机号"/>
                </div>
                <div class="weui-cell__ft">
                    <button class="weui-vcode-btn obtain generate_code" type="button" value=" 获取验证码"></button>
                </div>
            </div>
            <div class="weui-cell weui-cell_select weui-cell_select-after">
                <div class="weui-cell__hd">
                    <label for="" class="weui-label"> <span style="color:red">*</span> 性别</label>
                </div>
                <div class="weui-cell__bd">
                    <select class="weui-select" id="sex" name="sex">
                        <option value="1" selected="selected">男</option>
                        <option value="2">女</option>

                    </select>
                </div>
            </div>

            <div class="weui-cell">
                <div class="weui-cell__hd"><label class="weui-label"><span style="color:red">*</span> 密码 </label>
                </div>
                <div class="weui-cell__bd">
                    <input class="weui-input" name="password" type="password" id="password"
                           placeholder="请输入您的密码"/>
                </div>
            </div>
            <div class="weui-cell">
                <div class="weui-cell__hd"><label class="weui-label"><span style="color:red">*</span> 确认密码 </label>
                </div>
                <div class="weui-cell__bd">
                    <input class="weui-input" name="repassword" id="repassword" type="password"
                           placeholder="请输入您的确认密码"/>
                </div>
            </div>

            <div class="weui-btn-area">
                <input id="register_button" class="weui-btn weui-btn_primary" value="确定">
            </div>
        </form>
    </div>
</div>


<div class="page__bd2">

    <form action="../../index.php?c=user&a=register" method="post">
        <div class="weui-cell">
            <div class="weui-cell__hd"><label class="weui-label"><span style="color:red">*</span> </label>
            </div>
            <div class="weui-cell__bd">
                <input class="weui-input" type="text" placeholder=""/>
            </div>

        </div>

        <div class="weui-cell weui-cell_vcode">
            <div class="weui-cell__hd">
                <label class="weui-label"><span style="color:red">*</span> 手机号 </label>
            </div>
            <div class="weui-cell__bd">
                <input class="weui-input code" name="phone_number" id="mobile2" type="number"
                       placeholder="请输入手机号"/>
            </div>
            <div class="weui-cell__ft">
                <button class="weui-vcode-btn obtain generate_code" type="button"></button>
            </div>
        </div>


        <div class="weui-cell">
            <div class="weui-cell__hd"><label class="weui-label"><span style="color:red">*</span> 密码 </label>
            </div>
            <div class="weui-cell__bd">
                <input class="weui-input" name="password" type="password" id="password2"
                       placeholder="请输入您的密码"/>
            </div>
        </div>

        <div class="weui-btn-area">
            <input id="login_button" class="weui-btn weui-btn_primary" value="确定">
        </div>
    </form>
</div>


<script src="../../public/js/zepto.min.js"></script>
<script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript">
    $(function () {
        $('.page__bd2').hide();
        $('.weui-navbar__item').on('click', function () {
            $(this).addClass('weui-bar__item_on').siblings('.weui-bar__item_on').removeClass('weui-bar__item_on');

        });
        $('#register').on('click', function () {
            $('.page__bd').show();
            $('.page__bd2').hide();
        });
        $('#login').on('click', function () {

            $('.page__bd').hide();
            $('.page__bd2').show();
        });
    });
</script>

<script type="text/javascript">
    $(function () {
        $('#register_button').on('click', function () {
            if ($("#mobile").val() == "" || isNaN($("#mobile").val()) || $("#mobile").val().length != 11) {
                dialog(data = '请填写正确手机号');
                return false;
            }
            if ($("#password").val() != $("#repassword").val()) {
                dialog(data = '确认密码与原密码不一致');
                return false;
            }
            $.post({
                type: "post",
                url: "../../index.php?c=user&a=register",
                data: {
                    phone_number: $("#mobile").val(), sex: $("#sex").val(),
                    password: $("#password").val(), repassword: $("#repassword").val()
                },
                dataType: "text",
                async: false,
                success: function (data) {
                    //console.log(data);
                    if (data != 1) {
                        dialog(data)
                    } else {
                        window.location.href = './success.php';
                    }
                },
            });
            });


            $('#login_button').on('click', function () {
                if ($("#mobile2").val() == "" || isNaN($("#mobile2").val()) || $("#mobile2").val().length != 11) {
                    dialog(data = '请填写正确手机号');
                    return false;
                }

                $.post({
                    type: "post",
                    url: "../../index.php?c=user&a=login",
                    data: {
                        phone_number: $("#mobile2").val(), password: $("#password2").val()
                    },
                    dataType: "text",
                    async: false,
                    success: function (data) {
                        //console.log(data);
                        if (data != 1) {
                            dialog(data)
                        } else {
                            window.location.href = './index.php';
                        }
                    },
                });


        });
        function dialog(data='') {
            var $iosDialog1 = $('#iosDialog1');
            $('.weui-dialog__bd').html(data);
            var $mask = $('#mask');
            $('#dialogs').on('click', '.weui-dialog__btn', function () {
                $(this).parents('.js_dialog').fadeOut(200);
                $mask.fadeOut(200);
            });
            $mask.fadeIn(200);
            $iosDialog1.fadeIn(200);
        }
    });
</script>

<script type="text/javascript">
    $(function () {
        $(".generate_code").click(function () {

            var disabled = $(".generate_code").attr("disabled");
            if (disabled) {
                return false;
            }
            if ($("#mobile").val() == "" || isNaN($("#mobile").val()) || $("#mobile").val().length != 11) {
                alert("请填写正确的手机号！");
                return false;
            }
            $.post({
                type: "post",
                url: "../../index.php?c=sms&a=send",
                data: {mobile: $("#mobile").val()},
                dataType: "text",
                async: false,
                success: function (data) {
                    settime();
                    //console.log(data);
                },
                error: function (err) {

                    //console.log(err);
                }
            });
        });
        var countdown = 60;
        var _generate_code = $(".generate_code");
        _generate_code.text('获取验证码');

        function settime() {
            if (countdown == 0) {
                _generate_code.attr("disabled", false);
                _generate_code.text("获取验证码");

                countdown = 60;
                return false;
            } else {
                $(".generate_code").attr("disabled", true);
                _generate_code.text("重新发送(" + countdown + ")");
                countdown--;
            }
            setTimeout(function () {
                settime();
            }, 1000);
        }
    })

</script>


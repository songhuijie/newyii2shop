<div class="login w990 bc mt10">
    <div class="login_hd">
        <h2>用户登录</h2>
        <b></b>
    </div>
    <div class="login_bd">
        <div class="login_form fl">
           <?php
           $from=\yii\widgets\ActiveForm::begin( ['fieldConfig'=>[
               'options'=>['tag'=>'li'],
               'errorOptions'=>['tag'=>'div','style'=>'color:red;padding-left:100px'],
           ]]);
           echo '<ul>';
           echo $from->field($model,'username')->textInput(['class'=>'txt']);
           echo $from->field($model,'email')->textInput(['class'=>'txt']);
           echo '<p style="padding-left: 100px">我们将发送信息到你的邮箱地址以便验证</p>';
           echo '<li>
                        <label for="">&nbsp;</label>
                        <input type="submit" value="" class="login_btn">
                    </li>';
           echo '</ul>';
           \yii\widgets\ActiveForm::end();
           ?>
            <!--<form action="" method="post">
                <ul>
                    <li>
                        <label for="">用户名：</label>
                        <input type="text" class="txt" name="username" />
                    </li>
                    <li>
                        <label for="">密码：</label>
                        <input type="password" class="txt" name="password" />
                        <a href="">忘记密码?</a>
                    </li>
                    <li class="checkcode">
                        <label for="">验证码：</label>
                        <input type="text"  name="checkcode" />
                        <img src="images/checkcode1.jpg" alt="" />
                        <span>看不清？<a href="">换一张</a></span>
                    </li>
                    <li>
                        <label for="">&nbsp;</label>
                        <input type="checkbox" class="chb"  /> 保存登录信息
                    </li>
                    <li>
                        <label for="">&nbsp;</label>
                        <input type="submit" value="" class="login_btn" />
                    </li>
                </ul>
            </form>-->

            <div class="coagent mt15">
                <dl>
                    <dt>使用合作网站登录商城：</dt>
                    <dd class="qq"><a href=""><span></span>QQ</a></dd>
                    <dd class="weibo"><a href=""><span></span>新浪微博</a></dd>
                    <dd class="yi"><a href=""><span></span>网易</a></dd>
                    <dd class="renren"><a href=""><span></span>人人</a></dd>
                    <dd class="qihu"><a href=""><span></span>奇虎360</a></dd>
                    <dd class=""><a href=""><span></span>百度</a></dd>
                    <dd class="douban"><a href=""><span></span>豆瓣</a></dd>
                </dl>
            </div>
        </div>

        <div class="guide fl">
            <h3>还不是商城用户</h3>
            <p>现在免费注册成为商城用户，便能立刻享受便宜又放心的购物乐趣，心动不如行动，赶紧加入吧!</p>
            <?=\yii\helpers\Html::a('免费注册 >>',['member/regist'],['class'=>'reg_btn'])?>
<!--            <a href="regist.html" class="reg_btn">免费注册 >></a>-->
        </div>

    </div>
</div>
<!-- 头部搜索 start -->
<div class="search fl">
    <div class="search_form" style="position: relative">
        <div class="form_left fl"></div>

        <?php $from=\yii\widgets\ActiveForm::begin([
                'id'=>'myForm', //设置form表单id
            'method'=>'get',
            'action'=>\yii\helpers\Url::to(['goods/list3']),
            ]);

        echo $from->field($search,'name')->textInput(['name'=>'key','class'=>'txt']);
        echo \yii\helpers\Html::submitInput('搜索',['class'=>'btn','style'=>'border-right:3px #CD0000 solid']);

        \yii\widgets\ActiveForm::end();
        ?>
        <!--<form action="\yii\helpers\Url::to(['goods/list3'])/" name="serarch" method="get" class="fl">
            <input type="text" class="txt" value="请输入商品关键字" /><input type="submit" class="btn" value="搜索" />
        </form>-->
        <div class="form_right fl" style="position: absolute;top:0px"></div>
    </div>

    <div style="clear:both;"></div>

    <div class="hot_search">
        <strong>热门搜索:</strong>
        <a href="">D-Link无线路由</a>
        <a href="">休闲男鞋</a>
        <a href="">TCL空调</a>
        <a href="">耐克篮球鞋</a>
    </div>
</div>
<!-- 头部搜索 end -->
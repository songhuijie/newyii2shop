<?php
use light\assets\LayerAsset;
LayerAsset::register($this);
?>
<!-- 头部 start -->
	<!-- 头部 end-->

	<div style="clear:both;"></div>

	<!-- 页面主体 start -->
	<div class="main w1210 bc mt10">
		<div class="crumb w1210">
			<h2><strong>我的XX </strong><span>> 我的订单</span></h2>
		</div>

		<!-- 左侧导航菜单 start -->
		<div class="menu fl">
			<h3>我的XX</h3>
			<div class="menu_wrap">
				<dl>
					<dt>订单中心 <b></b></dt>
					<dd><b>.</b><a href="">我的订单</a></dd>
					<dd><b>.</b><a href="">我的关注</a></dd>
					<dd><b>.</b><a href="">浏览历史</a></dd>
					<dd><b>.</b><a href="">我的团购</a></dd>
				</dl>

				<dl>
					<dt>账户中心 <b></b></dt>
					<dd class="cur"><b>.</b><a href="">账户信息</a></dd>
					<dd><b>.</b><a href="">账户余额</a></dd>
					<dd><b>.</b><a href="">消费记录</a></dd>
					<dd><b>.</b><a href="">我的积分</a></dd>
					<dd><b>.</b><a href="">收货地址</a></dd>
				</dl>

				<dl>
					<dt>订单中心 <b></b></dt>
					<dd><b>.</b><a href="">返修/退换货</a></dd>
					<dd><b>.</b><a href="">取消订单记录</a></dd>
					<dd><b>.</b><a href="">我的投诉</a></dd>
				</dl>
			</div>
		</div>
		<!-- 左侧导航菜单 end -->

		<!-- 右侧内容区域 start -->
		<div class="content fl ml10">
			<div class="address_hd">
				<h3>收货地址薄</h3>
                <?php foreach ($address as $d):?>
                    <dl>
                        <dt><?=$count++?>.  <?=$d->name?> <?=$d->province?> <?=$d->city?> <?=$d->area?> <?=$d->address?>  <?=$d->tel?>&emsp; <?=($d->status==1)?"<span style='color: red'>当前默认地址</span>":''?></dt>
                        <dd>

                            <?=\yii\helpers\Html::a('修改',['address/edit','id'=>$d->id])?>

                            <a href="javascript:void(0);" id="del" data_id="<?=$d->id?>">删除</a>
                            <?php if($d->status!=1) echo "<a href='javascript:void(0);' id='default' data_id='$d->id' data_member='$d->member_id'>设为默认地址</a>"?>
                        </dd>
                    </dl>
                <?php endforeach;?>
			</div>

			<div class="address_bd mt10">
				<h4>新增收货地址</h4>
                <?php
                $form=\yii\widgets\ActiveForm::begin([
                    'fieldConfig'=>[
                        'options'=>['tag'=>'li'],
                        'errorOptions'=>['tag'=>'div','style'=>'color:red;padding-left:80px'],
                    ]
                ]);
                echo '<ul>';
                if($model->id){
                    echo $form->field($model,'id')->hiddenInput();
                }
                echo $form->field($model,'member_id')->hiddenInput(['value'=>\Yii::$app->user->identity->id]);
                echo $form->field($model,'name')->textInput();
                echo '<li><label for="">所在地区：</label>';
                echo $form->field($model,'province',['template' => "{input}",'options'=>['tag'=>false]])->dropDownList(['prompt'=>'请选择'],['name'=>'province']);
                echo $form->field($model,'city',['template' => "{input}",'options'=>['tag'=>false]])->dropDownList(['prompt'=>'请选择'],['name'=>'city']);
                echo $form->field($model,'area',['template' => "{input}",'options'=>['tag'=>false]])->dropDownList(['prompt'=>'请选择'],['name'=>'area']);
                echo '</li>';
                /*echo "请选择地址"."<li>
    <select name='province'  required='required' id='province'>
        <option value=''>请选择省份</option>
    </select>
    <select name='city'  required='required' id='city'>
        <option value=''>请选择城市</option>
    </select>
    <select name='area'  required='required' id='area'>
        <option value=''>请选择区县</option>
    </select>
</li>";*/
                echo $form->field($model,'address')->textInput();
                echo $form->field($model,'tel')->textInput();
                echo '<label for="">&nbsp;</label>'.$form->field($model,'status')->checkbox()->label('默认地址');
				echo			'<li>';
                echo \yii\helpers\Html::buttonInput($sub,['class'=>'btn','id'=>'btninput']);
				echo			'</li>';
                echo '</ul>';
                \yii\widgets\ActiveForm::end();
                ?>

			</div>

		</div>
		<!-- 右侧内容区域 end -->
	</div>
	<!-- 页面主体 end-->

	<div style="clear:both;"></div>

	<!-- 底部导航 start -->
	<div class="bottomnav w1210 bc mt10">
		<div class="bnav1">
			<h3><b></b> <em>购物指南</em></h3>
			<ul>
				<li><a href="">购物流程</a></li>
				<li><a href="">会员介绍</a></li>
				<li><a href="">团购/机票/充值/点卡</a></li>
				<li><a href="">常见问题</a></li>
				<li><a href="">大家电</a></li>
				<li><a href="">联系客服</a></li>
			</ul>
		</div>

		<div class="bnav2">
			<h3><b></b> <em>配送方式</em></h3>
			<ul>
				<li><a href="">上门自提</a></li>
				<li><a href="">快速运输</a></li>
				<li><a href="">特快专递（EMS）</a></li>
				<li><a href="">如何送礼</a></li>
				<li><a href="">海外购物</a></li>
			</ul>
		</div>


		<div class="bnav3">
			<h3><b></b> <em>支付方式</em></h3>
			<ul>
				<li><a href="">货到付款</a></li>
				<li><a href="">在线支付</a></li>
				<li><a href="">分期付款</a></li>
				<li><a href="">邮局汇款</a></li>
				<li><a href="">公司转账</a></li>
			</ul>
		</div>

		<div class="bnav4">
			<h3><b></b> <em>售后服务</em></h3>
			<ul>
				<li><a href="">退换货政策</a></li>
				<li><a href="">退换货流程</a></li>
				<li><a href="">价格保护</a></li>
				<li><a href="">退款说明</a></li>
				<li><a href="">返修/退换货</a></li>
				<li><a href="">退款申请</a></li>
			</ul>
		</div>

		<div class="bnav5">
			<h3><b></b> <em>特色服务</em></h3>
			<ul>
				<li><a href="">夺宝岛</a></li>
				<li><a href="">DIY装机</a></li>
				<li><a href="">延保服务</a></li>
				<li><a href="">家电下乡</a></li>
				<li><a href="">京东礼品卡</a></li>
				<li><a href="">能效补贴</a></li>
			</ul>
		</div>
	</div>
	<!-- 底部导航 end -->
<?php
/**
 * @var $this \yii\web\View
 * */

//ajax添加数据 修改数据
$js2=<<<JS
    $('.btn').on('click',function(){
        if(this.value=='添加'){
            $.ajax({
       url: 'addsave',
       type: 'post',
       data: $(this).closest('form').serialize(),
       success: function (data) {
          if(data.search){
              layer.msg('添加成功');
              location.reload();
          }
       }
  });
        }else{
            $.ajax({
       url: 'editsave',
       type: 'post',
       data: $(this).closest('form').serialize(),
       success: function (data) {
          if(data.search){
              layer.msg('修改成功');
              location.reload();
          }
       }
  });
        }
         
       
    })
JS;
$this->registerJs($js2);
//局部设置默认地址
$js3=<<<JS
$('dl').on('click','#default',function(){
     var id=$(this).attr('data_id');
     var member_id=$(this).attr('data_member');
           $.ajax({
       url: 'default',
       type: 'get',
       data: {'id':id,'member_id':member_id},
       success: function (data) {
          if(data.search){
              layer.msg(data.msg);
              location.reload();
          }
       }
  });
 })
JS;
$this->registerJs($js3);
//ajax 删除地址
$js4=<<<JS
 $('dl').on('click','#del',function(){
     var node=$(this).closest('dl');
     var id=$(this).attr('data_id');
     layer.confirm('确定要删除改地址 吗？',{icon:3, title:'提示'},function(){
           $.ajax({
       url: 'del',
       type: 'get',
       data: {'id':id},
       success: function (data) {
          if(data.search){
              layer.msg(data.msg);
              node.remove();
          }
       }
  });
       });
 })
JS;
$this->registerJs($js4);
//修改地址
$js5=<<<JS
 $('dl').on('click','#edit',function(){
     var node=$(this).closest('dl');
     var id=$(this).attr('data_id');
     
           $.ajax({
       url: 'edit',
       type: 'get',
       data: {'id':id},
       success: function (data) {
          if(data.search){
              layer.msg(data.msg);
              node.remove();
          }
       }
  });
 })
JS;
$this->registerJs($js5);
//使用address.js js文件 不用反复查数据库
$this->registerJsFile('@web/js/address.js');
$this->registerJs(new \yii\web\JsExpression(
        <<<JS
       
    $(address).each(function(){
        var options="<option value="+this.name+">"+this.name+"</option>";
        $('#address-province').append(options);
    })
    $('#address-province').change(function(){
        $(address).each(function(){
            if(this.name==$('#address-province').val()){
                var options="<option value=''>=请选择省=</option>";
                $(this.city).each(function(){
                    options+="<option value="+this.name+">"+this.name+"</option>";
                })
                $('#address-city').html(options);
            }
        })
        $('#address-area').html("<option value=''>=请选择区=</option>");
      })
        
        $('#address-city').change(function(){
        $(address).each(function(){
            if(this.name==$('#address-province').val()){
                
                $(this.city).each(function(){
                   if(this.name==$('#address-city').val()){
                       var options="<option value=''>=请选择区=</option>";
                       $(this.area).each(function(i,v){
                       options+="<option value="+v+">"+v+"</option>";
                       })
                       $('#address-area').html(options);
                   }
                })
            }
        })
    })
JS

));

$js='';
if($model->province){
    $js .= '$("#address-province").val("'.$model->province.'");';
}
if($model->city){
    $js .= '$("#address-province").change();$("#address-city").val("'.$model->city.'");';
}
if($model->area){
    $js .= '$("#address-city").change();$("#address-area").val("'.$model->area.'");';
}
$this->registerJs($js);






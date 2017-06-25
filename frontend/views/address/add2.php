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
                        <dt><?=$count++?>.  <?=$d->name?>  <?=$d->address?>  <?=$d->tel?>&emsp; <?=($d->status==1)?"<span style='color: red'>当前默认地址</span>":''?></dt>
                        <dd>
                            <a href="javascript:void(0);" id="edit" data_id="<?=$d->id?>" >修改</a>
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
                echo $form->field($model,'member_id')->hiddenInput(['value'=>\Yii::$app->user->identity->id]);
                echo $form->field($model,'name')->textInput();
                /*echo '<li>';
                echo $form->field($model,'province',['options'=>['tag'=>null]])->dropDownList(['prompt'=>'请选择'],['name'=>'province']);
                echo $form->field($model,'city',['options'=>['tag'=>null]])->dropDownList(['prompt'=>'请选择'],['name'=>'city']);
                echo $form->field($model,'area',['options'=>['tag'=>null]])->dropDownList(['prompt'=>'请选择'],['name'=>'area']);
                echo '</li>';*/
                echo "请选择地址<li>
    <select name='province'  required='required'>
        <option value=''>请选择省份</option>
    </select>
    <select name='city'  required='required'>
        <option value=''>请选择城市</option>
    </select>
    <select name='area'  required='required'>
        <option value=''>请选择区县</option>
    </select>
</li>";
                echo $form->field($model,'address')->textInput();
                echo $form->field($model,'tel')->textInput();
                echo '<label for="">&nbsp;</label>'.$form->field($model,'status')->checkbox()->label('默认地址');
				echo			'<li>
								<label for="">&nbsp;</label>
								<input type="button" name="" class="btn" value="保存" />
							</li>';
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
$js=<<<JS
			//1.页面加载完毕，就展示出所有的省份列表
			$(function(){
				//使用ajax请求php获取省份信息
				var data = {pid:0};
				$.getJSON( 'locations',data,function(response){
					$(response).each(function(i,v){
						var html = '<option value="'+v.id+'">'+v.name+'</option>';
						$(html).appendTo('select[name=province]');
					});
				});
				
				
				//获取市
				//1.绑定事件：第一个select修改的时候
				//1.1节点select[name=province]
				//1.2事件名称onchange
				$('select[name=province]').on('change',function(){
					//2.发起请求
					var node_value = $(this).val();
					
					var data = {pid:node_value};
					//先清除无用的市级列表
					/**
					 * 清空的逻辑：
					 * 第一种：
					 * 先清空select中的所有节点
					 * 添加了一个请选择
					 * 然后遍历添加刚获取的
					 * select[name=cite] option:not(:first)
					 * 第二种：
					 * select的dom对象的length就是option的个数，可以进行赋值，就等同于删除后续的
					 */
					$('select[name=city]').get(0).length = 1;
					$('select[name=area]').get(0).length = 1;
					//如果选中的请选择，我们就不发ajax请求了
					if(node_value.length==0){
						return;
					}
					$.getJSON('locations',data,function(response){
						//3.将数据显示在第二个select
						$(response).each(function(i,v){
							var html = '<option value="'+v.id+'">'+v.name+'</option>';
							$(html).appendTo('select[name=city]');
						});
					});
				});
				
				$('select[name=city]').on('change',function(){
					//1.获取选择的市
					var node_value = $(this).val();
					//2.发送ajax请求
					var data = "pid="+node_value;
					//清除无用的区县,方法1
					$('select[name=area] option:not(:first)').remove();
					//方法2.$('select[name=area] option:gt(0)').remove();
					//方法3.$('select[name=area] option').remove();
					//方法4.$('select[name=area]').empty();
					//方法3/4.$('<option value="">请选择区县</option>').appendTo('select[name=area]');
					//如果选中的请选择，我们就不发ajax请求了
					if(node_value.length==0){
						return;
					}
					$.getJSON('locations',data,function(response){
						$(response).each(function(i,v){
							var html = '<option value="'+v.id+'">'+v.name+'</option>';
							$(html).appendTo('select[name=area]');
						});
					});
				})
				
				
				
			});
	
JS;
$this->registerJs($js);
//ajax添加数据
$js2=<<<JS
    $('.btn').on('click',function(){
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






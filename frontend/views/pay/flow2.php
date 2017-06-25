<div style="clear:both;"></div>

<!-- 页面头部 start -->
<div class="header w990 bc mt15">
    <div class="logo w990">
        <h2 class="fl"><a href="index.html"><img src="images/logo.png" alt="京西商城"></a></h2>
        <div class="flow fr flow2">
            <ul>
                <li>1.我的购物车</li>
                <li class="cur">2.填写核对订单信息</li>
                <li>3.成功提交订单</li>
            </ul>
        </div>
    </div>
</div>
<!-- 页面头部 end -->

<div style="clear:both;"></div>

<!-- 主体部分 start -->
<?php \yii\widgets\ActiveForm::begin(['action'=>['pay/success']]);?>
<div class="fillin w990 bc mt15">
    <div class="fillin_hd">
        <h2>填写并核对订单信息</h2>
    </div>

    <div class="fillin_bd">
        <!-- 收货人信息  start-->
        <div class="address">
            <h3>收货人信息</h3>
            <div class="address_info">
                <p>

                    <?php if($address1) echo "<input type='radio' checked value='$address1->id' name='address_id'/ >$address1->name $address1->tel  $address1->province  $address1->city $address1->area <?=$address1->address?>  </p>"?>
                    <?php if($address0) echo "<input type='radio'  value='$address0->id' name='address_id'/ >$address0->name $address0->tel  $address0->province  $address0->city $address0->area <?=$address0->address?>  </p>"?>
               <?php if($address0==null && $address1==null) echo \yii\helpers\Html::a('添加收货地址',['address/add'])?>
            </div>


        </div>
        <!-- 收货人信息  end-->

        <!-- 配送方式 start -->
        <div class="delivery">
            <h3>送货方式 </h3>


            <div class="delivery_select">
                <table>
                    <thead>
                    <tr>
                        <th class="col1">送货方式</th>
                        <th class="col2">运费</th>
                        <th class="col3">运费标准</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php

                        foreach(\frontend\models\Order::$delivery as $k=>$deli){
                            echo ($k==0)? '<tr class="cur">':'<tr>';
                            echo '<td>';
                            echo ($k==0)?"<input type='radio' name='delivery'  class='delivery1' value='{$deli['delivery_id']}' checked />{$deli['delivery_name']}":"<input type='radio' name='delivery' class='delivery1' value='{$deli['delivery_id']}'/>{$deli['delivery_name']}";
                            echo '</td>';
                            echo "<td>￥{$deli['delivery_price']}</td>";
                            echo "<td>{$deli['info']}</td>";
                            echo '</tr>';
                        }
                    ?>
                    <!--<tr class="cur">
                        <td>
                            <input type="radio" name="delivery" checked="checked" />普通快递送货上门

                        </td>
                        <td>￥10.00</td>
                        <td>每张订单不满499.00元,运费15.00元, 订单4...</td>
                    </tr>
                    <tr>

                        <td><input type="radio" name="delivery" />特快专递</td>
                        <td>￥40.00</td>
                        <td>每张订单不满499.00元,运费40.00元, 订单4...</td>
                    </tr>
                    <tr>

                        <td><input type="radio" name="delivery" />加急快递送货上门</td>
                        <td>￥40.00</td>
                        <td>每张订单不满499.00元,运费40.00元, 订单4...</td>
                    </tr>
                    <tr>

                        <td><input type="radio" name="delivery" />平邮</td>
                        <td>￥10.00</td>
                        <td>每张订单不满499.00元,运费15.00元, 订单4...</td>
                    </tr>-->
                    </tbody>
                </table>

            </div>
        </div>
        <!-- 配送方式 end -->

        <!-- 支付方式  start-->
        <div class="pay">
            <h3>支付方式 </h3>


            <div class="pay_select">
                <table>
                    <?php
                    foreach(\frontend\models\Order::$payment as $k=>$pay){
                        echo ($k==0)? '<tr class="cur">':'<tr>';
                        echo '<td>';
                        echo "<input type='radio' name='payment' value='{$pay['payment_id']}' />{$pay['payment_name']}";
                        echo "<td>{$pay['info']}</td>";
                        echo '</td>';
                        echo '</tr>';
                    }
                    ?>
                    <!--<tr class="cur">
                        <td class="col1"><input type="radio" name="pay" />货到付款</td>
                        <td class="col2">送货上门后再收款，支持现金、POS机刷卡、支票支付</td>
                    </tr>
                    <tr>
                        <td class="col1"><input type="radio" name="pay" />在线支付</td>
                        <td class="col2">即时到帐，支持绝大数银行借记卡及部分银行信用卡</td>
                    </tr>
                    <tr>
                        <td class="col1"><input type="radio" name="pay" />上门自提</td>
                        <td class="col2">自提时付款，支持现金、POS刷卡、支票支付</td>
                    </tr>
                    <tr>
                        <td class="col1"><input type="radio" name="pay" />邮局汇款</td>
                        <td class="col2">通过快钱平台收款 汇款后1-3个工作日到账</td>
                    </tr>-->
                </table>

            </div>
        </div>
        <!-- 支付方式  end-->

        <!-- 发票信息 start-->
        <div class="receipt none">
            <h3>发票信息 </h3>


            <div class="receipt_select ">
                <form action="">
                    <ul>
                        <li>
                            <label for="">发票抬头：</label>
<!--                            <input type="radio" name="type" checked="checked" class="personal" />个人-->
<!--                            <input type="radio" name="type" class="company"/>单位-->
<!--                            <input type="text" class="txt company_input" disabled="disabled" />-->
                        </li>
                        <li>
                            <!--<label for="">发票内容：</label>
                            <input type="radio" name="content" checked="checked" />明细
                            <input type="radio" name="content" />办公用品
                            <input type="radio" name="content" />体育休闲
                            <input type="radio" name="content" />耗材-->
                        </li>
                    </ul>
                </form>

            </div>
        </div>
        <!-- 发票信息 end-->

        <!-- 商品清单 start -->
        <div class="goods">
            <h3>商品清单</h3>
            <table>
                <thead>
                <tr>
                    <th class="col1">商品</th>
                    <th class="col3">价格</th>
                    <th class="col4">数量</th>
                    <th class="col5">小计</th>
                </tr>
                </thead>
                <tbody>
                <?php  foreach($goods as $good):?>
                    <tr>
                        <td class="col1"><?=\yii\helpers\Html::img('http://www.yii2shop.cc.cn/'.$good['logo'])?>  <strong><a href=""><?=$good['name']?></a></strong></td>
                        <td class="col3">￥<?=$good['shop_price']?></td>
                        <td class="col4"> <?=$good['amount']?></td>
                        <td class="col5"><span>￥<?=$good['shop_price']*$good['amount']?></span></td>
                    </tr>
                    <?php  endforeach;?>
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="6">购物金额总计： <strong><span id="total"></span></strong></td>
                </tr>
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="5">
                        <ul>
                            <li>
                                <span><?=$count?> 件商品，总商品金额：</span>
                                <em>￥<?php $zong=0;foreach ($goods as $good){  $zong+=$good['shop_price']*$good['amount'];
                                    } echo $zong.'元';?></em>
                            </li>
                            <li>
                                <span>运费：</span>
                                <em class="yunfei"></em>
                            </li>
                            <li>
                                <input type="hidden" name="total" id="zongjii" value=""/>
                                <span>应付总额：</span>
                                <em class="zongji"></em>
                            </li>
                        </ul>
                    </td>
                </tr>
                </tfoot>
            </table>
        </div>
        <!-- 商品清单 end -->

    </div>

    <div class="fillin_ft">

        <p>应付总额：<strong><span id="yinfu"></span></strong><input type="submit"  value=""  style="width:130px; height:38px; background-image:url(<?=\Yii::getAlias('@web/images/btn.png')?>); margin: 8px;"/></p>


    </div>
    <?php \yii\widgets\ActiveForm::end()?>
</div>
<?php
/**
 * @var $this \yii\web\View
 * */

$this->registerJs(new \yii\web\JsExpression(
        <<<JS
          $('.delivery1').click(function(){
    var price=$(this).closest('tr').find('td:eq(1)').html();
    $('.yunfei').html(price)
    var yun=$("input[name='delivery']:checked").closest('tr').find('td:eq(1)').html();
    var yun=parseInt(yun.substring(1,yun.length));
    var zong=yun+{$zong};
     $('.zongji').html('￥'+zong+'元');
     $('#total').html('￥'+zong+'元');
     $('#yinfu').html('￥'+zong+'元');
     $('#zongjii').val(zong);
})
//加载页面自动加载一次
$(function() {
    $('.yunfei').html($("input[name='delivery']:checked").closest('tr').find('td:eq(1)').html()+'元')
    var yun=$("input[name='delivery']:checked").closest('tr').find('td:eq(1)').html();
    var yun=parseInt(yun.substring(1,yun.length));
    var zong=yun+{$zong};
     $('.zongji').html('￥'+zong+'元');
     $('#total').html('￥'+zong+'元');
     $('#yinfu').html('￥'+zong+'元');
     $('#zongjii').val(zong);
    console.log(zong)
        })

JS

));
?>
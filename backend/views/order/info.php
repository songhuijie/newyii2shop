<table class="table table-bordered table-responsive">
    <tr>
        <td>名称</td>
        <td>图片</td>
        <td>价格</td>
        <td>数量</td>
        <td>小计</td>
    </tr>
    <?php foreach($arr as $a):?>
        <tr>
            <td><?=$a->goods_name?></td>
            <td><?=\yii\helpers\Html::img('http://www.yii2shop.cc.cn/'.$a->logo,['width'=>40])?></td>
            <td><?=$a->price?></td>
            <td><?=$a->amount?></td>
            <td><?=$a->total?></td>
        </tr>
    <?php endforeach;?>
</table>

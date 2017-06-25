
<?php
use light\assets\LayerAsset;
LayerAsset::register($this);
use kartik\dialog\DialogAsset;
DialogAsset::register($this);

use kartik\dialog\Dialog;
echo Dialog::widget([
    'libName' => 'krajeeDialog',
    'options' => [], // default options
]);

// Example 2
//echo Dialog::widget([
//    'libName' => 'krajeeDialogCust',
//    'options' => ['draggable' => true, 'closable' => true], // custom options
//]);
?>
<input type="button" id="box" value="弹窗"/>
<input type="button" id="your-btn-id" value="弹窗2"/>

<script type="text/javascript">
$('#box').click(function(){
    layer.confirm('1');
});
$('#your-btn-id').on('click', function(){
    BootstrapDialog.confirm('腻害了')
})
</script>
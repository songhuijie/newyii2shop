<?php
use light\assets\LayerAsset;
LayerAsset::register($this);

$form=\yii\bootstrap\ActiveForm::begin(['layout' => 'horizontal']);
echo $form->field($model,'name');
//echo $form->field($model,'sn');
echo '<div style="margin-left: 230px">';
echo '<strong>请选择logo</strong>'.\yii\bootstrap\Html::fileInput('test', NULL, ['id' => 'test']);
echo $form->field($model,'logo')->hiddenInput(['id'=>'filename'])->label('');
echo $form->field($model,'qnurl')->hiddenInput(['id'=>'qnurl'])->label('');

echo \xj\uploadify\Uploadify::widget([
    'url' => yii\helpers\Url::to(['s-upload']),
    'id' => 'test',
    'csrf' => true,
    'renderTag' => false,
    'jsOptions' => [
        'width' => 120,
        'height' => 40,
        'onUploadError' => new \yii\web\JsExpression(<<<EOF
function(file, errorCode, errorMsg, errorString) {
    console.log('The file ' + file.name + ' could not be uploaded: ' + errorString + errorCode + errorMsg);
}

EOF
        ),
        'onUploadSuccess' => new \yii\web\JsExpression(<<<EOF
function(file, data, response) {
    data = JSON.parse(data);
    if (data.error) {
        console.log(data.msg);
    } else {
        
        console.log(data.fileUrl);
        $('#logo').attr('src',data.fileUrl[0]).show();
        $('#filename').val(data.fileUrl[1]);
        $('#qnurl').val(data.fileUrl[0]);
        layer.msg('成功');
        
    }
}
EOF
        ),
    ]
]);



if($model->logo){
    echo \yii\bootstrap\Html::img($model->logo,['id'=>'logo','height'=>50,'margin'=>'10px']);
}else{
    echo \yii\bootstrap\Html::img('',['id'=>'logo','style'=>'display:none','height'=>50,'margin'=>'10px']);
}
echo '</div>';
echo $form->field($model,'goods_category_id')->hiddenInput(['id'=>'goods_category_id']);
echo '<ul id="treeDemo" class="ztree" style="padding-left: 23%"></ul>';
echo $form->field($model,'brand_id')->dropDownList($brands);
echo $form->field($model,'market_price');
echo $form->field($model,'shop_price');
echo $form->field($model,'stock');
echo $form->field($model,'is_on_sale',['inline'=>true])->radioList(\backend\models\Goods::$saleoptios);
echo $form->field($model,'status',['inline'=>true])->radioList(\backend\models\Goods::$statusoptios);
echo $form->field($model,'sort');
//echo $form->field($info,'content');
echo $form->field($info,'content')->widget('kucha\ueditor\UEditor',[]);
echo \yii\bootstrap\Html::submitButton('添加',['class'=>'btn btn-info col-lg-offset-8']);
\yii\bootstrap\ActiveForm::end();


$this->registerCssFile('@web/ztree/css/zTreeStyle/zTreeStyle.css');
$this->registerJsFile('@web/ztree/js/jquery.ztree.core.js',['depends'=>\yii\web\JqueryAsset::className()]);
$categories=\yii\helpers\Json::encode($categories);
$js=new \yii\web\JsExpression(
    <<<JS
   var zTreeObj;

        // zTree 的参数配置，深入使用请参考 API 文档（setting 配置详解）
        var setting = {
            data: {
                simpleData: {
                    enable: true,
                    idKey: "id",
                    pIdKey: "parent_id",
                    rootPId: 0
                 }
	    },
            callback: {
		onClick: function(event, treeId, zNodes) {
		    // console.debug(zNodes.id)
    $('#goods_category_id').val(zNodes.id);
                }
	}
        };
        // zTree 的数据属性，深入使用请参考 API 文档（zTreeNode 节点数据详解）
        var zNodes = {$categories};
        
            zTreeObj = $.fn.zTree.init($("#treeDemo"), setting, zNodes);
            zTreeObj.expandAll(true);
            
            var node = zTreeObj.getNodeByParam("id", $("#goodscategory-parent_id").val(), null);
            zTreeObj.selectNode(node); 
            
       
JS
);
$this->registerJs($js);
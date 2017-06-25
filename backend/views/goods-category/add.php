<?php
/**
 * @var $this \yii\web\View
 */
$form=\yii\bootstrap\ActiveForm::begin(['layout' => 'horizontal']);
echo $form->field($model,'name');
echo $form->field($model,'parent_id')->hiddenInput();
echo '<ul id="treeDemo" class="ztree" style="padding-left: 23%"></ul>';
echo $form->field($model,'intro')->textarea();
echo \yii\bootstrap\Html::submitButton($sub,['class'=>'btn btn-info col-lg-offset-8']);
\yii\bootstrap\ActiveForm::end();

$this->registerCssFile('@web/ztree/css/zTreeStyle/zTreeStyle.css');
$this->registerJsFile('@web/ztree/js/jquery.ztree.core.js',['depends'=>\yii\web\JqueryAsset::className()]);
$options=\yii\helpers\Json::encode($options);
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
    $('#goodscategory-parent_id').val(zNodes.id);
                }
	}
        };
        // zTree 的数据属性，深入使用请参考 API 文档（zTreeNode 节点数据详解）
        var zNodes = {$options};
        
            zTreeObj = $.fn.zTree.init($("#treeDemo"), setting, zNodes);
            zTreeObj.expandAll(true);
            
            var node = zTreeObj.getNodeByParam("id", $("#goodscategory-parent_id").val(), null);
            zTreeObj.selectNode(node);   
       
JS
);
$this->registerJs($js);
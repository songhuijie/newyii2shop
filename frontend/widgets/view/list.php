<?php
use \yii\helpers\Html;

$model=\backend\models\GoodsCategory::find()->where(['parent_id'=>0])->all();

                foreach ($model as $k=>$m){
                    echo ($k==0)?'<div class="cat item1">':'<div class="cat">';
                    echo "<h3>".Html::a($m->name,['goods/list','id'=>$m->id])."<b></b></h3>";

                    echo "<div class='cat_detail'>";
//        var_dump($m->category->name);exit;
                    foreach ($m->chlidren as $k2=>$chlid){

                        echo ($k2==0)?"<dl class='dl_1st'>":"<dl>";
                        echo "<dt>".Html::a($chlid->name,['goods/list','id'=>$chlid->id])."</dt>";
                        foreach($chlid->chlidren as $c){
                            echo "<dd>".Html::a($c->name,['goods/list','id'=>$c->id])."</dd>";
                        }
                        echo "</dl>";
                    }
                    echo "</div>";
                    echo '</div>';
                }
                ;?>
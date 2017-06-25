<?php
namespace frontend\components;
use yii\base\Component;
use Flc\Alidayu\Client;
use Flc\Alidayu\App;
use Flc\Alidayu\Requests\AlibabaAliqinFcSmsNumSend;
use Flc\Alidayu\Requests\IRequest;

class Sms extends Component{
    public $app_key;
    public $app_secret;
    private $_num;
    private $_param=[];
    public $sign_name;
    public $template_code;
    public function setNum($num){
        $this->_num=$num;
        return $this;
    }
    public function setSmsParam(array $param){
        $this->_param=$param;
        return $this;
    }
    public function setSignName($sign){
        $this->sign_name=$sign;
        return $this;
    }
    public function setTemplateCode($tmp){
        $this->template_code=$tmp;
        return $this;
    }
    public function setSend(){
        $client = new Client(new App(['app_key'=>$this->app_key,'app_secret'=>$this->app_secret]));
        $req    = new AlibabaAliqinFcSmsNumSend;
        $req->setRecNum($this->_num)
            ->setSmsParam($this->_param)
            ->setSmsFreeSignName($this->sign_name)
            ->setSmsTemplateCode($this->template_code);

        return $resp = $client->execute($req);
    }
}
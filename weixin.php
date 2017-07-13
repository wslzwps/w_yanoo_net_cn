<?php

class bbb {
const APPID="wxede4528b4b09a5e5";
const APPSECRET="4cb277879d6bbf588817ac408df48b92";

	private $appid;
	private $appsecret;
	public function __construct($rowweixin){
		$this->appid = isset($rowweixin['APPID'])?$rowweixin['APPID']:'';
		$this->appsecret = isset($rowweixin['APPSECRET'])?$rowweixin['APPSECRET']:'';
	}
	






	  function getSignPackage() {
		echo "fdssfdsfdsf\n";
            $jsapiTicket = $this->getJsApiTicket();
		echo "fdssfdsfdsf\n";
            $url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
            $timestamp = time();
            $nonceStr = $this->createNonceStr();
            // 这里参数的顺序要按照 key 值 ASCII 码升序排序
            $string = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";
            $signature = sha1($string);
            
            require_once ( 'Wechat.class.php' );
            $appid =  $this->appid;
            $appSecret =  $this->appsecret;
		print_r($appid);
		print_r($appSecret);
            
            $signPackage = array(
                "appid"     => $appid,
                "noncestr"  => $nonceStr,
                "timestamp" => $timestamp,
                "url"       => $url,
                "signature" => $signature,
                "rawString" => $string
            );
        
	            return $signPackage;
	}

	 function createNonceStr($length = 16) {
            $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
            $str = "";
            for ($i = 0; $i < $length; $i++) {
                $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
            }
            return $str;
	}

     	function getJsApiTicket() {
        // jsapi_ticket 应该全局存储与更新，以下代码以写入到文件中做示例
		echo "aaaaaaaaaaaaaaaaaaaaaaaaa1\n";
        $data = json_decode(file_get_contents("jsapi_ticket.json"));
        if ($data->expire_time < time()) {
		echo "aaaaaaaaaaaaaaaaaaaaaaaaa2\n";
            $accessToken = $this->getAccessToken();
            $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=$accessToken";
		echo "$url";
		echo "aaaaaaaaaaaaaaaaaaaaaaaaa2.1\n";
            $res = json_decode($this->httpGet($url));
		echo "aaaaaaaaaaaaaaaaaaaaaaaaa2.2\n";
            $ticket = $res->ticket;
            if ($ticket) {
                $data->expire_time = time() + 7000;
                $data->jsapi_ticket = $ticket;
                $fp = fopen("jsapi_ticket.json", "w");
                fwrite($fp, json_encode($data));
                fclose($fp);
            }
        } else {
            $ticket = $data->jsapi_ticket;
        }
		echo "aaaaaaaaaaaaaaaaaaaaaaaaa3\n";
        return $ticket;
    }

     function getAccessToken() {
        // access_token 应该全局存储与更新，以下代码以写入到文件中做示例
		echo "bbbbbbbbbbbbbbbbbbbbbbbbb1\n";
        $data = json_decode(file_get_contents("access_token.json"));
		echo "bbbbbbbbbbbbbbbbbbbbbbbbb2\n";
		
            require_once ( 'Wechat.class.php' );
            $appid =  $this->appid;
            $appSecret =  $this->appsecret;			
			        
		echo "bbbbbbbbbbbbbbbbbbbbbbbbb2.1\n";
        if ($data->expire_time < time()) {
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$appSecret; 
		echo $url;
            $res = json_decode($this->httpGet($url));
		echo "bbbbbbbbbbbbbbbbbbbbbbbbb2.2\n";
            $access_token = $res->access_token;
            if ($access_token) {
                $data->expire_time = time() - 7000;
                $data->access_token = $access_token;
                $authname = 'wechat_access_token'.$appid;
				//S($authname,$data->access_token,$data->expire_time);
                $fp = fopen("access_token.json", "w");
                fwrite($fp, json_encode($data));
                fclose($fp);
            }
        }else{
            $access_token = $data->access_token;
        }
		echo "bbbbbbbbbbbbbbbbbbbbbbbbb3\n";
        return $access_token;
    }

     function httpGet($url) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 500);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_URL, $url);
        $res = curl_exec($curl);
        curl_close($curl);
        return $res;
    }

}

?>

<?php
/**
 * 宝塔API接口示例Demo
 * 仅供参考，请根据实际项目需求开发，并做好安全处理
 * date 2018/12/12
 * author 阿良
 */

class bulkWebsiteBuild {

    private $serverip;
    private $user;
    private $password;
    private $apikey;
    private $bturl;

  	//如果希望多台面板，可以在实例化对象时，将面板地址与密钥传入
	public function __construct($serverip, $apikey, $user, $pass){
	    $this->serverip = $serverip;
	    $this->user = $user;
	    $this->apikey = $apikey;
	    $this->password = $pass;
	    $this->bturl = 'http://'.$serverip.':8888';
	}

	public function addWebsite($domain){
		$url = $this->bturl.'/site?action=AddSite';
		//准备POST数据
		$p_data = $this->GetKeyData();		//取签名
		
		$p_data['webname'] = '{"domain":"'.$domain.'","domainlist":[],"count":0}';
		//json_encode(array("domain" => "www.test.com", "domainlist" => array(), "count" => 0)); 
		$p_data['path'] = '/www/wwwroot/'.$domain;
		$p_data['type_id'] = 0;
		$p_data['type'] = 'PHP';
		$p_data['version'] = '55';
		$p_data['port'] = 80;
		$p_data['ps'] = '创建了网站'.$domain;
		$p_data['ftp'] = "true";
		$p_data['ftp_username'] = $this->strReplaceDot($domain);
		$p_data['ftp_password'] = $this->generatePassword();
		$p_data['sql'] = 'true';
		$p_data['codeing'] = 'utf8mb4';
		$p_data['datauser'] = $this->strReplaceDot($domain);
		$p_data['datapassword'] = $this->generatePassword();
		
		//请求面板接口
		$result = $this->HttpPostCookie($url,$p_data);
		//解析JSON数据
		$data = json_decode($result,true);
      	return $data;
	}

	private function generatePassword($length = 16){
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
           $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
	}

    public function sshExecCmd($cmd){
        $connection = ssh2_connect($this->serverip, 22);
        ssh2_auth_password($connection, $this->user, $this->password);
        $stream = ssh2_exec($connection, $cmd);
        stream_set_blocking($stream, true);
        $stream_out = ssh2_fetch_stream($stream, SSH2_STREAM_STDIO);
        return stream_get_contents($stream_out);
    }

    private function strReplaceDot($domain){
		$replaced = str_replace('.','_',$domain);
		return $replaced;
	}
	
	
  	/**
     * 构造带有签名的关联数组
     */
  	private function GetKeyData(){
  		$now_time = time();
    	$p_data = array(
			'request_token'	=>	md5($now_time.''.md5($this->apikey)),
			'request_time'	=>	$now_time
		);
    	return $p_data;    
    }


    public function changeConfigure($filePath, $search, $replace){
        $file_contents = file_get_contents($filePath);
        $file_contents = str_replace($search,$replace,$file_contents);
        file_put_contents($filePath,$file_contents);
    }


    public function copyToDomainDir($originalfiles, $newlocation){

        shell_exec("cp -r $originalfiles $newlocation");

    }

    public function importSqlToDatabase($dbuser, $dbpass, $dbname, $sqlfile){

        $command = "mysql --user=$dbuser --password=$dbpass "
            . "-h localhost -D $dbname < $sqlfile";

        shell_exec($command);

        return "imported";
    }
  
  	/**
     * 发起POST请求
     * @param String $url 目标网填，带http://
     * @param Array|String $data 欲提交的数据
     * @return string
     */
    private function HttpPostCookie($url, $data,$timeout = 60)
    {
    	//定义cookie保存位置
        $cookie_file='./'.md5($this->bturl).'.cookie';
        if(!file_exists($cookie_file)){
            $fp = fopen($cookie_file,'w+');
            fclose($fp);
        }
		
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }
}
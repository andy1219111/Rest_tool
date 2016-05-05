<?php

class Rest{		
	/*
	 * curl get请求方式
	 * 
	 * @param string url 调用API的请求地址
	 * @return array
	 */
	public function curlGet($url,$header=array(),$userpwd = '',$proxy = null)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		if(!empty($proxy))
		{
			curl_setopt($ch, CURLOPT_PROXY, $proxy);
		}
		if(!empty($header)) {
			curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		}
		if(!empty($userpwd)) {
			curl_setopt($ch, CURLOPT_USERPWD, $userpwd);
		}
		//curl_setopt($ch, CURLOPT_TIMEOUT, 15);//设置curl允许执行的最长秒数
		$response = curl_exec($ch);	
		$result = curl_errno($ch);
		$status = curl_getinfo($ch, CURLINFO_HTTP_CODE); 
		$contentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
		curl_close($ch);
		return array($result,$response,$status,$contentType);
	}
	
	/*
	 * curl post请求方式
	 * 
	 * @param string url 调用API的请求地址
	 * @param string data 发送内容
	 * @param array header 发送内容类型
	 * @return array
	 */
	public function curlPost($url,$data,$header = array(),$proxy = null)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		if(!empty($proxy))
		{
			curl_setopt($ch, CURLOPT_PROXY, $proxy);
		}
		//如果存在请求header
		if(!empty($header))
		{
			curl_setopt($ch, CURLOPT_HEADER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		}
		else
		{
			curl_setopt($ch, CURLOPT_HEADER, false);
		}

		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_TIMEOUT, 3);//设置curl允许执行的最长秒数
		$response = curl_exec($ch);
		$result = curl_errno($ch);
		$status = curl_getinfo($ch,CURLINFO_HTTP_CODE ); 
		$contentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
		curl_close($ch);
		return array($result,$response,$status,$contentType);
	}
	
	/*
	 * curl delete请求方式
	 *
	 * @param string url 调用API的请求地址
	 * @return array
	 */
	public function curlDelete($url)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
		//curl_setopt($ch, CURLOPT_TIMEOUT, 15);//设置curl允许执行的最长秒数
		$response = curl_exec($ch);
		$result = curl_errno($ch);
		$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		$contentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
		curl_close($ch);
		return array($result,$response,$status,$contentType);
	}
	
	/*
	 * curlInit 
	 * 
	 * @param string url 连接地址
	 * @param string query_array 要生成查询字符串的数据 为键值对数组
	 * @param string method 请求的方法
	 * @param array post_data post的数据，键值对数组，当$method为post时有效
	 * @param array format 发送内容类型
	 * @return array
	 */
	function curlInit( $url = '', $query_array = array(), $method = "GET", $post_data = array(), $format = '',$userpwd = '',$proxy = null){
        $header = array();
		if(!empty($format))
		{
			$header[] = "Content-type: $format";
		}
		
		if(!empty($query_array)){
			$query = http_build_query($query_array);		// Build array to url query
			$url = $url.'?'.$query;
		}
		log_message('INFO',"accessUrl:$url");
		$method = strtolower($method);
        if($method == 'post' && !empty($query_array))
        {
            $post_data = array_merge($query_array,$post_data);
        }
		switch ($method){
			case 'post':
				$res = $this->curlPost($url,$post_data,$header,$proxy);
				break;
			case 'get':
				$res = $this->curlGet($url,$header,$userpwd,$proxy);
				break;
			case 'delete':
				$res = $this->curlDelete($url);
				break;
			default:
				break;
		}
		return $res;
	}
}
?>

<?php
/*
 * REST请求工具类 使用curl发起对服务器的请求
 * 
 * @author aaron<andy1219111@163.com>
 * @version 2014-10-10
 * @description rest请求工具类
 */
class Rest{		
	/*
	 * curl get请求方式
	 * 
	 * @param string url 调用API的请求地址
	 * @return array
	 */
	public function curlGet($url,$header=array(),$proxy = null)
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
	public function curlPost($url,$data,$header,$proxy = null)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		if(!empty($proxy))
		{
			curl_setopt($ch, CURLOPT_PROXY, $proxy);
		}
		curl_setopt($ch, CURLOPT_HEADER, false);
		// curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		//curl_setopt($ch, CURLOPT_TIMEOUT, 15);//设置curl允许执行的最长秒数
		$response = curl_exec($ch);
		$result = curl_errno($ch);
		$status = curl_getinfo($ch); 
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
	 * @param string query_array 发送内容
	 * @param string method 请求的方法
	 * @param array format 发送内容类型
	 * @return array
	 */
	function curlInit( $url = '', $query_array = array(), $method = "GET", $post_data = "", $format = '',$proxy = null){
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
		switch ($method){
			case 'post':
				$res = $this->curlPost($url,$post_data,$header,$proxy);
				break;
			case 'get':
				$res = $this->curlGet($url,$header,$proxy);
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
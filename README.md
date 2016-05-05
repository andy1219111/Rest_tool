Rest_tool
=========

该类库使用curl工具包，实现了REST请求控制，可以非常方便的使用该类发起REST请求

## 发起get请求

```
$rest = new Rest();
$response = $rpc_client->curlInit($sever_url,$query_array,'GET');
//请求成功
if($response[0] == 0 && $response[2] == 200)
{
  //$response[1]为服务器返回的内容
  $result = json_decode($response[1],true);
	//响应成功
}
else
{
  //请求失败
}
```

## 发起post请求
```
$rest = new Rest();
$response = $rpc_client->curlInit($sever_url,arrayu(),'POST',$post_data);
//请求成功
if($response[0] == 0 && $response[2] == 200)
{
  //$response[1]为服务器返回的内容
  $result = json_decode($response[1],true);
	//响应成功
}
else
{
  //请求失败
}
```

<?php
//Still a work in progress
//Will be adding more comments and fixing up the code a bit.
class cloudatcost
{
	private $api_key;
	private $api_login;
	private $url_listservers= 'https://panel.cloudatcost.com/api/v1/listservers.php';
	private $url_listtemplates= 'https://panel.cloudatcost.com/api/v1/listtemplates.php';
	private $url_listtasks= 'https://panel.cloudatcost.com/api/v1/listtasks.php';
	private $url_powerop= 'https://panel.cloudatcost.com/api/v1/powerop.php';
	private $url_rename= 'https://panel.cloudatcost.com/api/v1/renameserver.php';
	private $url_rdns= 'https://panel.cloudatcost.com/api/v1/rdns.php';
	private $url_console= 'https://panel.cloudatcost.com/api/v1/console.php';
	private $url_runmode= 'https://panel.cloudatcost.com/api/v1/runmode.php';
	private $url_build= 'https://panel.cloudatcost.com/api/v1/cloudpro/build.php';
	private $url_delete= 'https://panel.cloudatcost.com/api/v1/cloudpro/delete.php';
	private $url_resources= 'https://panel.cloudatcost.com/api/v1/cloudpro/resources.php';
	
	public function __construct($key, $login)
	{
		$this->api_key= $key;
		$this->api_login= $login;
	}
	

	public function listServers()
	{
		$rdata= $this->sendUrlReq($this->url_listservers);
		if($rdata['status'] == 'error'){
			return $rdata;
		}else{
			return $rdata['data'];
		}
	}
	
	
	public function getServer($server_id)
	{
		$rdata= $this->sendUrlReq();
		if($rdata['status'] == 'error'){
			return $rdata;
		}else{
			foreach($rdata as $sdata)
			{
				if(strval($sdata['serverid']) == strval($server_id))
				{
					return $sdata;
				}
			}
			return ['status' => 'error', 'error_description' => 'could not find server.'];
		}
	}
	
	
	public function listTemplates()
	{
		$rdata= $this->sendUrlReq($this->url_listtemplates);
		if($rdata['status'] == 'error'){
			return $rdata;
		}else{
			return $rdata['data'];
		}	
	}
	
	
	public function getTemplate($template_id)
	{
		$rdata= $this->listtemplates();
		if($rdata['status'] == 'error'){
			return $rdata;
		}else{
			foreach($rdata as $tdata)
			{
				if(strval($tdata['id']) == strval($template_id))
				{
					return $tdata['detail'];
				}
			}
			return 'error';
		}		
	}
		
		
	public function listTasks()
	{
		$rdata= $this->sendUrlReq($this->url_listtasks);
		if($rdata['status'] == 'error'){
			return $rdata;
		}else{
			return $rdata['data'];
		}
		
	}
	
	
	
	public function listFilteredTasks($tasks_property_1, $tasks_value_1, $tasks_property_2 = null, $tasks_value_2 = null,$tasks_property_3 = null, $tasks_value_3 = null)
	{
		$rdata= $this->listTasks();
		$returndata= array();
		if(isset($rdata['status']) && $rdata['status'] == 'error'){
			return $rdata;
		}else{
			if(count($rdata) == 0){
				return ['status' => 'error', 'error_description' => 'no tasks to list'];
			}
			foreach ($rdata as $tdata){
				if(isset($tdata[$tasks_property_1]) && $tdata[$tasks_property_1] == $tasks_value_1 && !isset($tasks_property_2) && !isset($tasks_value_2)){
					array_push($returndata, $tdata);
				}elseif(isset($tdata[$tasks_property_1]) && isset($tdata[$tasks_property_2]) && $tdata[$tasks_property_1] == $tasks_value_1 && $tdata[$tasks_property_2] == $tasks_value_2 && !isset($tasks_property_3) && !isset($tasks_value_3)){
					array_push($returndata, $tdata);
				}elseif(isset($tdata[$tasks_property_1]) && isset($tdata[$tasks_property_2]) && isset($tdata[$tasks_property_3]) && $tdata[$tasks_property_1] == $tasks_value_1 && $tdata[$tasks_property_2] == $tasks_value_2 && $tdata[$tasks_property_3] == $tasks_value_3){
					array_push($returndata, $tdata);
				}
			}
		}
		return $returndata;
	}
	
	
	
	
	public function setMode($server_id, $server_mode = 'normal')
	{
		$vars['sid']=$server_id;
		$vars['mode']= $server_mode;
		$rdata= $this->sendUrlReq($this->url_runmode, $vars, 'POST');
		if($rdata['status'] == 'error'){
			return false;
		}else{
			return true;
		}
	}
	
	
	public function reboot($server_id, $powerop = 'reset')
	{
		$vars['sid']=$server_id;
		$vars['action']= $powerop;
		$rdata= $this->sendUrlReq($this->url_powerop, $vars, 'POST');
		if($rdata['status'] == 'error'){
			return false;
		}else{
			return true;
		}
	}
	
	
	public function setName($server_id,$server_name)
	{
		$vars['sid']=$server_id;
		$vars['name']= $server_name;
		$rdata= $this->sendUrlReq($this->url_rename, $vars, 'POST');
		if($rdata['status'] == 'error'){
			return false;
		}else{
			return true;
		}
	}
		
		
		
	public function setDNS($server_id, $sever_dns)
	{
		$vars['sid']=$server_id;
		$vars['hostname']= $sever_dns;
		$rdata= $this->sendUrlReq($this->url_rdns, $vars, 'POST');
		if($rdata['status'] == 'error'){
			return false;
		}else{
			return true;
		}
	}
		
		
	
	public function getConsole($server_id)
	{
		$vars['sid']=$server_id;
		$rdata= $this->sendUrlReq($this->url_console, $vars, 'POST');
		if($rdata['status'] == 'error'){
			return 'error';
		}else{
			return $rdata['console'];
		}
	}
		
	
	
	public function getResources()
	{
		$rdata= $this->sendUrlReq($this->url_resources);
		if($rdata['status'] == 'error'){
			return $rdata;
		}else{
			return $rdata['data'];
		}
	}
		
	
	
	public function getTotalResources()
	{
		$rdata= $this->getResources();
		if($rdata['status'] == 'error'){
			return $rdata;
		}else{
			$tdata['cpu']= $rdata['total']['cpu_total'];
			$tdata['ram']= $rdata['total']['ram_total'];
			$tdata['storage']= $rdata['total']['storage_total'];
			return $tdata;
		}
	}
		
	
	
	
	public function getUsedResources()
	{
		$rdata= $this->getResources();
		if($rdata['status'] == 'error'){
			return $rdata;
		}else{
			$udata['cpu']= $rdata['used']['cpu_used'];
			$udata['ram']= $rdata['used']['ram_used'];
			$udata['storage']= $rdata['used']['storage_used'];
			return $tdata;
		}
	}
		
	
	
	public function getFreeResources()
	{
		$rdata= $this->getResources();
		if($rdata['status'] == 'error'){
			return $rdata;
		}else{
			$fdata['cpu']= $rdata['total']['cpu_total'] - $rdata['used']['cpu_used'];
			$fdata['ram']= $rdata['total']['ram_total'] - $rdata['used']['ram_used'];
			$fdata['storage']= $rdata['total']['storage_total'] - $rdata['used']['storage_used'];
			return $fdata;
		}
	}
		
	
	
	public function buildServer($new_server_cpu,$new_server_ram,$new_server_disk,$new_server_template)
	{
		$vars['cpu']=$new_server_cpu;
		$vars['ram']=$new_server_ram;
		$vars['storage']=$new_server_disk;
		$vars['os']=$new_server_template;
		$rdata= $this->sendUrlReq($this->url_build, $vars, 'POST');
		if($rdata['status'] == 'error'){
			return $rdata;
		}else{
			return $rdata;
		}
	}
		
	
	
	
	public function deleteServer($server_id)
	{
		$vars['sid']=$server_id;
		$rdata= $this->sendUrlReq($this->url_delete, $vars, 'POST');
		if($rdata['status'] == 'error'){
			return false;
		}else{
			return true;
		}
	}

	
		
	private function  sendUrlReq($url, $vars = null, $method = 'GET')
	{
		$query['key'] = $this->api_key;
		$query['login'] = $this->api_login;
		if(isset($vars))
		{
			$query= array_merge($query, $vars);
		}
		$final_url=$url;
		if($method == 'POST')
		{
			$postdata = http_build_query($query);
			$opts = [
				'http' =>[
					'method'  => 'POST',
					'header'  => 'Content-type: application/x-www-form-urlencoded',
					'content' => $postdata
					]	
			];
			$context  = stream_context_create($opts);
			$data= @file_get_contents($final_url, false, $context);
			
			if($data=== FALSE){ //return error but first clear out key and login
				return ['status'=>'error', 'error'=>'Invalid Request', 'url'=>$final_url, 'postdata'=>$query];
			}
			$udata=  json_decode($data, true);
			return $udata;
		}elseif($method == 'GET'){
			$final_url= $url;
			$i=0;
			foreach($query as $property => $value){
				if($i==0)
				{
					$this->url_add= '?'.$property.'='.$value;
					$final_url=$final_url.$this->url_add;
				}else{
					$this->url_add= '&'.$property.'='.$value;
					$final_url=$final_url.$this->url_add;
				}
				$i++;
			}
			$data= @file_get_contents($final_url, false);
			if($data=== FALSE){ //return error but first clear out key and login
				return ['status'=>'error', 'error'=>'Invalid Request', 'url'=>$final_url, 'getdata'=>$query];
			}
			$udata=  json_decode($data, true);
			return $udata;
		}else{
			echo ['status'=>'error', 'error'=>'Invalid method: '.$method];
		}
	}


}

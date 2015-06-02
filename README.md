# CloudatCost-PHP-WRAPPER


My Cloud At Cost API Wrapper for PHP, 
Cloud at cost API ref: https://github.com/cloudatcost/api

PHP 5.2 or greater is required.


Use Examples:

###Create Object
```
$key = 'asdfghjkl';

$login= 'email@example.com';

$cac= new cloudatcost($key, $login);
```

###List Servers
>will return an array of servers.
```
$data = $cac->listServer();
```	
	
###Get Server by ID
>will return an array of data for the server with the id.
```
$data = $cac->getServer($server_id);
```

###List Templates
>will return an array of templates
```
$data = $cac->listTemplates();
```
	
###Get template
>will return a string with the detials of the template id.
```
$data = $cac->getTemplate($template_id);
```

###List Tasks
>will return an array of tasks	
```
public function listTasks();
```	

###List Filtered Tasks
>will return an array of tasks based on the filters given.
```
$data = $cac->listFilteredTasks($property, $value);
```
```
$data = $cac->listFilteredTasks($property_1, $value_1, $property_2, $value_2);
```
```
$data = $cac->listFilteredTasks($property_1, $value_1, $property_2, $value_2, $property_3, $value_3);
```	
	
###Set mode
>will return true if successfull, false if error
```
$data = $cac->setMode($server_id); // will set mode to normal.
```
```
$data = $cac->setMode($server_id, "safe"); // will set mode to safe.
```

###Set name
>will return true if successfull, false if error.	
```
$data= $cac->setName($server_id, $server_name);
```		

###set reverse dns
>will return true if successfull, false if error.
```
$data= $cac->setDNS($server_id, $sever_dns);
```

###Get Console
>will return a string of text with the URL, or return 'error' if error.
```
$data= $cac->getConsole($server_id);
```

##-- Cloud Pro Functions --


###Get resources
>will return a array with total and used resources.	
```
$data= $cac->getResources();
//$data['total']['total_cpu'], $data['total']['total_ram'],$data['total']['total_storage']
//$data['used']['used_cpu'], $data['used']['used_ram'], $data['used']['used_storage']
```
	
###Get Total resouces
>will return an array of your total resources, 
```
$data= $cac->getTotalResources();
//$data['cpu'], $data['ram'], $data['storage']
```

###Get Used Resources
>will return an array of your used resources,
```
$data= $cac->getUsedResources();
//$data['cpu'], $data['ram'], $data['storage']
```
	
###Get Free Resouces
>will return an array of your free resources,
```
$data= $cac->getFreeResources();
//$data['cpu'], $data['ram'], $data['storage']
```	
	
###Build Server
>will return array with data,
```
$data= $cac->buildServer($cpu,$ram,$disk,$template_id)
//$data['status'], $data['taskid']
```

###Delete Server
>will return true if successfull false if error,	
```
$data= $cac->deleteServer($server_id);
```

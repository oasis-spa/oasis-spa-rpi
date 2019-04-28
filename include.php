<?php

/** Include File **/

if(isset($_GET['p'])) {

$p = addslashes($_GET['p']);


/* Main Page */
if($p == "")							{				include("./files/control/controller.php");				}
else if($p == "logout")					{				include("./files/main/logout.php");	               		}
else if($p == "about")					{				include("./files/main/about.php");	               		}
else if($p == "control") 				{				include("./files/control/controller.php");				} 

if($this_user['rank'] >= "2") {
if($p == "")							{				include("./files/control/controller.php");				}
else if($p == "LOGS.main")				{				include("./files/logs/main.php");	               		}
else if($p == "LOGS.system")			{				include("./files/logs/system.php");	               		}
else if($p == "LOGS.power")				{				include("./files/logs/power.php");	               		}
else if($p == "LOGS.curves")			{				include("./files/logs/curves.php");	               		}
else if($p == "LOGS.push")				{				include("./files/logs/push.php");	               		}
else if($p == "SCHEDULE.main")			{				include("./files/schedule/schedule.php");	      		}



else if($p == "CONF.main")				{				include("./files/configuration/main.php");       		}
else if($p == "CONF.server")			{				include("./files/configuration/server.php");       		}
else if($p == "CONF.sensors")			{				include("./files/configuration/sensors.php");      		}
else if($p == "CONF.relays")			{				include("./files/configuration/relays.php");      		}
else if($p == "CONF.controller")		{				include("./files/configuration/controller.php");   		}
else if($p == "CONF.users")				{				include("./files/configuration/users.php");      		}
else if($p == "CONF.iplist")			{				include("./files/configuration/iplist.php");      		}


}


else if($p == "logout")					{				include("./files/main/logout.php");	               		}

else 									{ 				include("./files/control/controller.php");    			}

}
else {
		include("./files/control/controller.php");
}


?>
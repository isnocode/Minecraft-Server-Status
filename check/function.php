<?php
if (isset($_POST['access'])) {
	error_reporting(0);
	$server = $_POST['server'];
	if (strlen($_POST['server']) < 2) {
		?>
		<div class="col-sm-8 mx-auto">
                <p class="bd-content-title h2 text-center">SERVER STATUS</p>
                <p class="text-center"><?=$server?> is Not Valid</p>
            </div>
		<?php 
	} else {
		//api from mcsrvstat.us
		$get_api = json_decode(file_get_contents("https://api.mcsrvstat.us/2/$server"));
		if (!$get_api) {?>
			<div class="row">
			<div class="col-xl-5 mx-auto">
                <p class="bd-content-title h2 text-center">SERVER STATUS</p>
                <p class="text-center">Failed API, please check your config and try again!</p>
            </div>
        </div>
		<?php }?>
		<?php 
		if ($get_api->online == false) {
			?>
			<div class="row">
			<div class="col-xl-5 mx-auto">
                <p class="bd-content-title h2 text-center">SERVER STATUS</p>
                <p class="text-center"><?=$server?> is Offline or Not Available!</p>
            </div>
        </div>
            <?php
		} else {
			$port = $get_api->port;
			$ip = $get_api->ip;
			$motd = $get_api->motd->html[0];
			if (isset($get_api->motd->html[1])) {
			$motd1 = $get_api->motd->html[1];
		} else {
			$motd1 = '';
		}
			$version = $get_api->version;
			if (isset($get_api->icon)) {
			$icon = $get_api->icon;
			$icon_st = true;
		} else {
			$icon = '';
			$icon_st = false;
		}
			$player = $get_api->players->online;
			$player_max = $get_api->players->max;
			$api_ver = $get_api->debug->apiversion;
			if (isset($get_api->mods)) {
			$mod = $get_api->mods->names;
			foreach ($mod as $mods_list) {
				$num = 0;
				$mods_list = $get_api->mods->names[$num++];
			}
		} else {
			$mods_list = 'Not Available';
		}
		if ($get_api->debug->srv == true) {
			$srv = 'Yes';
		} else {
			$srv = 'No';
		}
		$cache_time = $get_api->debug->cachetime;
		$protocol = $get_api->protocol;
		$query = $get_api->debug->query;
		if ($query == true) {
			$query = 'Yes';
		} else {
			$query = 'No';
		}
			?>
			<div class="row">
				<p class="h4 text-center"><?php if ($icon_st == true) {?><img src="<?=$icon?>" alt="icon" width="49"><?php } else {?><?php }?><span class="fw-bold"> Server Information: <?=$server?></span></p>
				 <div class="dropdown-divider"></div>
				 <br>
			<div class="col-xl-6">
                <p class="bd-content-title h2 text-center">GENERAL</p>
                <p class="text-center">Domain Name: <span class="fw-bold"><?=$server?></span></p>
                <p class="fw-bold">MOTD:</p>
                <p class="server-motd"><?=$motd?><br><?=$motd1?></p>
                <p>Online Player: <span class="fw-bold"><?=$player?>/<?=$player_max?></span></p>
                <p>Version: <span class="fw-bold"><?=$version?></span></p>
                <p>MOD: <span class="fw-bold"><?=$mods_list?></span></p>
            </div>
            <div class="col-xl-6">
                <p class="bd-content-title h2 text-center">ADVANCE</p>
                <p class="text-center">IP Address: <span class="fw-bold"><?=$ip?></span></p>
                <p>Port: <span class="fw-bold"><?=$port?></span></p>
                <p>API Version: <span class="fw-bold"><?=$api_ver?></span></p>
                <p>SRV Record: <span class="fw-bold"><?=$srv?></span></p>
                <p>Cache Time: <span class="fw-bold"><?=$cache_time?></span></p>
                <p>Protocol: <span class="fw-bold"><?=$protocol?></span></p>
                <p>Query Mode: <span class="fw-bold"><?=$query?></span></p>
            </div>
        </div>
			<?php
		}
	}
} else {
	die('No per');
}
?>
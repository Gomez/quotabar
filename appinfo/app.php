<?php

/**
* ownCloud - Quota Bar plugin
*
* @author Simon Kainz
* @copyright 2012 Simon Kainz simon@familiekainz.at
* @copyright 2012 Steffen Lindner gomez@flexiabel.de
* 
* This library is free software; you can redistribute it and/or
* modify it under the terms of the GNU AFFERO GENERAL PUBLIC LICENSE
* License as published by the Free Software Foundation; either 
* version 3 of the License, or any later version.
* 
* This library is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU AFFERO GENERAL PUBLIC LICENSE for more details.
*  
* You should have received a copy of the GNU Lesser General Public 
* License along with this library.  If not, see <http://www.gnu.org/licenses/>.
* 
*/

/*
Changelog:

0.6 Fixed space clac & round to full percent

0.5 Enabled by default

0.4 Fixed quota space except shared files

0.3 Made OC4 compatible

0.2 Fixed divide by zero error

0.1 initial release

*/
#########################################

//If value not set, set to defaul "true"
if(OCP\Config::getUserValue(OCP\USER::getUser(), "quotabar", "quotabar_enabled") == null){
    OCP\Config::setUserValue(OCP\USER::getUser(), "quotabar", "quotabar_enabled", 1);
}

if (OCP\Config::getUserValue(OCP\USER::getUser(), 'quotabar', 'quotabar_enabled') == '1'){

$user=OC_User::getUser();
OC_Filesystem::init($user);

if (OC_FileCache::inCache('/Shared')) {
	   $sharedInfo=OC_FileCache::get('/Shared');
} else {
	   $sharedInfo = null;
}

$userQuota=-1;
$userQuota=OC_Preferences::getValue(OC_User::getUser(),'files','quota','default');
if($userQuota=='default'){
	   $userQuota=OC_AppConfig::getValue('files','default_quota','none');
}
if($userQuota=='none'){
	   $userQuota=0;
}else{
	   $userQuota=OC_Helper::computerFileSize($userQuota);
}
$usedSpace=isset($rootInfo['size'])?$rootInfo['size']:0;

$usedSpace=isset($sharedInfo['size'])?$usedSpace-$sharedInfo['size']:$usedSpace;
#########################################

// inspired (= stolen) from settings/personal.php
$rootInfo=OC_FileCache::get('');
$sharedInfo=OC_FileCache::get('/Shared');
$used=$rootInfo['size'];
if($used<0) $used=0;
$free=OC_Filesystem::free_space();
$total=$free+$used;
if($total==0) $total=1;  // prevent division by zero
$relative=round((($used/$total)*10000)/100);
$quota_display=$relative;

// make total numbers human readable
$usedHuman=OC_Helper::humanFileSize($used);
$totalHuman=OC_Helper::humanFileSize($total);

OCP\App::addNavigationEntry( array( 'id' => 'quotabar', 'order' => 74, 'href' => OCP\Util::linkTo( '', 'index.php' ), 'icon' => OCP\Util::imagePath( 'quotabar', 'hdd.png' ),'name' => '<div title="'.$usedHuman.' of '.$totalHuman.'" style="height:1.5em;"><div id="quotabar" style="float:left;height:1em; width:70%;"></div><div id="quotabar_value" style="width:20%;float:right;font-size:80%;height:1em;font-weight:bold;">'.$quota_display.'%</div></div><script>$("#quotabar").progressbar({ value : '.$relative.'});</script>' ));
}

OCP\App::registerPersonal('quotabar', 'settings');

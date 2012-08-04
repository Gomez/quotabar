<?php
/**
 * Copyright (c) 2012, Steffen Lindner <gomez at flexiabel dot de>
 * This file is licensed under the Affero General Public License version 3 or later.
 * See the COPYING-README file.
 */

OC_JSON::checkLoggedIn();
OCP\JSON::callCheck();

$l=OC_L10N::get('quotabar');

$qb_enabled = OCP\Config::getUserValue(OCP\USER::getUser(), "quotabar", "quotabar_enabled");
    
// Get data
if(isset($_POST['quotabar_enabled'])){
    $qb_enabled = $_POST['quotabar_enabled'];
}
$username = OCP\USER::getUser();
if($username){
	OC_Preferences::setValue($username,'quotabar','quotabar_enabled',!($qb_enabled));
	OC_JSON::success(array("data" => array( "message" => $l->t("Quotabar enabled") )));
}


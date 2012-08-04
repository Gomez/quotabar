<?php /**
 * Copyright (c) 2012 Steffen Lindner <gomez at felxiabel dot de>
 * This file is licensed under the Affero General Public License version 3 or
 * later.
 * See the COPYING-README file.
 */
?>
<form id="quotabar">
	<fieldset class="personalblock">
	<label for="quotabar"><strong>Enable Quotabar</strong></label>
    <input id="quotabar_enabled" type="checkbox" name="quotabar_enabled" <?php echo ($_['quotabar_enabled'] ?' checked="checked"':''); ?> value="<?php echo ($_['quotabar_enabled']) ?>">
    </fieldset>
</form>	

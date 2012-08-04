/**
 * Copyright (c) 2012, Steffen Lindner <gomez at flexiabel dot de>
 * This file is licensed under the Affero General Public License version 3 or later.
 * See the COPYING-README file.
 */

$(document).ready(function(){
	$("#quotabar_enabled").change( function(){
		// Serialize the data
		var post = $("#quotabar_enabled").serialize();
        // Ajax foo
		//alert($("#quotabar_enabled").val() );
        $.post( OC.filePath('quotabar', 'ajax', 'changequotabar.php'), post, function(data){
			if( data.status == "success" ){
				location.reload();
			}
		});
		return false;
	});
});

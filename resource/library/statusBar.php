
<script>
$(document).ready(function(){
	var pos = $('#userSearch').offset();
	$('#search_results').offset({ top: pos.top+26, left: pos.left });
	
	});
</script>

<div id="coreStatusBar"> 
<div id="coreStatusBarLeft"></div>
<div id="coreStatusBarCenter">
<div class="input-append">
<input id="userSearch" type="text" class="span4" style=" margin-top:5px;"  autocomplete="off"/><span class="add-on"><i class="icon-search"></i></span>
</div>
</div>
<div id="coreStatusBarRight"><?php echo $_SESSION['user']->fullname.': '; ?> 
<input id="logout_button" name="" type="button" value="Logoff" class="btn-core" data-type="<?php echo $_SESSION['user']->loginType ?>"/>
</div>
</div>
<div id="search_results" class="span4">
	<ul>
	</ul>
</div>
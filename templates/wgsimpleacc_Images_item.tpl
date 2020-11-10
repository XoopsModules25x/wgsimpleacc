<i id='imgId_<{$image.img_id}>'></i>
<div class='panel-heading'>
</div>
<div class='panel-body'>
	<span class='col-sm-9 justify'><{$image.traid}></span>
	<span class='col-sm-3'><img src='<{$wgsimpleacc_upload_url}>/images/images/<{$image.name}>' alt='images' /></span>
	<span class='col-sm-9 justify'><{$image.desc}></span>
	<span class='col-sm-9 justify'><{$image.datecreated}></span>
	<span class='col-sm-9 justify'><{$image.submitter}></span>
</div>
<div class='panel-foot'>
	<div class='col-sm-12 right'>
		<{if $showItem}>
			<a class='btn btn-success right' href='images.php?op=list&amp;#imgId_<{$image.img_id}>' title='<{$smarty.const._MA_WGSIMPLEACC_IMAGES_LIST}>'><{$smarty.const._MA_WGSIMPLEACC_IMAGES_LIST}></a>
		<{else}>
			<a class='btn btn-success right' href='images.php?op=show&amp;img_id=<{$image.img_id}>' title='<{$smarty.const._MA_WGSIMPLEACC_DETAILS}>'><{$smarty.const._MA_WGSIMPLEACC_DETAILS}></a>
		<{/if}>
		<{if $permEdit}>
			<a class='btn btn-primary right' href='images.php?op=edit&amp;img_id=<{$image.img_id}>' title='<{$smarty.const._EDIT}>'><{$smarty.const._EDIT}></a>
			<a class='btn btn-danger right' href='images.php?op=delete&amp;img_id=<{$image.img_id}>' title='<{$smarty.const._DELETE}>'><{$smarty.const._DELETE}></a>
		<{/if}>
	</div>
</div>

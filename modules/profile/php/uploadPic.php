<div clss="formWrap">
<form class="well" method="post" action="../../resource/library/imageHost/upload.php" id="uploadPicForm" enctype="multipart/form-data" target="upload_target">
<label for="myfile">Odaberi sliku</label>
<input id="upload_image"  name="myfile" type="file"  size="46" class="file_input_hidden"  accept="image/jpeg,image/png,image/gif" />
<input type="hidden" name="userID" value="<?php echo $_GET['userid']; ?>" />
<div>
<hr>
<input type="submit" name="submit" id="submitButton" value="Dodaj" class="btn btn-core btn-large"/>
<input type="button" name="cancel" id="cancelButton" value="Odustani" class="btn btn-large"/>
<img class="loadingGif" style="display:none" src="images/loading.gif" />
</div>
<iframe id="upload_target" name="upload_target" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>
</form>

</div>
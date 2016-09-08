<?php
	printf('
						<div class="bbody">
							<form id="upload_form" enctype="multipart/form-data" method="post" action="?option=uploadImg" onsubmit="return checkForm()">
								<!-- скрытые параметры -->
								<input type="hidden" id="x1" name="x1" />
								<input type="hidden" id="y1" name="y1" />
								<input type="hidden" id="x2" name="x2" />
								<input type="hidden" id="y2" name="y2" /> 
								
								<div><input type="file" name="image_file" id="image_file" onchange="fileSelectHandler()" /></div>
								<h2>Загрузите фото</h2>
								
								<div class="step2"></div>
								<div class="error"></div>
							</form>
							<hr>
						</div>
					');
?>
<?php 
	printf('<div class="container logo" >
						<div class="row">
								<div class="col-xs-4 col-sm-4 ">
								<div class="">
									<a href="?option=main"><div class="caption lineTopLog">
																PhotosLike<i class="glyphicon glyphicon-heart logoHeart"></i>
															</div>
									</a>
								</div>
								</div>
							</div>
			</div>
	<div class="container logo">
						<div class="row">
								<div class="col-xs-4 col-sm-4 ">
									<div class="thumbnail">
										<div class="caption">
											<span class="text-info">Вход</span>
										</div>
										<form  method="post" name="avtForm" onsubmit="return formdataAvt(avtForm)" action="?option=login">
											<div class="caption logoWidths">
												<div class="input-group">
													<span class="input-group-addon mobil">@</span>
													<input type="text" class="form-control" name="emailLogin" id="emailAvt" placeholder="E-Mail">
													<span class="input-group-addon mobil validAvtEmail"></span>
												</div>
											</div>
											<div class="caption logoWidths">
												<div class="input-group">
												  <span class="input-group-addon mobil">***</span>
												  <input type="password" class="form-control" name="passLogin" id="passAvt" placeholder="Пароль">
												  <span class="input-group-addon mobil validAvtPass"></span>
												</div>
											</div>
											<div align="center">
												<input class="btn btn-default btn-sm" type="submit" value="Войти" />
											</div>
										</form>
										<div class="caption logoWidths">
											
										</div>
									</div>
									<!--          ////Reg -->
									<br />
									<div class="thumbnail">
										<div class="caption">
											<span class="text-info">Регистрация</span>
										</div>
										<form  method="post" name="regForm" onsubmit="return formdata(regForm)" action="?option=login">
											<div class="caption logoWidths">
												<div class="input-group">
													<span class="input-group-addon mobil">@</span>
													<input type="text" class="form-control" name="email" id="email" placeholder="E-Mail">
													<span class="input-group-addon mobil validResEmail"></span>
												</div>
											</div>
											<div class="caption logoWidths">
												<div class="input-group">
												  <span class="input-group-addon mobil">***</span>
												  <input type="password" class="form-control" name="pass" id="pass" placeholder="Пароль">
												  <span class="input-group-addon mobil  validResPass"></span>
												</div>
											</div>
											<div class="caption logoWidths">
												<div class="input-group">
												  <span class="input-group-addon mobil"><i class="glyphicon glyphicon-user"></i></span>
												  <input type="text" class="form-control" name="name" id="name" placeholder="Имя фамилия">
													<span class="input-group-addon mobil validResName"></span>
												</div>
											</div>
											<div class="caption logoWidths">
												<div class="input-group">
												  <span class="input-group-addon mobil"><i class="glyphicon glyphicon-user"></i>+</span>
												  <input type="text" class="form-control" name="alias" id="alias" placeholder="Псевдоним">
													<span class="input-group-addon mobil validResAlias"></span>
												</div>
											</div>
											<div align="center">
												<input class="btn btn-default btn-sm" type="submit" value="Зарегистрироваться" />
											</div>
										</form>
										<div class="caption logoWidths">
											
										</div>
									</div>
								</div>
								<div class="col-xs-8 col-sm-8">
									<a href="?option=main">
										<img src="img/reg1.png" class="regImg">
									</a>
								</div>
								
								
						</div>
						
						
					</div>
					');
?>
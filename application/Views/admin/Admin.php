<!DOCTYPE html>
<html>
	<head>	
	    <meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	    <meta name="Keywords" content="">
	    <meta name="Description" content="">
	    <title>Admin</title>
		<?= view('admin/Asset'); ?>
		<script>
			var _messagedlg, _formdlg, _form, _table;

			$().ready(function(){
				//$('#message').modal('show');
				//初始化控件
				_messagedlg = $('#messagedlg');
				_formdlg = $('#coudialog');
				_deletedlg = $('#deletedlg');
				_form = $('#couform');
				_table = $('#table');
				
				//初始化表单
				$('#couform').form({
			            fields: {
			              	Id:  'empty',
				            Username : 'empty',
				            Email : 'empty',
				            Password : 'empty',
				            Auth : 'empty',
				            Status : 'empty'
				        },
			        	onSuccess : function(event, fields){
							_formdlg.modal('duration',0).modal('hide');
							_messagedlg.modal('show').find('div').html('<i class="wait icon blue"></i>处理中');

							var id = isNaN($('#Id').val()) ? 0 : parseInt($('#Id').val());
							if (id == 0){
								$.ajax({
								  	url: '<?php echo current_url();?>/',								  	
								  	method : 'POST',
								  	dataType : 'json',
								  	data: _form.serializeArray()
								}).done(function(data) {
									if (data.code == 1) {
										_messagedlg.find('div').html('<i class="checkmark icon green"></i>成功');

										body = '<tr id="SelectData_' + data.id + '">' +
											'<td id="Id_' + data.id + '">' + data.id + '</td>' +
											'<td id="Username_' + data.id + '">' + $('#Username').val() + '</td>' +
											'<td id="Email_' + data.id + '">' + $('#Email').val() + '</td>' + 
											'<td id="Password_' + data.id + '">' + $('#Password').val() + '</td>' +
											'<td id="Auth_' + data.id + '">' + $('#Auth').val() + '</td>' +
											'<td id="Status_' + data.id + '">' + $('#Status').val() + '</td>' +
											'<td>' +
												'<div class=" ui tiny buttons">' +
													'<button class="ui primary button" data-id="' + data.id + '" data-method="update">修改</button>' +
													'<button class="ui button" data-id="' + data.id + '" data-method="delete">删除</button>' +
												'</div>' +
											'</td>' +
										'</tr>';
										$(_table).append(body);
									}else{
										_messagedlg.find('div').html('<i class="remove icon red"></i>失败');
									}
									_form.form('reset')
								});
							}else{
								$.ajax({
								  	url: '<?php echo current_url();?>/' + id,								  	
								  	method : 'PUT',
								  	dataType : 'json',
								  	data: _form.serializeArray()
								}).done(function(data) {
									if (data.code == 1) {
										$('#Username_' + id).html($('#Username').val());
										$('#Email_'+ id).html($('#Email').val());
										$('#Password_'+ id).html($('#Password').val());
										$('#Auth_'+ id).html($('#Auth').val());
										$('#Status_'+ id).html($('#Status').val());

										_messagedlg.find('div').html('<i class="checkmark icon green"></i>成功');
									}else{
										_messagedlg.find('div').html('<i class="remove icon red"></i>失败');
										_form.form('reset')
									}
								});
							}
							return false;
						}
			        }
		        );

				//按键初始化
				$(document).on('click', 'button', function(){
					var method = $(this).data('method');
					switch(method){
						case 'create':
							_form.form('reset')
							_formdlg.modal('show').find('div[name=yes]').on('click',function(){
								_form.submit();
							});
							break;
						case 'update':
							var id = $(this).data('id');

							$.ajax({
							  	url: '<?php echo current_url();?>/' + id,								  	
							  	method : 'GET',
							  	dataType : 'json'
							}).done(function(data) {
								if (data.code == 1) {
									_form.form('reset')
									_formdlg.modal('show').find('div[name=yes]').on('click',function(){
										_form.submit();
									});

									$('#Id').val(data.data.Id);
									$('#Username').val(data.data.Username);
									$('#Email').val(data.data.Email);
									$('#Password').val(data.data.Password);
									$('#Auth').val(data.data.Auth);
									$('#Status').val(data.data.Status);
								}else{
									_messagedlg.modal('show').find('div').html('<i class="remove icon blue"></i>获取信息失败');
								}
							});							
							break;
						case 'delete':
							var id = $(this).data('id');

							_deletedlg.modal('show').find('div[name=yes]').on('click',function(){
								_deletedlg.modal('duration',0).modal('hide');
								_messagedlg.modal('show').find('div').html('<i class="wait icon blue"></i>删除中');
								$.ajax({
								  	url: '<?php echo current_url();?>/' + id,								  	
								  	method : 'DELETE',
								  	dataType : 'json',
								}).done(function(data) {
									if (data.code == 1) {
										_messagedlg.find('div').html('<i class="checkmark icon green"></i>删除成功');
										$('#SelectData_' + id).remove()										
									}else{
										_messagedlg.find('div').html('<i class="remove icon green"></i>删除失败');
									}
								});
							});
							break;
					}
				});
			});

			function initdialog(id, header, content, actions){
				if(id){
					var m = $('#' + id);
					if(header){
						m.find('div[class=header]').html(header);
					}
					if(content){
						m.find('div[class=content]').html(content);
					}
					if(actions){
						m.find('div[class=actions]').html(actions);
					}
					return m;
				}else{
					return false;
				}
			}

			function initform(){
				var m = $('#couform');
				m.form('reset');

				return m;
			}

			function submitform(event, fields){
				var m = $('#coudialog');
				var y = m.find('div[name=yes]') , n = m.find('div[name=no]'), c = m.find('div[class=content]');
				var f = $('#couform');
				var id = isNaN($('#Id').val()) ? 0 : parseInt($('#Id').val());

				y.addClass('loading');
				n.addClass('disabled');
				if (id == 0){
					$.ajax({
					  	url: '<?php echo current_url();?>/',								  	
					  	method : 'POST',
					  	dataType : 'json',
					  	data: f.serializeArray()
					}).done(function(data) {
						if (data.code == 1) {
							y.removeClass('loading labeled').html('成功').off('click').addClass('positive');
							n.remove();
						}else{
							y.removeClass('loading labeled').html('失败').off('click').addClass('red');
							n.remove();
						}
						initform();
					});
				}else{
					$.ajax({
					  	url: '<?php echo current_url();?>/' + id,								  	
					  	method : 'PUT',
					  	dataType : 'json',
					  	data: f.serializeArray()
					}).done(function(data) {
						if (data.code == 1) {
							y.removeClass('loading labeled').html('成功').off('click').addClass('positive');
							n.remove();

							$('#Username_' + id).html($('#Username').val());
							$('#Email_'+ id).html($('#Email').val());
							$('#Password_'+ id).html($('#Password').val());
							$('#Auth_'+ id).html($('#Auth').val());
							$('#Status_'+ id).html($('#Status').val());
						}else{
							y.removeClass('loading labeled').html('失败').off('click').addClass('red');
							n.remove();
						}
						initform();
					});
				}
				return false;
			}
		</script>
	</head>
	<body style="margin:0; padding:0">
		<?= view('admin/Menu'); ?>
		
		<!-- Main -->
		<div class="wrapper" ng-view="" style="padding: 60px 0 0;">
			<section class="ui grid user-index" style="margin: 0; padding: 12px 20px;">
			    <div class="ui twelve wide column">
				    <table class="ui compact celled definition table">
				    	<tfoot class="full-width">
						    <tr>
						      	<th>
						        	<button class="ui left small primary labeled icon compact button" data-id="0" data-method="create">
						          		<i class="plus icon"></i>添加
						        	</button>
						      	</th>
						    </tr>
						</tfoot>
					</table>
			    </div>
			    <div class="ui twelve wide column">
			        <table class="ui striped selectable celled table" id="table">
					  	<thead>
						    <tr>
							    <th>Id</th>
							    <th>Name</th>
							    <th>Email</th>
							    <th>Password</th>
							    <th>Auth</th>
							    <th>Status</th>
							    <th style="width:160px;">操作</th>
						  	</tr>
					  	</thead>
						<tbody>
							<?php foreach ($data as $d):?>
						    <tr id="SelectData_<?= $d->Id ?>">
						      	<td id="Id_<?= $d->Id ?>"><?= $d->Id ?></td>
						      	<td id="Username_<?= $d->Id ?>"><?= $d->Username ?></td>
						      	<td id="Email_<?= $d->Id ?>"><?= $d->Email ?></td>
						      	<td id="Password_<?= $d->Id ?>"><?= $d->Password ?></td>
						      	<td id="Auth_<?= $d->Id ?>"><?= $d->Auth ?></td>
						      	<td id="Status_<?= $d->Id ?>"><?= $d->Status ?></td>
						      	<td>
  									<div class=" ui tiny buttons">
  										<button class="ui primary button" data-id="<?= $d->Id ?>" data-method="update">修改</button>
        								<button class="ui button" data-id="<?= $d->Id ?>" data-method="delete">删除</button>
						        	</div>
						        </td>
						    </tr>
        					<?php endforeach;?>
						</tbody>
						<tfoot>
						    <tr>
							    <th colspan="30">
								    <?= $pager->links('default', 'admin_common') ?>				    
								    </div>
							    </th>
						  	</tr>
						</tfoot>
					</table>
				</div>
			</section>
		</div>

		<!-- Model -->
		<div class="ui small test modal" id="messagedlg">
		    <div class="content text-center">
		    <!--
        		<i class="remove icon red"></i>失败
        		<i class="checkmark icon green"></i>成功
        	-->
        	</div>
		</div>

		<div class="ui small test modal" id="deletedlg">
		    <div class="header">删除</div>
		    <div class="content"><p>确定要删除吗？</p></div>
		    <div class="actions"><div class="ui negative button" name="no">否</div><div class="ui green right labeled icon button" name="yes">是<i class="checkmark icon"></i></div></div>
		</div>

		<div class="ui small modal" id="coudialog">
		    <div class="header">Admin</div>
		    <div class="content">
			    <form class="ui form" id="couform">
		            <div class="field">
    					<label>Username</label>
		                <input type="text" name="Username" id="Username" placeholder="Username">
		            </div>
		            <div class="field">
		              	<label>Email</label>
		                <input type="text" name="Email" id="Email" placeholder="Email">
		            </div>
		            <div class="field">
		              	<label>Password</label>
		                <input type="text" name="Password" id="Password" placeholder="Password">
		            </div>
		            <div class="field">
		              	<label>Auth</label>
		                <input type="text" name="Auth" id="Auth" placeholder="Auth">
		            </div>
		            <div class="field">
		              	<label>Status</label>
		                <input type="text" name="Status" id="Status" placeholder="Status">
		            </div>
					<input type="hidden" name="Id" id="Id" value="0">
	          		<div class="ui error message"></div>
        		</form>
		    </div>
		    <div class="actions">
		    	<div class="ui negative button" name="no">取消</div>
		    	<div class="ui green button" name="yes">保存</div>
		    </div>
		  </div>
	</body>
</html>
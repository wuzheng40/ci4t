<!DOCTYPE html>
<html>
	<head>	
	    <meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	    <meta name="Keywords" content="">
	    <meta name="Description" content="">
	    <title><?= $header?></title>
		<?= view('admin/Asset'); ?>
		<script>
			var _messagedlg, _formdlg, _form, _table, _searchform;

			$().ready(function(){
				//初始化控件
				_messagedlg = $('#messagedlg');
				_formdlg = $('#coudialog');
				_deletedlg = $('#deletedlg');
				_form = $('#couform');
				_table = $('#table');
				_searchform = $('#searchform');
				
				//初始化表单
				$('#couform').form({
			            fields: {
			              	Id:  'empty',
				            Username : 'empty',
				            Email : 'empty',
				            Password : 'empty',
				            Auth : 'empty'
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
											'<td id="Status_' + data.id + '">' + Number($('#Status').prop('checked')) + '</td>' +
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
										$('#Status_'+ id).html(Number($('#Status').prop('checked')));

										_messagedlg.find('div').html('<i class="checkmark icon green"></i>成功');
									}else{
										_messagedlg.find('div').html('<i class="remove icon red"></i>失败');
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
							_form.form('reset');
							_formdlg.modal('show').find('div[name=yes]').one('click',function(){
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
									_form.form('reset');
									_formdlg.modal('show').find('div[name=yes]').one('click',function(){
										_form.submit();
									});

									$('#Id').val(data.data.Id);
									$('#Username').val(data.data.Username);
									$('#Email').val(data.data.Email);
									$('#Password').val(data.data.Password);
									$('#Auth').val(data.data.Auth);
									$('#Status').prop('checked', Boolean(Number(data.data.Status)));
								}else{
									_messagedlg.modal('show').find('div').html('<i class="remove icon blue"></i>获取信息失败');
								}
							});							
							break;
						case 'delete':
							var id = $(this).data('id');

							_deletedlg.modal('show').find('div[name=yes]').one('click',function(){
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
						case 'search':
							_searchform.submit();
							break;
					}
				});
			});
		</script>
	</head>
	<body style="margin:0; padding:0">
		<?= view('admin/Menu', ['header' => $header]); ?>
		
		<!-- Main -->
		<div class="wrapper" ng-view="" style="padding: 60px 0 0;">
			<section class="ui grid user-index" style="margin: 0; padding: 12px 20px;">
			    <div class="ui twelve wide column">
				    <table class="ui compact celled definition table">
				    	<tfoot class="full-width">
				    		<tr>
						      	<th>
						      		<form class="ui form" id="searchform" action="<?php echo current_url();?>" method="get">
						      			<div class="fields">
								      		<div class="three wide field">
								      			<label>Id</label>
								                <input type="text" name="search_Id" placeholder="Id">
								            </div>
								      		<div class="three wide field">
								      			<label>Username</label>
								                <input type="text" name="search_Username" placeholder="Username">
								            </div>
								      		<div class="three wide field">
								      			<label>Email</label>
								                <input type="email" name="search_Email" placeholder="Email">
								            </div>
								      		<div class="three wide field">
								      			<label>Password</label>
								                <input type="text" name="search_Password" placeholder="Password">
								            </div>
								      		<div class="three wide field">
								      			<label>Auth</label>
								                <select class="ui tiny dropdown" name="search_Auth"> 
											      	<option value="">All</option>
											      	<option value="Admin">Admin</option>
											      	<option value="PowerUser">PowerUser</option>
											      	<option value="Guest">Guest</option>
											    </select>
								            </div>
								      		<div class="three wide field">
								      			<label>Status</label>
								                <select class="ui tiny dropdown" name="search_Status"> 
											      	<option value="">All</option>
											      	<option value="1">1</option>
											      	<option value="0">0</option>
											    </select>
								            </div>
						            	</div>
						            </form>
						      	</th>
						    </tr>
						    <tr>
						      	<th>
						      		<button class="ui left small labeled icon compact button" data-id="0" data-method="search">
						          		<i class="find icon"></i>查询
						        	</button>
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
							    <th>Username</th>
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
		                <input type="email" name="Email" id="Email" placeholder="Email">
		            </div>
		            <div class="field">
		              	<label>Password</label>
		                <input type="text" name="Password" id="Password" placeholder="Password">
		            </div>
		            <div class="field">
		              	<label>Auth</label>
		                <input type="text" name="Auth" id="Auth" placeholder="Auth">
		            </div>
		            <div class="ui checkbox">
		              	<input type="checkbox" name="Status" id="Status"><label>Status</label>
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
<!-- Nav -->
		<div class="ui fixed transparent main menu" id="top-menu">
			<div class="header">
				<span class="top-user-name ellipsis" title="Admin">Admin-Menu</span>
			</div>

			<div class="right menu">
				<!-- 加号 -->
			    <div class="ui simple dropdown item" style="padding: 0;">
			        <div class="menu">
			            <a class="item mw" href="<?php echo base_url('Admin/Admins');?>"><i class="user icon"></i>账号</a>
			            <a class="item mw" href="<?php echo base_url('Admin/Logs');?>"><i class="list icon"></i>日志</a>
			        </div>
			        <a class="add-project icon item"><i class="add icon"></i></a>
			    </div>

			    <!-- 任务 -->
			    <div class="ui simple dropdown item" style="padding: 0;">
			        <div class="menu task-menu wide">
			            <div class="top-menu-tasks tasks">
			                <div class="task ng-isolate-scope">
							    <div class="flex-box">
							        <!-- 优先级 -->
							        <div class="textarea-urgency task-urgency-dropdown ui icon top left pointing dropdown">
									    <div class="task-urgency-wrapper"></div>
									</div>
							        <span class="date expired">2017年02月13日</span>
							        <!-- 任务标题 -->
							        <a class="title ellipsis flex-auto-justify" href="#">任务完成</a>
							    </div>
							</div>
			                <div class="task ng-isolate-scope">
							    <div class="flex-box">
							        <!-- 优先级 -->
							        <div class="textarea-urgency task-urgency-dropdown ui icon top left pointing dropdown">
									    <div class="task-urgency-wrapper"></div>
									</div>
							        <span class="date expired">2016年12月30日</span>
							        <!-- 任务标题 -->
							        <a class="title ellipsis flex-auto-justify" href="#">任务进行中</a>
							    </div>
							</div>
			                <div class="task ng-isolate-scope">
							    <div class="flex-box">
							        <!-- 优先级 -->
							        <div class="textarea-urgency task-urgency-dropdown ui icon top left pointing dropdown">
									    <div class="task-urgency-wrapper"></div>
									</div>
							        <span class="date expired">2016年10月30日</span>
							        <!-- 任务标题 -->
							        <a class="title ellipsis flex-auto-justify" href="#">任务开始</a>
							    </div>
							</div>
							<div class="task">
			                    <a href="<?php echo base_url('Admin/Logs');?>">查看全部日志<i class="angle double right icon"></i></a>
			                </div>
            			</div>
        			</div>
			        <a class="icon item inbox"><i class="tasks icon"></i></a>
			    </div>

			    <!-- 通知 -->
			    <div class="ui simple dropdown item" style="padding: 0;">
			        <div class="menu task-menu wide">
			            <div class="top-menu-tasks tasks">
			                <div class="task ng-isolate-scope">
							    <div class="flex-box">
							        <!-- 优先级 -->
							        <div class="textarea-urgency task-urgency-dropdown ui icon top left pointing dropdown">
									    <div class="task-urgency-wrapper"></div>
									</div>
							        <span class="date today">刚刚</span>
							        <!-- 任务标题 -->
							        <a class="title ellipsis flex-auto-justify" href="#">新邮件</a>
							    </div>
							</div>
			                <div class="task ng-isolate-scope">
							    <div class="flex-box">
							        <!-- 优先级 -->
							        <div class="textarea-urgency task-urgency-dropdown ui icon top left pointing dropdown">
									    <div class="task-urgency-wrapper"></div>
									</div>
							        <span class="date tomorrow">明天</span>
							        <!-- 任务标题 -->
							        <a class="title ellipsis flex-auto-justify" href="#">新人就位</a>
							    </div>
							</div>
			                <div class="task ng-isolate-scope">
							    <div class="flex-box">
							        <!-- 优先级 -->
							        <div class="textarea-urgency task-urgency-dropdown ui icon top left pointing dropdown">
									    <div class="task-urgency-wrapper"></div>
									</div>
							        <span class="date done">前天</span>
							        <!-- 任务标题 -->
							        <a class="title ellipsis flex-auto-justify" href="#">任务开始</a>
							    </div>
							</div>
							<div class="task">
			                    <a href="<?php echo base_url('Admin/Messages');?>">查看全部通知<i class="angle double right icon"></i></a>
			                </div>
            			</div>
        			</div>
			        <a class="inbox icon item"><i class="bell icon"></i></a>
			    </div>

			    <!-- 下拉框 -->
			    <div class="ui dropdown item userinfo" id="drop">
			        <div class="menu frequently-projects ui transition hidden">
			            <div class="frequently-used-projects">
			            	<div class="projects-wrapper">
				    			<div class="title clearfix">
							        <span class="coding floated left">
							            <i class="pin icon rotate30"></i>常用项目
							        </span>
							        <span class="coding floated right">
							            <a class="gray" href="/user/projects">
							                <i class="setting icon"></i>
							            </a>
							        </span>
							    </div>
							    <div class="content">
							        <div class="">
							            <div class="content">
									        <div class="empty-list coding aligned center ng-scope" style="text-align:center;">
									                <i class="coffee icon"></i>
									                <span style="color: #666; line-height: 23px;">
									                    欢迎登陆
									                </span><br>
									                <a href="/user/projects" class="ui button ng-binding">马上去设置</a>
									        </div>
									        <div class="">
									            <ul class="frequent-project-list clearfix">
									            </ul>
									        </div>
									    </div>
							        </div>
							    </div>
							</div>
						</div>
				        <div class="menu-item-wrapper">
				        	<!--
				            <a class="item" href="/user/account"><i class="dashboard icon"></i>我的账户</a>
				            <a class="item" ng-href="/user/account/setting/basic" href="/user/account/setting/basic"><i class="user icon"></i>个人设置</a>
				            <a class="item with-border-bottom" ng-href="/u/wuzheng40" href="/u/wuzheng40"><i class="magic icon"></i>我的主页</a>
				            <a class="item with-border-bottom" ng-href="/upgrade" href="/upgrade"><i class="circle up icon"></i>项目升级</a>
				            <a class="item" ng-href="https://blog.coding.net" target="_blank" href="https://blog.coding.net"><i class="lightbulb icon"></i>博客</a>
				            <a class="item" ng-href="https://coding.net/help" target="_blank" href="https://coding.net/help"><i class="help icon"></i>帮助</a>
				            <a class="item with-border-bottom" ng-href="/app" href="/app"><i class="download disk icon"></i>APP 下载</a>-->
				            <a class="item with-border-bottom" href="javascript:void(0)"><i class="sign out icon"></i>退出</a>
				        </div>
				    </div>
				    <a class="ui avatar image message-breath" style="margin-top:-10px;top:18px;">
            			<img ng-src="https://dn-coding-net-production-avatar.qbox.me/Fruit-12.png?imageMogr2/thumbnail/80" src="https://dn-coding-net-production-avatar.qbox.me/Fruit-12.png?imageMogr2/thumbnail/80">
        			</a>
        			<i class="dropdown icon" id="dropdown-icon"></i>
				</div>
			</div>
			<script type="text/javascript">
		    	$('#drop').dropdown();
		    </script>
		</div>

		<!-- Left -->
		<div class="ui small vertical inverted labeled icon sidebar fixed menu active visible" id="context-menu">
		    <a class="item" title="账户" href="<?php echo base_url('Admin/Admins');?>">
		        <i class="big user icon"></i>
		        <span class="menu-title">账户</span>
		    </a>
		    <span class="item divider"></span>
		    <span class="item divider"></span>
		</div>		
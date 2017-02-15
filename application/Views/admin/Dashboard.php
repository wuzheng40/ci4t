<!DOCTYPE html>
<html>
	<head>	
	    <meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	    <meta name="Keywords" content="">
	    <meta name="Description" content="">
	    <title>Admin</title>
		<?= view('admin/Asset'); ?>
	</head>
	<body style="margin:0; padding:0">
		<?= view('admin/Menu'); ?>
		
		<!-- Main -->
		<div class="wrapper" ng-view="" style="padding: 60px 0 0;">
			<section class="ui grid user-index" style="margin: 0; padding: 12px 20px;">
			    <div class="ui ten wide column">
			        <div class="my-projects">
			            <div class="ui dividing header">
			                我的项目
			            </div>
			            <div class="ui relaxed horizontal selection list" id="project-list">
			                <a class="item" href="/u/wuzheng40/p/Demo">
			                    <div>
			                        <img ng-src="https://coding.net/static/project_icon/scenery-15.png" width="120px" height="120px" src="https://coding.net/static/project_icon/scenery-15.png">
			                    </div>
			                    <p class="project-name">
			                        <i class="lock icon"></i>
			                        <span class="">wuzheng40/Demo</span>
			                    </p>
			                </a>
			            </div>
			        </div>
			        <div class="project-activities">
			            <div class="ui dividing header">
			                LIST
			            </div>

			            <div class="activity tabs">
			                <div class="tab active" ng-class="{active:activity_type==1}" ng-click="switchProjectActivities(1)">我的项目
			                </div>
			                <div class="tab" ng-class="{active:activity_type==2}" ng-click="switchProjectActivities(2)">关注的项目
			                </div>
			                <div class="tab" ng-class="{active:activity_type==3}" ng-click="switchProjectActivities(3)">关注的人
			                </div>
			            </div>

			            <div class="ui basic segment" id="project-activities">
			            </div>

			            <div class="center empty list">
			               {{Page}}
			            </div>
			        </div>
    			</div>
    			<div class="ui six wide column">
        			<div class="wrapper project tasks just-show">
			            <div class="ui dividing header">
			                我的任务
			            </div>
						<div class="">

						</div>
					</div>
				</div>
            	<a class="right more gray" style="text-align:center;margin-top:10px;" href="/user/tasks?owner=322704">查看我的任务</a>
			</section>
		</div>
	</body>
</html>
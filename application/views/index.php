<!DOCTYPE html>
<html lang="en" data-ng-app="tiresApp">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<meta name="description" content="Tires Hunt App with CodeIgniter 3 + AngularJS">
		<meta name="author" content="Nathan Fan">

		<title>Nathan Demo Tires Hunt App with CodeIgniter + AngularJS</title>

		<!--<script src="<?php echo base_url('../assets/js/bootstrap.min.js') ?>"></script>-->
		<script src="<?php echo base_url('../assets/js/angular.min.js') ?>"></script> 
		<script src="<?php echo base_url('../assets/js/angular-animate.min.js') ?>"></script> 
		<script src="<?php echo base_url('../assets/js/ui-bootstrap-tpls-0.14.3.min.js') ?>"></script>
		<script src="<?php echo base_url('../assets/js/app.js') ?>"></script>

		<!-- Bootstrap core CSS -->
		<link href="<?php echo base_url('../assets/css/bootstrap.min.css') ?>" rel="stylesheet">

		<!-- Custom styles for this template -->
		<!--<link href="<?php echo base_url('../assets/css/app.css') ?>" rel="stylesheet"> -->

		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>

	<body data-ng-controller="TiresCtrl">
		<!-- Begin page content -->
		<div class="container">
			<div class="page-header clearfix">
				<nav>
					<!-- <ul class="nav nav-pills pull-right">
					<li role="presentation" class="active"><a href="#">Home</a></li>
					<li role="presentation"><a href="http://blog.pisyek.com/create-todo-app-with-codeigniter-3-angularjs/">Tutorial</a></li>
					<li role="presentation"><a href="http://pisyek.com/about">About</a></li>
					<li role="presentation"><a href="http://pisyek.com/contact">Contact</a></li>
				</ul> -->
				</nav>
				<h3 class="text-muted">Tires Hunt App</h3>
			</div>

			<p class="lead">Select tab below to search tires by using Vehicle/Size.</p>

			<div style="text-align:center">
				<h1>Tires Hunt App</h1>
			</div>

			<div data-ng-controller="TabsCtrl">
				<uib-tabset>
					<uib-tab ng-repeat="tab in tabs" heading="{{tab.title}}" active="tab.active" disable="tab.disabled">
			      		<div ng-include="tab.content"></div>
			    	</uib-tab>
				</uib-tabset>

			</div>

			

		</div>

		<!-- Begin page content 
		<div class="container">
			<div class="page-header clearfix">
				<nav>
					<ul class="nav nav-pills pull-right">
					<li role="presentation" class="active"><a href="#">Home</a></li>
					<li role="presentation"><a href="http://blog.pisyek.com/create-todo-app-with-codeigniter-3-angularjs/">Tutorial</a></li>
					<li role="presentation"><a href="http://pisyek.com/about">About</a></li>
					<li role="presentation"><a href="http://pisyek.com/contact">Contact</a></li>
				</ul>
				</nav>
				<h3 class="text-muted">Tires Hunt App</h3>
			</div>
			
			<p class="lead">This is a demo page. Click tutorial link above for the complete tutorial.</p>
			<p>Please drop comment or <a href="http://pisyek.com/contact">contact me</a> if you have queries on this.</p>
			
			<div style="text-align:center">
				<h1>Todo App</h1>
				
				<h2 data-ng-show="tasks.length == 0">No task yet!</h2>
			</div>
			
			<div class="col-md-12" data-ng-show="tasks.length > 0">
				<table class="table table-hover">
					<thead>
						<tr>
							<th style="width:50px">#</th>
							<th>Title</th>
							<th style="width:80px; text-align:center">Complete</th>
							<th style="width:80px; text-align:center">Action</th>
						</tr>
					</thead>
					<tbody>
						<tr data-ng-repeat="task in tasks track by $index">
							<td>{{ $index + 1 }}</td>
							<td><input class="todo" type="text" ng-model-options="{ updateOn: 'blur' }" ng-change="updateTask(tasks[$index])" ng-model="tasks[$index].title"></td>
							<td style="text-align:center"><input class="todo" type="checkbox" ng-change="updateTask(tasks[$index])"ng-model="tasks[$index].status" ng-true-value="'1'" ng-false-value="'0'"></td>
							<td style="text-align:center"><a class="btn btn-xs btn-default" ng-click="deleteTask(tasks[$index])"><span class="glyphicon glyphicon-trash"></span></a></td>
						</tr>
					</tbody>
				</table>
			</div>
	
			<form style="form-inline" role="form" ng-submit="addTask()">
				<div class="form-group col-md-10">
					<input type="text" class="form-control" name="title" ng-model="taskTitle" placeholder="Enter task title" required>
				</div>
				<button type="submit" class="btn btn-default">Add task</button>
			</form>
			
		</div>
		-->
		<footer class="footer">
			<div class="container">
			<p class="text-muted">&copy; <?php echo date('Y')?> <a href="#">Nathan Fan</a> <span class="pull-right">Powered by <a href="#" target="_blank" rel="nofollow,noindex">CTKPRO</a></span></p>
			</div>
		</footer>


	</body>
</html>
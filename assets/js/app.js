//var todoApp = angular.module('todoApp', []);
var tiresApp = angular.module('tiresApp', ['ngAnimate', 'ui.bootstrap']);

angular.module('tiresApp').controller('TiresCtrl', function ($scope, $http) {

	$http.get('api/vehicleYears').success(function(data){
		$scope.selectedYear = {'name' : 'Year'};
		$scope.selectedMake = {'name' : 'Make'};
		$scope.selectedModel = {'name' : 'Model'};
		$scope.selectedBody = {'name' : 'Body'};
		$scope.selectedOption = {'name' : 'Option'};

		$scope.optionYears = [];
		$scope.optionMakes = [];
		$scope.optionModels = [];
		$scope.optionBodies = [];
		$scope.optionOptions = [];

		$scope.disabledMake = true;
		$scope.disabledModel = true;
		$scope.disabledBody = true;
		$scope.disabledOption = true;

		$scope.vehicleYears = data;

		for(var i in $scope.vehicleYears) {
			$scope.optionYears.push({'name' : $scope.vehicleYears[i], 'isSelected' : false});
		}
	}).error(function(data){
		$scope.vehicleYears = data;
	});
	
	$scope.refresh = function(){
		$http.get('api/vehicleYears').success(function(data){
			// $scope.selectedYear = {'name' : 'Year'};
			// $scope.selectedMake = {'name' : 'Make'};
			// $scope.selectedModel = {'name' : 'Model'};
			// $scope.selectedBody = {'name' : 'Body'};
			// $scope.selectedOption = {'name' : 'Option'};

			// $scope.optionYears = [];
			// $scope.optionMakes = [];
			// $scope.optionModels = [];
			// $scope.optionBodies = [];
			// $scope.optionOptions = [];

			// $scope.disabledMake = true;
			// $scope.disabledModel = true;
			// $scope.disabledBody = true;
			// $scope.disabledOption = true;

			$scope.vehicleYears = data;
			
			$scope.optionYears = [];
			for(var i in $scope.vehicleYears) {
				$scope.optionYears.push({'name' : $scope.vehicleYears[i], 'isSelected' : false});
			}

		}).error(function(data){
			$scope.vehicleYears = data;
		});
	}

	$scope.addTask = function(){
		var newTask = {title: $scope.taskTitle};
		$http.post('api/tasks', newTask).success(function(data){
			$scope.refresh();
			$scope.taskTitle = '';
		}).error(function(data){
			alert(data.error);
		});
	}
	
	$scope.deleteTask = function(task){
		$http.delete('api/tasks/' + task.id);
		$scope.tasks.splice($scope.tasks.indexOf(task),1);
	}
	
	$scope.updateTask = function(task){
		$http.put('api/tasks', task).error(function(data){
			alert(data.error);
		});
		$scope.refresh();
	}
	
});


angular.module('tiresApp').controller('TabsCtrl', function ($scope, $window) {
  $scope.tabs = [
    { title:'By Vehicle', content:'assets/layout/vehicle.html' },
    { title:'By Size', content:'assets/layout/vehicle.html', disabled: true }
  ];

  $scope.alertMe = function() {
    setTimeout(function() {
      $window.alert('You\'ve selected the alert tab!');
    });
  };
});

angular.module('tiresApp').controller('DropdownCtrl', function ($scope, $http, $log) {

	$scope.selectYear = function($optionYear) {
   		$scope.selectedYear.name = $optionYear.name;
		$http.get('api/vehicleMakes?Year=' + $scope.selectedYear.name ).success(function(data){
			$log.log(data);
			$scope.vehicleMakes = data;
			$scope.disabledModel = true;
			$scope.disabledOption = true;
			$scope.disabledBody = true;
			$scope.disabledMake = false;
			for(var i in $scope.vehicleMakes) {
				$log.log($scope.vehicleMakes[i].Attribute);
				$scope.optionMakes.push({'name' : $scope.vehicleMakes[i].Attribute, 'isSelected' : false});
			}
		}).error(function(data){
			$scope.vehicleMakes = data;
		});
  	}

  	$scope.selectMake = function($optionMake) {
   		$scope.selectedMake.name = $optionMake.name;
		$http.get('api/vehicleModels?Year=' + $scope.selectedYear.name + '&Make=' + $scope.selectedMake.name).success(function(data){
			$log.log(data);
			$scope.vehicleModels = data;
			$scope.disabledBody = true;
			$scope.disabledOption = true;
			$scope.disabledModel = false;
			for(var i in $scope.vehicleModels) {
				$log.log($scope.vehicleModels[i].Attribute);
				$scope.optionModels.push({'name' : $scope.vehicleModels[i].Attribute, 'isSelected' : false});
			}
		}).error(function(data){
			$scope.vehicleModels = data;
		});
  	}

  	$scope.selectModel = function($optionModel) {
  		$log.log($scope.selectedModel);
  		$log.log($optionModel);
   		$scope.selectedModel.name = $optionModel.name;
		$http.get('api/vehicleBodies?Year=' + $scope.selectedYear.name + '&Make=' + $scope.selectedMake.name + '&Model=' + $scope.selectedModel.name).success(function(data){
			$log.log(data);
			$scope.vehicleBodies = data;
			$scope.disabledOption = true;
			$scope.disabledBody = false;
			for(var i in $scope.vehicleBodies) {
				$log.log($scope.vehicleBodies[i].Attribute);
				$scope.optionBodies.push({'name' : $scope.vehicleBodies[i].Attribute, 'isSelected' : false});
			}
		}).error(function(data){
			$scope.vehicleBodies = data;
		});
  	}

  	$scope.selectBody = function($optionBody) {
   		$scope.selectedBody.name = $optionBody.name;
		$http.get('api/vehicleOptions?Year=' + $scope.selectedYear.name + '&Make=' + $scope.selectedMake.name + '&Model=' + $scope.selectedModel.name + '&Body=' + $scope.selectedBody.name).success(function(data){
			$log.log(data);
			$scope.vehicleOptions = data;
			$scope.disabledOption = false;
			for(var i in $scope.vehicleOptions) {
				$log.log($scope.vehicleOptions[i].Attribute);
				$scope.optionOptions.push({'name' : $scope.vehicleOptions[i].Attribute, 'isSelected' : false});
			}
		}).error(function(data){
			$scope.vehicleOptions = data;
		});
  	}

  	$scope.selectOption = function($optionOption) {
   		$scope.selectedOption.name = $optionOption.name;
		$http.get('api/VehicleTires?Year=' + $scope.selectedYear.name + '&Make=' + $scope.selectedMake.name + '&Model=' + $scope.selectedModel.name + '&Body=' + $scope.selectedBody.name + '&Option=' + $scope.selectedOption.name).success(function(data){
			$log.log(data);
			$scope.vehicleTires = data;
			for(var i in $scope.vehicleTires) {
				//$log.log($scope.vehicleTires[i].Attribute);
				//$scope.optionMakes.push({'name' : $scope.vehicleModels[i].Attribute, 'isSelected' : false});
			}
		}).error(function(data){
			$scope.vehicleTires = data;
		});
  	}


});



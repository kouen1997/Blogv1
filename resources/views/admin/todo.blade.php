@extends('layouts.admin')

@section('title', 'To do')

@section('header_scripts')
<link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
<style type="text/css">
    .card{
        background: #fff;
    }
    .card .card-body{
        padding: 50px;
    }
</style>
@stop

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" ng-app="TodoApp" ng-controller="TodoCtrl as frm">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            To do
            <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-wrench"></i> Manage</a></li>
            <li class="active">To do</li>
        </ol>
    </section>
    <section class="content">

        <h1>Todo List</h1>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <label for="task">Task:</label>
                        <input type="text" class="form-control" name="task" ng-model="frm.task" placeholder="Add Task" style="font-weight: normal;" ng-enter="frm.submitTask()" required>
                    </div>
                    <div class="col-md-6">
                        <div class="col-md-6">
                            <label for="task">Search User:</label>
                            <input type="text" class="form-control" name="search" ng-model="frm.search.user" placeholder="Search" style="font-weight: normal;">
                        </div>
                        <div class="col-md-6">
                            <label for="task">Search Task:</label>
                            <input type="text" class="form-control" name="search" ng-model="frm.search.task" placeholder="Search" style="font-weight: normal;">
                        </div>
                    </div>
                </div>
                <br>
                <br>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                              <th scope="col">#</th>
                              <th scope="col">Checked</th>
                              <th scope="col">Name</th>
                              <th scope="col">Task</th>
                              <th scope="col">Status</th>
                              <th scope="col">Date</th>
                              <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr ng-repeat="data in datas | filter:frm.search.user | filter:frm.search.task">
                                <td align="center">@{{ $index+1 }}</td>
                                <td align="center">
                                    <span ng-if="data.status == 0">
                                        <input type="checkbox" name="checked" ng-click="frm.checkedTask(1, data.id)">
                                    </span>

                                    <span ng-if="data.status == 1">
                                        <input type="checkbox" name="checked" ng-click="frm.checkedTask(0, data.id)" checked>
                                    </span>
                                </td>
                                <td>@{{ data.user.name }}</td>
                                <td id="edit-@{{ data.id }}" ng-enter="frm.editContent(data.id)" contenteditable="true">@{{ data.title }}</td>
                                <td>
                                    <span ng-if="data.status == 0" class="label label-warning">Pending</span>
                                    <span ng-if="data.status == 1" class="label label-success">Done</span>
                                </td>
                                <td>@{{ data.created_at | date:'medium' }}</td>
                                <td><span class="btn btn-sm btn-danger" ng-click="frm.deleteTask(data.id)"><i class="fa fa-trash"></i> Delete</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@section('footer_scripts')

<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

<script src="{{ URL::asset('assets/plugins/angular/angular.min.js')  }}"></script>
<script src="{{ URL::asset('assets/plugins/angular/angular.filter.min.js')  }}"></script>
<script src="{{ URL::asset('assets/plugins/angular/angular-animate.min.js')  }}"></script>
<script src="{{ URL::asset('assets/plugins/angular/angular-aria.min.js')  }}"></script>
<script src="{{ URL::asset('assets/plugins/angular/angular-messages.min.js')  }}"></script>
<script src="{{ URL::asset('assets/plugins/angular/angular-material.min.js')  }}"></script>
<script src="{{ URL::asset('assets/plugins/angular/angular-sanitize.js')  }}"></script>

<script type="text/javascript">
(function () {
    var TodoApp = angular.module('TodoApp', ['angular.filter']);
    TodoApp.controller('TodoCtrl', function ($scope, $http, $sce, $compile) {

        var vm = this;

        getdata();
        function getdata() {

            $http.get('/todo-data').success(function (response) {
                console.log(response.data);
                $scope.datas = response.data;
            });
        }
        vm.submitTask = function(){

            var task = vm.task;

            if(task.length > 0){

                $http({
                    method: 'POST',
                    url: '/add-todo',
                    data: JSON.stringify({
                            task: task
                        })
                }).then(function successCallback(response) {
                   
                    if(response.data.status == 'success'){

                        console.log(vm.task);
                        toastr.success(response.data.message);
                        vm.task = '';

                        getdata();
                    
                    }else{

                        toastr.error(response.data.message);

                    }

                }, function errorCallback(response) {

                    toastr.error(response.data.message);

                });

            }else{
                toastr.error('task is empty');
            }

        };

        vm.checkedTask = function(checked_id, task_id){

            $http({
                method: 'POST',
                url: '/checked-todo/'+task_id,
                data: JSON.stringify({
                        checked_id: checked_id
                    })
            }).then(function successCallback(response) {
               
                if(response.data.status == 'success'){
                    
                    toastr.success(response.data.message);

                    getdata();

                }else{

                    toastr.error(response.data.message);

                };

            }, function errorCallback(response) {

                toastr.error(response.data.message);

            });
        };

        vm.deleteTask = function(task_id){

            $http({
                method: 'POST',
                url: '/delete-todo/'+task_id
            }).then(function successCallback(response) {
               
                if(response.data.status == 'success'){
                    
                    toastr.success(response.data.message);

                    getdata();

                }else{

                    toastr.error(response.data.message);

                }

            }, function errorCallback(response) {

                toastr.error(response.data.message);

            });
        };

        vm.editContent = function(task_id){

            document.getElementById('edit-'+task_id).contentEditable = false;

            var currentRow = $('#edit-'+task_id).closest("tr");

            var task = currentRow.find("td:eq(3)").text();

            $http({
                method: 'POST',
                url: '/edit-todo/'+task_id,
                data: JSON.stringify({
                        task: task
                    })
            }).then(function successCallback(response) {
               
                if(response.data.status == 'success'){
                    
                    document.getElementById('edit-'+task_id).contentEditable = true;
                    toastr.success(response.data.message);

                    getdata();

                }else{

                    toastr.error(response.data.message);

                };

            }, function errorCallback(response) {

                toastr.error(response.data.message);

            });
        };

    });

    TodoApp.directive('ngEnter', function () {
        return function (scope, element, attrs) {
            element.bind("keydown keypress", function (event) {
                if (event.which === 13) {
                    scope.$apply(function () {
                      scope.$eval(attrs.ngEnter);
                    });

                    event.preventDefault();
                }
            });
        };
    });

})();
</script>
@stop


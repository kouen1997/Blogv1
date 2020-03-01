@extends('layouts.admin')

@section('title', 'Blog')

@section('header_scripts')
<link href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css">

<link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
@stop

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" ng-app="BlogApp" ng-controller="BlogCtrl as frm">
    <section class="content-header">
        <h1>
            Blog
            <small>v1</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-wrench"></i> Manage</a></li>
            <li class="active">Blog</li>
        </ol>
    </section>

    <section class="content">
    	<div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->
              	<div class="box box-warning" style="font-weight: normal;">
                	<div class="box-header with-border">
                  		<h3 class="box-title">Manage Blog 
                  		</h3>

                  		<a href="{{ url('/admin/add/blog') }}" class="btn btn-sm btn-warning pull-right"><i class="fa fa-plus"></i> Add Blog</a>
                    </div>
                    <div class="box-body">
                    	@if(session('success'))
                            <div class="alert alert-success">
                                {!! session('success') !!}
                            </div>
                        @endif
                        @if(session('danger'))
                            <div class="alert alert-danger">
                                {!! session('danger') !!}
                            </div>
                        @endif
                        @if($errors->any())
                            <div class="alert alert-danger">
                                @foreach($errors->all() as $error)
                                    {{ $error }}<br>
                                @endforeach
                            </div>
                        @endif
				        <div class="table-responsive">
	                        <div id="loading">
	                            <h3 class="text-center"><i class="fa fa-spinner fa-spin"></i> Please wait...</h3>
	                        </div>
	                        <table id="content-table" class="display table" style="width: 100%; cellspacing: 0;">
	                            <thead>
	                                <tr>
	                                    <th>#</th>
	                                    <th>Title</th>
	                                    <th>Category</th>
	                                    <th>Views</th>
	                                    <th>Created</th>
	                                    <th colspan="4">Action</th>
	                                </tr>
	                            </thead>
	                        </table>
	                    </div>
					</div>
				</div>
			</div>
		</div>
    </section>

    <div class="modal fade" id="deleteBlogModal" tabindex="-1" role="dialog" aria-labelledby="deleteBlog" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
              <form class="edit-blog-form" name="deleteBlogFrm" ng-submit="frm.submitDeleteBlog()">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <h5 class="modal-title" style="font-size: 15px;"><i class="fa fa-times-circle"></i> Delete Job</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top:-25px;">
                          <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">

                            Are you sure you want to delete this blog?

                    </div>
                    <div class="modal-footer">
                        <input type="hidden" id="blog_id" name="blog_id" value="" />
                        <button type="button" class="btn btn-sm btn-default pl-5 pr-5" data-dismiss="modal"> Cancel </button>
                        <button type="submit" id="delete_blog_btn" class="btn btn-sm btn-primary pl-5 pr-5">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer_scripts')

<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

<script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>

<script src="{{ URL::asset('assets/plugins/angular/angular.min.js')  }}"></script>
<script src="{{ URL::asset('assets/plugins/angular/angular.filter.min.js')  }}"></script>
<script src="{{ URL::asset('assets/plugins/angular/angular-animate.min.js')  }}"></script>
<script src="{{ URL::asset('assets/plugins/angular/angular-aria.min.js')  }}"></script>
<script src="{{ URL::asset('assets/plugins/angular/angular-messages.min.js')  }}"></script>
<script src="{{ URL::asset('assets/plugins/angular/angular-material.min.js')  }}"></script>
<script src="{{ URL::asset('assets/plugins/angular/angular-sanitize.js')  }}"></script>

<script type="text/javascript">
(function () {
    var BlogApp = angular.module('BlogApp', ['angular.filter']);
    BlogApp.controller('BlogCtrl', function ($scope, $http, $sce, $compile) {

        var vm = this;

        getdata();
        function getdata() {
            $("#content-table").dataTable().fnDestroy(); 
            $('#loading').show();
            $("#content-table").hide();
                
            angular.element(document).ready( function () {

                var tbl = $('#content-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: '/blog-listing-data',
                        data: function (data) {

                            for (var i = 0, len = data.columns.length; i < len; i++) {
                                if (! data.columns[i].search.value) delete data.columns[i].search;
                                if (data.columns[i].searchable === true) delete data.columns[i].searchable;
                                if (data.columns[i].orderable === true) delete data.columns[i].orderable;
                                if (data.columns[i].data === data.columns[i].name) delete data.columns[i].name;
                            }
                            delete data.search.regex;
                        }
                    },
                    lengthChange: false,
                    info: false,
                    autoWidth: false,
                    columnDefs: [
                        {
                            render: function (data, type, full, meta) {
                                return "<div>" + data + "</div>";
                            },
                            targets: [0]
                        }
                     ],
                    columns: [
                        {data: 'DT_RowIndex', name: 'id', orderable: true, searchable: false},
                        {data: 'title', name: 'title', orderable: false, searchable: true},
                        {data: 'category', name: 'category', orderable: true, searchable: true},
                        {data: 'views', name: 'views', orderable: false, searchable: false},
                        {data: 'date', name: 'date', orderable: true, searchable: false},
                        {data: 'action', name: 'action', orderable: false, searchable: false},
                    ],
                    "createdRow": function (row, data, index) {
                        $compile(row)($scope);
                    },
                    order: [[1, 'desc']],
                    "initComplete": function(settings, json) { 
                           $('#loading').delay( 300 ).hide(); 
                           $("#content-table").delay( 300 ).show(); 
                    } 
                });

            });
        }

        vm.deleteBlog = function(blog_id){

            $('#deleteBlogModal').appendTo("body").modal('show');
            $(".modal-footer #blog_id").val(blog_id);
        };

        vm.submitDeleteBlog = function(){

            $('#delete_blog_btn').attr('disabled', true).append(' <i class="fa fa-spinner fa-pulse "></i>');

            var blog_id = document.getElementById("blog_id").value;

            $http({
                method: 'POST',
                url: '/blog/'+blog_id+'/delete'
            }).then(function successCallback(response) {
                
                if(response.data.status == 'success'){

                    toastr.success(response.data.message);

                    $('#delete_blog_btn').attr('disabled', false).html('Delete'); 
                    $('#deleteBlogModal').appendTo("body").modal('hide');

                    getdata();
                }

            }, function errorCallback(response) {

                toastr.error(response.data.message);
                $('#delete_blog_btn').attr('disabled', false).html('Delete');
                
            });
        };

     });
})();
</script>
@stop


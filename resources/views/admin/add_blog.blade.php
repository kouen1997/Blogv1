@extends('layouts.admin')

@section('title', 'Add Blog')

@section('header_scripts')

@stop

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Blog
            <small>v1</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-wrench"></i> Manage</a></li>
            <li>Blog</li>
            <li class="active">Add</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->
                <div class="box box-warning" style="font-weight: normal;">
                    <div class="box-header with-border">
                        <h3 class="box-title">Add Blog 
                        </h3>
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
                        <form method="post" action="{{ url('/admin/add/blog') }}" enctype="multipart/form-data">
                            {!! csrf_field() !!}
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" name="title" class="form-control" placeholder="Title" required value="{{ old('title') }}">
                            </div>
                            <div class="form-group">
                                <label for="title">Category</label>
                                <select name="category" class="form-control" required>
                                    <option value="BLOG" @if(old('category') == "BLOG") selected @endif>Blog</option>
                                    <option value="NEWS" @if(old('category') == "NEWS") selected @endif>News</option>
                                    <option value="TECHNOLOGY" @if(old('category') == "TECHNOLOGY") selected @endif>Technology</option>
                                    <option value="LIFESTYLE" @if(old('category') == "LIFESTYLE") selected @endif>Lifestyle</option>
                                    <option value="LIVELYHOOD" @if(old('category') == "LIVELYHOOD") selected @endif>Livelyhood</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="title">Image</label>
                                <input type="file" name="image" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="title">Content</label><small style="color:red;"> *Must contain 100 characters</small>
                                <textarea id="editor" class="form-control" name="content" placeholder="Write Post" rows="10" required>{{ old('content') }}</textarea>
                            </div>
                            <div class="form-group pull-right">
                                <button type="submit" id="create_blog_btn" class="btn btn-warning btn-md-2">Post</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@section('footer_scripts')

<script type="text/javascript">
    $(function () {
        var editor = CKEDITOR.replace('editor',{
            height: '500px',
        });

        $(document).ready(function() {
           $('#create_blog_btn').attr('disabled', true);
        });

        editor.on('change', function(evt) {
            // getData() returns CKEditor's HTML content.
            if(evt.editor.getData().length > 100){

              $('#create_blog_btn').attr('disabled', false).html('Post')

            }else{

              $('#create_blog_btn').attr('disabled', true);
            }

        });
    });
</script>
@stop


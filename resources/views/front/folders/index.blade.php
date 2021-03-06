@extends('layouts.front')

@section('content')
<div class="container">     
    <div class="panel panel-primary">
        <div class="panel-body">
            <div class="row">
                <div class="col-md-4">
                    <h3>Folder List</h3>
                    <ul id="tree1">
                        @foreach($categories as $category)
                        <li>
                            {{ $category->name }}
                            @if($category->children)
                                <?php
                                    $files = $category->files;
                                    $childrenData = $category->children;
                                    $merged = $childrenData;
                                    if ($files) {
                                        $merged = $childrenData->merge($files);
                                    }
                                ?>
                                @include('manageChild',['childs' => $merged])
                            @endif
                        </li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-md-8">
                    <h3>Add New Folder</h3>
                    <div class="card">
                        <div class="card-header">
                            Folder {{ $folder->name }}
                        </div>

                        <div class="card-body">
                            @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                            @endif

                            <div class="form-group">
                                <a href="{{ route('folders.create') }}?parent_id={{ $folder->id }}" class="btn btn-success">Create a new folder</a>
                                <a href="{{ route('folders.upload') }}?folder_id={{ $folder->id }}" class="btn btn-primary">Upload images</a>
                            </div>

                            <div class="row">
                                @foreach ($folder->children as $folderData)
                                <div class="col-lg-2 col-md-3 col-sm-4 mb-3">
                                    <div class="card">
                                        <a href="{{ route('folders.show', [$folderData]) }}">
                                            <img class="card-img-top" src="{{ $folderData->thumbnail ? $folderData->thumbnail->thumbnail : url('/images/empty-folder.png') }}" alt="{{ $folderData->name }}">
                                        </a>
                                        <div class="card-footer text-center">
                                            <a href="{{ route('folders.show', [$folderData]) }}">
                                                {{ $folderData->name }}
                                            </a>
                                        </div>
                                        <div class="form-group" style="margin-left: 15px;">
                                            <a href="{{url('/delete-folder/'.$folderData->id)}}" class="btn btn-primary">
                                                Delete
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @foreach ($folder->files as $file)
                                @if($file->model_id == 1)
                                <div class="col-lg-2 col-md-3 col-sm-4 mb-3">
                                    <div class="card">
                                        <a href="{{ $file->getUrl() }}" target="_blank">
                                            <img class="card-img-top" src="{{ $file->thumbnail ? $file->thumbnail : url('/images/file-thumbnail.png') }}" alt="{{ $file->name }}">
                                        </a>
                                        <div class="card-footer text-center">
                                            <a href="{{ $file->getUrl() }}" target="_blank">
                                                {{ $file->file_name }}
                                            </a>
                                        </div>
                                        <div class="form-group" style="margin-left: 15px;">
                                            <a href="{{url('/delete-file/'.$file->id)}}" class="btn btn-primary">
                                                Delete
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                @else
                                @endif
                                @endforeach
                            </div>

                            <div class="form-group">
                                @if ($folder->parent)
                                <a href="{{ route('folders.show', [$folder->parent]) }}" class="btn btn-primary">
                                    Back to folder {{ $folder->parent->name }}
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('scripts')
<script src="{{ asset('js/treeview.js') }}"></script>
@endsection

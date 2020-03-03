@extends('layouts.app')

@section('content')
    <form action="{{ route('super_agent/upload_csv') }}" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <input type="file" name="file" accept="text/csv">

            <button type="submit" class="btn btn-success">Upload</button>
        </div>
    </form>
@endsection
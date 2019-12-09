@extends('layouts.app')

@push('styles')
    <link href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css" rel="stylesheet">
@endpush

@section('content')
    <table id="tblPlayers" class="table table-bordered table-hover">
        <thead>
            <th>No</th>
            <th>Email</th>
            <th>Full Name</th>
            <th>Phone Number</th>
            <th>Actions</th>
        </thead>
    </table>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.3.1.js" ></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" defer></script>

    <script>
        $(function () {
            $('#tblPlayers').DataTable({
                'ajax' : '{{ route('players/list') }}',
                'columns' : [
                    { data : 'id' },
                    { data : 'Email' },
                    { data : 'FullName' },
                    { data : 'PhoneNum' },
                    { data : 'actions' },
                ],
                'processing' : true,
                'serverSide': true,
                'paging' : true,
                'searching' : true,
                'ordering' : true,
                'info' : true,
                'autoWidth' : true,
            });
        });
    </script>
@endpush
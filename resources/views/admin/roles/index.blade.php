@extends('admin.layouts.app')
@section('content')
    <div class="col-lg-12 col-md-12 mb-4">
        <!-- order -->
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="text-primary">Vəzifələr</h3>
                <a href="{{ route('roles.create') }}">
                    <button class="btn btn-success">Yeni vəzifə</button>
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="local-broadcasts-table" class="display table table-striped" style="width:100%">
                        <thead>
                        <tr>
                            <th>№</th>
                            <th>Vəzifə</th>
                            <th>Əməliyyatlar</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($roles as $role)
                            <tr class="font-weight-bold">
                                <td>{{ $role->id }}</td>
                                <td>{{ $role->name }}</td>
                                <td>
                                    <a href="{{ route('roles.edit', $role->id) }}">
                                        <button class="btn btn-warning">
                                            <span>
                                                <i class="nav-icon i-Pen-2 font-weight-bold"></i>
                                            </span>
                                        </button>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('admin.layouts.app')
@section('content')
    <div class="col-lg-12 col-md-12 mb-4">
        <!-- order -->
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="text-primary">Loqlar</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="local-broadcasts-table" class="display table table-striped" style="width:100%">
                        <thead>
                        <tr>
                            <th>№</th>
                            <th>Tip</th>
                            <th>Açıqlama</th>
                            <th>Tarix</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($logs as $log)
                            <tr class="font-weight-bold">
                                <td>{{ $log->id }}</td>
                                <td>
                                    @if($log->type  == 'Bildiriş')
                                        <i class="nav-icon i-Danger text-info"></i>
                                        <div class="triangle"></div>
                                    @else
                                        <i class="nav-icon i-Danger-2 text-danger"></i>
                                        <div class="triangle"></div>
                                    @endif
                                </td>
                                <td>
                                    <strong>{{$log->content}}</strong>
                                </td>
                                <td>
                                    {{\Carbon\Carbon::parse($log->created_at)->format('d.m.Y (H:i)')}}
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

@extends('admin.layouts.app')
@section('content')
    <div class="row mb-4">
        <div class="col-md-12 mb-4">

            <div class="d-flex justify-content-between align-items-center">
                <h3>İstiqamətlər</h3>

{{--                <a href="{{route('directions.create')}}">--}}
{{--                    <button class="btn btn-success">--}}
{{--                                <span class="me-2">--}}
{{--                                    <i class="nav-icon i-Add-File"></i>--}}
{{--                                </span>--}}
{{--                        Yeni istiqamət--}}
{{--                    </button>--}}
{{--                </a>--}}
            </div>
            <div class="table-responsive">
                <table id="directions-table" class="display table table-striped" style="width:100%">
                    <thead>
                    <tr>
                        <th>№</th>
                        <th>İstiqamət</th>
                        <th>Status</th>
                        <th>Əməliyyatlar</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($directions as $item)
                        <tr class="font-weight-bold">
                            <td>{{ $item->id }}</td>
                            <td>{{$item->name}}</td>
                            <td>
                                <button class="btn btn-sm btn-{{$item->status == 1 ? 'success' : 'danger'}}">
                                    {{$item->status == 1 ? 'Aktiv' : 'Deaktiv'}}
                                </button>
                            </td>
                            <td>
                                <a href="{{ route('directions.edit', $item->id ) }}" class="text-success mr-2">
                                    <i class="nav-icon i-Pen-2 font-weight-bold"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function () {
            $('#directions-table').DataTable();
        })

        @if (session('store_success'))
        const storeSuccess = "{{ session('store_success') }}";
        const SuccessAlert = Swal.fire({
            title: "Uğurlu!",
            text: storeSuccess,
            icon: "success"
        })
        SuccessAlert.fire();

        @php session()->forget('store_success') @endphp
        @endif


        @if (session('store_error'))
        const storeError = "{{ session('store_error') }}";
        const ErrorAlert = Swal.fire({
            title: "Xəta!",
            text: storeError,
            icon: "error"
        })
        ErrorAlert.fire();

        @php session()->forget('store_error') @endphp
        @endif
    </script>
@endsection

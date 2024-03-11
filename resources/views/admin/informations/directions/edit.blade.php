@extends('admin.layouts.app')
@section('content')

    <div class="row mb-4">
        <div class="col-md-12 mb-4">

            <div class="d-flex justify-content-between align-items-center">
                <h3>{{ $direction->name }}</h3>
                <a href="{{route('frequencies.index')}}">
                    <button class="btn btn-danger">
                                <span class="me-2">
                                    <i class="nav-icon i-Arrow-Back-2"></i>
                                </span>
                        İstiqamətlər
                    </button>
                </a>
            </div>
            <hr>
            <form method="POST" action="{{route('program-names.update', $direction)}}">
                @csrf
                @method('PUT')
                @method('PUT')
                <div class="row">

                    <div class="col-md-6 form-group mb-3">
                        <div class="select_label ui sub header ">İstiqamət</div>
                        <input type="text" name="name" value="{{$direction->name}}" id="" class="form-control">
                        @if($errors->has('name'))
                            <span class="text-danger">{{ $errors->first('name') }}</span>
                        @endif
                    </div>

                    <div class="col-md-6 form-group mb-3">
                        <div class="select_label ui sub header ">Status</div>
                        <select id="status" name="status"
                                class="form-control ui fluid search dropdown create_form_dropdown">
                            <option value="1" {{ $direction->status == '1' ?  'selected' : '' }}>Aktiv</option>
                            <option value="0" {{ $direction->status == '0' ?  'selected' : '' }}>Deaktiv</option>
                        </select>

                        @if($errors->has('status'))
                            <span class="text-danger">{{ $errors->first('status') }}</span>
                        @endif
                    </div>

                    <div class="col-md-12 mt-4">
                        <button class="btn btn-success btn-lg">Yadda saxlayın</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
@endsection
@section('js')
    <script>

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

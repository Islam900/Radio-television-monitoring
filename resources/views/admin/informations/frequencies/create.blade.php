@extends('admin.layouts.app')
@section('content')

    <div class="row mb-4">
        <div class="col-md-12 mb-4">

            <div class="d-flex justify-content-between align-items-center">
                <h3>Yeni tezlik</h3>
                <a href="{{route('frequencies.index')}}">
                    <button class="btn btn-danger">
                                <span class="me-2">
                                    <i class="nav-icon i-Arrow-Back-2"></i>
                                </span>
                        Tezliklər
                    </button>
                </a>
            </div>
            <hr>
            <form method="POST" action="{{route('frequencies.store')}}">
                @csrf
                <div class="row">

                    <div class="col-md-2 form-group mb-3">
                        <div class="select_label ui sub header ">Məntəqə</div>
                        <select id="status" name="stations_id"
                                class="form-control ui fluid search dropdown create_form_dropdown">
                            @foreach($stations as $item)
                                <option value="{{ $item->id }}">{{ $item->station_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2 form-group mb-3">
                        <div class="select_label ui sub header ">Tezlik (kanal)</div>
                        <input type="number" step="any" name="value" id="" class="form-control">
                    </div>

                    <div class="col-md-2 form-group mb-3">
                        <div class="select_label ui sub header ">Proqram adı</div>
                        <select id="status" name="program_names_id"
                                class="form-control ui fluid search dropdown create_form_dropdown">
                            @foreach($program_names as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2 form-group mb-3">
                        <div class="select_label ui sub header ">Proqram dili</div>
                        <select id="status" name="program_languages_id"
                                class="form-control ui fluid search dropdown create_form_dropdown">
                            @foreach($program_languages as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2 form-group mb-3">
                        <div class="select_label ui sub header ">Proqram yeri</div>
                        <select id="status" name="program_locations_id"
                                class="form-control ui fluid search dropdown create_form_dropdown">
                            @foreach($program_locations as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2 form-group mb-3">
                        <div class="select_label ui sub header ">Polyarizasiya</div>
                        <select id="status" name="polarizations_id"
                                class="form-control ui fluid search dropdown create_form_dropdown">
                            @foreach($polarizations as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2 form-group mb-3">
                        <div class="select_label ui sub header ">Status</div>
                        <select id="status" name="status"
                                class="form-control ui fluid search dropdown create_form_dropdown">
                            <option value="1" {{ old('status') == '1' ?  'selected' : '' }}>Aktiv</option>
                            <option value="0" {{ old('status') == '0' ?  'selected' : '' }}>Deaktiv</option>
                        </select>

                        @if($errors->has('status'))
                            <span class="text-danger">{{ $errors->first('status') }}</span>
                        @endif
                    </div>

                    <div class="col-md-12 mt-4">
                        <button class="btn btn-success btn-lg">Daxil edin</button>
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

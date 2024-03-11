@extends('layouts.app')
@section('content')

    <div class="row mb-4">
        <div class="col-md-12 mb-4">

            <div class="d-flex justify-content-between align-items-center">
                <h3>Yeni kənar hesabat</h3>
                <a href="{{route('foreign-broadcasts.index')}}">
                    <button class="btn btn-danger">
                                <span class="me-2">
                                    <i class="nav-icon i-Arrow-Back-2"></i>
                                </span>
                        Kənar hesabatlar
                    </button>
                </a>
            </div>
            <hr>
            <form method="POST" action="{{route('foreign-broadcasts.store')}}" class="store-foreign-report-form">
                @csrf
                <div class="row">
                    <div class="col-md-4 form-group mb-3">
                        <div class="select_label ui sub header ">Tezlik (kanal)</div>
                        <select id="frequency_select" name="frequencies_id" class="form-control ui fluid search dropdown create_form_dropdown">
                            <option value="">Tezliyi seçin və ya daxil edin</option>
                            @forelse($frequencies as $item)
                                <option value="{{$item->value}}" {{ old('frequencies_id')==$item->id ? 'selected' : '' }}>{{$item->value}}</option>
                            @empty
                                <option disabled selected>Məlumat yoxdur</option>
                            @endforelse

                        </select>
                        <span class="text-danger" id="frequencies_idError"></span>
                    </div>

                    <div class="col-md-4 form-group mb-3">
                        <div class="select_label ui sub header">Proqram adı</div>
                        <select id="program_name_select" disabled name="program_names_id"
                                class="form-control ui fluid search dropdown create_form_dropdown">
                            <option value="">Proqram adı seçin</option>
                        </select>
                        <span class="text-danger" id="program_names_idError"></span>
                    </div>

                    <div class="col-md-4 form-group mb-3">
                        <div class="select_label ui sub header">İstiqamət</div>
                        <select id="direction_select" disabled name="directions_id"
                                class="form-control ui fluid search dropdown create_form_dropdown create_form_dropdown">
                        </select>
                        <span class="text-danger" id="directions_idError"></span>
                    </div>

                    <div class="col-md-4 form-group mb-3">
                        <div class="select_label ui sub header ">Proqram dili</div>
                        <select id="program_lang" disabled name="program_languages_id"
                                class="form-control ui fluid search dropdown create_form_dropdown">
                        </select>
                        <span class="text-danger" id="program_langError"></span>
                    </div>

                    <div class="col-md-4 form-group mb-3">
                        <div class="select_label ui sub header ">Proqramın yayımlandığı yer</div>
                        <select id="program_location" disabled name="program_locations_id"
                                class="form-control ui fluid search dropdown create_form_dropdown">
                        </select>
                        <span class="text-danger" id="program_langError"></span>
                    </div>


                    <div class="col-md-4 form-group mb-3">
                        <div class="select_label ui sub header ">Elektromaqnit sahə gərginliyinin səviyyəsi (dBμV/m)
                        </div>
                        <div class="ui input">
                            <input id="emfs_level" disabled name="emfs_level_in" value="{{old('emfs_level_in')}}"
                                   step=any type="number" placeholder="">
                            <span class="text-danger error_message_input" id="emfs_levelError"></span>
                            <input id="emfs_level_addition" name="emfs_level_out" step=any type="number"
                                   value="{{old('emfs_level_out')}}" placeholder="" style="display: none">
                            <span class="text-danger error_message_input_additional" id="emfs_level_additionError"></span>

                        </div>

                    </div>

                    <div class="col-md-4 form-group mb-3">
                        <div class="select_label ui sub header ">Kanalın qəbul edildiyi istiqamət (azimut, dərəcə)</div>
                        <div class="ui input">
                            <input id="response_direction" value="{{old('response_direction_in')}}" disabled
                                   name="response_direction_in" type="number" placeholder="">
                            <span class="text-danger error_message_input" id="response_directionError"></span>

                            <input id="response_direction_addition" value="{{old('response_direction_in')}}"
                                   name="response_direction_out" type="number" placeholder="" style="display: none">
                            <span class="text-danger error_message_input_additional" id="response_direction_additionError"></span>
                        </div>
                    </div>

                    <div class="col-md-4 form-group mb-3">
                        <div class="select_label ui sub header ">Polyarizasiya</div>
                        <select id="polarization" disabled name="polarization"
                                class="form-control ui fluid search dropdown create_form_dropdown">
                        </select>
                        <span class="text-danger" id="polarizationError"></span>
                    </div>

                    <div class="col-md-4 form-group mb-3">
                        <div class="select_label ui sub header ">Qəbulun keyfiyyəti və interferensiya yaratması</div>

                        <div class="ui input">
                            <select id="response_quality" name="response_quality"
                                    class="form-control ui fluid search dropdown create_form_dropdown">
                                <option value="">Qəbulun keyfiyyəti və interferensiya yaratmasını seçin</option>
                                <option value="Yaxşı" {{ old('response_quality') == 'Yaxşı' ?  'selected' : '' }}>
                                    Yaxşı
                                </option>
                                <option value="Kafi" {{ old('response_quality') == 'Kafi' ?  'selected' : '' }}>Kafi
                                </option>
                                <option value="Vurulur" {{ old('response_quality') == 'Vurulur' ?  'selected' : '' }}>
                                    Vurulur
                                </option>
                            </select>
                            <span class="text-danger error_message_input" id="response_qualityError"></span>


                            <select id="response_quality_addition" name="sending_from" class="form-control ui fluid search dropdown create_form_dropdown response_quality_addition for_js" style="display: none">
                                <option value="">Qeydi seçin</option>
                                @foreach ($options as $option)
                                <option value= "{{ $option }}">{{ $option }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger error_message_input_additional" id="response_quality_additionError"></span>
                        </div>

                        <span class="text-danger error_message_input" id="response_quality_additionError"></span>
                    </div>

                    <div class="col-lg-12">
                        <label for="device">Ölçmədə istifadə olunan cihazlar</label>
                        <div class="input-right-icon row">
                            @foreach($devices as $device)
                                <div class="col-md-4 mt-2">
                                    <label class="switch switch-primary mr-3" for="{{$device}}">
                                        <span>
                                            <strong>
                                                {{$device}}
                                            </strong>
                                        </span>
                                        <input type="checkbox" name="device[{{$device}}]" value="1" id="{{$device}}">
                                        <span class="slider"></span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        <span class="text-danger error_message_input" id="deviceError"></span>
                    </div>

                    <div class="col-md-12 form-group mb-3 mt-2">
                        <label for="device">Əlavə qeyd</label>
                        <textarea class="form-control" rows="6" name="note"
                                  placeholder="Əlavə qeydi daxil edin.."></textarea>
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
        $(document).ready(function () {
            $('#frequency_select').on('change', function () {
                const frequencies_id = $(this).val();
                $.ajax({
                    url: "{{ route('get-data-by-frequency') }}",
                    method: "POST",
                    data: {
                        "_token": "{{csrf_token()}}",
                        "frequencies_id": frequencies_id
                    },
                    success: function (response) {
                        console.log(response.program_names.id);
                        var programNamesSelect = $("#program_name_select");
                        programNamesSelect.empty();
                        programNamesSelect.append($("<option>", {
                            value: response.program_names.id,
                            text: response.program_names.name
                        }));
                        programNamesSelect.attr('disabled', false);

                        var directionsSelect = $("#direction_select");
                        directionsSelect.empty();
                        directionsSelect.append($("<option>", {
                            value: response.directions.id,
                            text: response.directions.name
                        }));
                        directionsSelect.attr('disabled', false);

                        var programLanguagesSelect = $("#program_lang");
                        programLanguagesSelect.empty();
                        programLanguagesSelect.append($("<option>", {
                            value: response.program_languages.id,
                            text: response.program_languages.name
                        }));
                        programLanguagesSelect.attr('disabled', false);

                        var programLocationsSelect = $("#program_location");
                        programLocationsSelect.empty();
                        programLocationsSelect.append($("<option>", {
                            value: response.program_locations.id,
                            text: response.program_locations.name
                        }));
                        programLocationsSelect.attr('disabled', false);

                        var polarizationSelect = $("#polarization");
                        polarizationSelect.empty();
                        polarizationSelect.append($("<option>", {
                            value: response.polarizations.id,
                            text: response.polarizations.name
                        }));
                        polarizationSelect.attr('disabled', false);

                    }
                });
            });
        });

        $('.store-foreign-report-form').submit(function(e) {
            e.preventDefault();
            const form = $(this);
            var formValid = true;

            let fields = [
                { id: 'frequency_select', name: 'Tezlik', errorId: 'frequencies_idError', errorMessage: 'Zəhmət olmasa tezlik seçin' },
                { id: 'direction_select', name: 'İstiqamət', errorId: 'directions_idError', errorMessage: 'Zəhmət olmasa istiqamət seçin' },
                { id: 'program_name_select', name: 'Proqram adı', errorId: 'program_names_idError', errorMessage: 'Zəhmət olmasa proqram adını seçin' },
                { id: 'program_lang', name: 'Proqram dili', errorId: 'program_langError', errorMessage: 'Zəhmət olmasa proqram dilini seçin' },
                { id: 'program_location', name: 'Proqram yayımlandığı yer', errorId: 'program_locationError', errorMessage: 'Zəhmət olmasa proqram yayımlandığı yeri seçin' },
                { id: 'emfs_level', name: 'Elektromaqnit sahə gərginliyinin səviyyəsi', errorId: 'emfs_levelError', errorMessage: 'Zəhmət olmasa EMSG səviyyəsini daxil edin' },
                { id: 'response_direction', name: 'Kanalın qəbul edildiyi istiqamət', errorId: 'response_directionError', errorMessage: 'Zəhmət olmasa dərəcəni daxil edin' },
                { id: 'polarization', name: 'Polyarizasiya', errorId: 'polarizationError', errorMessage: 'Zəhmət olmasa polyarizasiya seçin' },
                { id: 'response_quality', name: 'Qəbulun keyfiyyəti və interferensiya yaratması', errorId: 'response_qualityError', errorMessage: 'Zəhmət olmasa qəbul keyfiyyətini' },
            ];

            if ($('#response_quality').find(":selected").val() === "Vurulur") {
                fields.push(
                    { id: 'response_direction_addition', name: 'Kanalın qəbul edildiyi istiqamət', errorId: 'response_direction_additionError', errorMessage: 'Zəhmət olmasa dərəcəni daxil edin' },
                    { id: 'response_quality_addition', name: 'Vurulur', errorId: 'response_quality_additionError', errorMessage: 'Zəhmət olmasa vurulma növü və yerini seçin' },
                    { id: 'emfs_level_addition', name: 'Elektromaqnit sahə gərginliyinin səviyyəsi', errorId: 'emfs_level_additionError', errorMessage: 'Zəhmət olmasa EMSG səviyyəsini daxil edin' }
                );
            }

            fields.forEach(function(field) {
                var value = $('#' + field.id).val().trim();
                var errorSpan = $('#' + field.errorId);

                if (!value) {
                    errorSpan.text(field.errorMessage);
                    formValid = false;
                } else {
                    errorSpan.text('');
                }
            });

            if (formValid) {
                Swal.fire({
                    title: "Məlumatların doğruluğunu təsdiq edirsinizmi ?",
                    text: "Məlumatlar göndərildikdən sonra rəhbərlik tərəfindən düzəliş üçün geri qaytarıla bilər!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Təsdiq edirəm"
                }).then((result) => {
                    if (result.isConfirmed) {
                        const formData = new FormData(this);
                        formData.append('_token', "{{ csrf_token() }}");

                        $.ajax({
                            url: form.attr('action'),
                            method: "POST",
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function(response) {
                                if(response.status == 409)
                                {
                                    Swal.fire({
                                        title: "Məlumatlar daxil edilmədi",
                                        text: response.message,
                                        icon: "info"
                                    }).then((result) => {
                                        if(result.isConfirmed) {
                                            window.location.href = response.route;
                                        }
                                    });
                                }
                                else
                                {
                                    Swal.fire({
                                        title: "Məlumatlar daxil edildi",
                                        text: response.message,
                                        icon: "success"
                                    }).then((result) => {
                                        if(result.isConfirmed) {
                                            window.location.href = response.route;
                                        }
                                    });
                                }
                            }
                        });
                    }
                });
            }
        });
    </script>
@endsection

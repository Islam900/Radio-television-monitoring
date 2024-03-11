@extends('layouts.app')
@section('content')

    <div class="row mb-4">
        <div class="col-md-12 mb-4">

            <div class="d-flex justify-content-between align-items-center">
                <h3>Hesabat məlumatları</h3>
                <a href="{{route('local-broadcasts.index')}}">
                    <button class="btn btn-danger">
                                <span class="me-2">
                                    <i class="nav-icon i-Arrow-Back-2"></i>
                                </span>
                        Yerli hesabatlar
                    </button>
                </a>
            </div>
            @if($localBroadcast->edit_reasons->count() > 0)
                @foreach($localBroadcast->edit_reasons as $key => $reason)
                    <div class="accordion pt-2 pb-4" id="accordionExample{{$key}}">
                        <div class="card ul-card__border-radius">
                            <div class="card-header ">
                                <h6 class="card-title mb-0 d-flex justify-content-between align-items-center">
                                    <a data-toggle="collapse"
                                       class="text-{{$reason->solved_status == 1 ? 'success' : 'danger'}}"
                                       href="#accordion-item-group{{$key}}">Düzəlişə göndərilmə səbəbi #{{$key+1}}</a>
                                    <strong>Tarix: {{\Carbon\Carbon::parse($reason->created_at)->format('d.m.Y')}} |
                                        Saat: {{\Carbon\Carbon::parse($reason->created_at)->format('H:i')}}</strong>
                                </h6>
                            </div>

                            <div id="accordion-item-group{{$key}}" class="collapse "
                                 data-parent="#accordionExample{{$key}}">
                                <div class="card-body">
                                    <strong>
                                        {{$reason->reason}}
                                    </strong>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            @endif


            <form method="POST" action="{{route('local-broadcasts.update', $localBroadcast)}}"
                  id="edit-local-report-form">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-4 form-group mb-3">
                        <div class="select_label ui sub header ">Tezlik (kanal)</div>
                        <select id="frequency_select" name="frequencies_id"
                                class="form-control ui fluid search dropdown">
                            <option value="">Tezliyi seçin və ya daxil edin</option>
                            <option value="{{$frequencies->value}}" selected>{{$frequencies->value}}</option>

                        </select>
                        <span class="text-danger" id="frequencies_idError"></span>
                    </div>

                    <div class="col-md-4 form-group mb-3">
                        <div class="select_label ui sub header ">Proqram adı</div>
                        <select id="program_name_select" disabled name="program_names_id"
                                class="form-control ui fluid search dropdown create_form_dropdown">
                            <option value="">Proqram adı seçin</option>
                            <option value="{{$program_names->id}}" selected>{{$program_names->name}}</option>
                        </select>
                        <span class="text-danger" id="program_names_idError"></span>
                    </div>

                    <div class="col-md-4 form-group mb-3">
                        <div class="select_label ui sub header ">İstiqamət</div>
                        <select id="direction_select" disabled name="directions_id"
                                class="form-control ui fluid search dropdown create_form_dropdown">
                            <option value="">İstiqaməti seçin</option>
                            <option value="{{$directions->id}}" selected>{{$directions->name}}</option>
                        </select>
                        <span class="text-danger" id="directions_idError"></span>
                    </div>

                    <div class="col-md-4 form-group mb-3">
                        <div class="select_label ui sub header ">Proqram dili</div>
                        <select id="program_lang" disabled name="program_languages_id"
                                class="form-control ui fluid search dropdown create_form_dropdown">
                            <option value="">Proqram dilini seçin</option>
                            <option value="{{$program_languages->id}}" selected>{{$program_languages->name}}</option>
                        </select>
                        <span class="text-danger" id="program_langError"></span>
                    </div>


                    <div class="col-md-4 form-group mb-3">
                        <div class="select_label ui sub header ">Elektromaqnit sahə gərginliyinin səviyyəsi (dBμV/m)
                        </div>
                        <div class="ui input">
                            <input id="emfs_level" disabled name="emfs_level" value="{{$localBroadcast->emfs_level}}"
                                   step=any type="number" placeholder="">
                        </div>
                        <span class="text-danger" id="emfs_levelError"></span>
                    </div>

                    <div class="col-md-4 form-group mb-3">
                        <div class="select_label ui sub header ">Kanalın qəbul edildiyi istiqamət (azimut, dərəcə)</div>
                        <div class="ui input">
                            <input id="response_direction" value="{{$localBroadcast->response_direction}}" disabled
                                   name="response_direction" type="number" placeholder="">
                        </div>
                        <span class="text-danger" id="response_directionError"></span>
                    </div>

                    <div class="col-md-4 form-group mb-3">
                        <div class="select_label ui sub header ">Polyarizasiya</div>
                        <select id="polarization" disabled name="polarization"
                                class="form-control ui fluid search dropdown create_form_dropdown">
                            <option value="">Polyarizasiyanı seçin</option>
                            <option value="{{ $polarizations->id }}" selected>{{$polarizations->name}}</option>
                        </select>
                        <span class="text-danger" id="polarizationError"></span>
                    </div>

                    <div class="col-md-4 form-group mb-3">
                        <div class="select_label ui sub header ">Qəbulun keyfiyyəti və interferensiya yaratması</div>

                        <div class="ui input">
                            <select id="response_quality" name="response_quality"
                                    class="form-control ui fluid search dropdown create_form_dropdown">
                                <option value="">Qəbulun keyfiyyəti və interferensiya yaratmasını seçin</option>
                                <option
                                    value="Yaxşı" {{ $localBroadcast->response_quality == 'Yaxşı' ?  'selected' : '' }}>
                                    Yaxşı
                                </option>
                                <option
                                    value="Kafi" {{ $localBroadcast->response_quality == 'Kafi' ?  'selected' : '' }}>
                                    Kafi
                                </option>
                                <option
                                    value="Zəif" {{ $localBroadcast->response_quality == 'Zəif' ?  'selected' : '' }}>
                                    Zəif
                                </option>
                            </select>
                        </div>
                        <span class="text-danger" id="response_qualityError"></span>
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
                                        <input type="checkbox" name="device[{{$device}}]"
                                               {{in_array($device, explode(',',$localBroadcast->device)) ? 'checked' : ''}} value="1"
                                               id="{{$device}}">
                                        <span class="slider"></span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        <span class="text-danger" id="deviceError"></span>
                    </div>

                    <div class="col-md-12 form-group mb-3 mt-2">
                        <label for="device">Əlavə qeyd</label>
                        <textarea class="form-control" rows="6" name="note"
                                  placeholder="Əlavə qeydi daxil edin..">{{$localBroadcast->note}}</textarea>
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
        $('#edit-local-report-form').submit(function (e) {
            e.preventDefault();
            const form = $(this);
            const formValid = true;

            const fields = [
                {
                    id: 'frequency_select',
                    name: 'Tezlik',
                    errorId: 'frequencies_idError',
                    errorMessage: 'Zəhmət olmasa tezlik seçin'
                },
                {
                    id: 'direction_select',
                    name: 'İstiqamət',
                    errorId: 'directions_idError',
                    errorMessage: 'Zəhmət olmasa istiqamət seçin'
                },
                {
                    id: 'program_name_select',
                    name: 'Proqram adı',
                    errorId: 'program_names_idError',
                    errorMessage: 'Zəhmət olmasa proqram adını seçin'
                },
                {
                    id: 'program_lang',
                    name: 'Proqram dili',
                    errorId: 'program_langError',
                    errorMessage: 'Zəhmət olmasa proqram dilini seçin'
                },
                {
                    id: 'emfs_level',
                    name: 'Elektromaqnit sahə gərginliyinin səviyyəsi',
                    errorId: 'emfs_levelError',
                    errorMessage: 'Zəhmət olmasa EMSG səviyyəsini daxil edin'
                },
                {
                    id: 'response_direction',
                    name: 'Kanalın qəbul edildiyi istiqamət',
                    errorId: 'response_directionError',
                    errorMessage: 'Zəhmət olmasa dərəcəni daxil edin'
                },
                {
                    id: 'polarization',
                    name: 'Polyarizasiya',
                    errorId: 'polarizationError',
                    errorMessage: 'Zəhmət olmasa polyarizasiya seçin'
                },
                {
                    id: 'response_quality',
                    name: 'Qəbulun keyfiyyəti və interferensiya yaratması',
                    errorId: 'response_qualityError',
                    errorMessage: 'Zəhmət olmasa qəbul keyfiyyətini'
                }
            ];

            fields.forEach(function (field) {
                const value = $('#' + field.id).val().trim();
                const errorSpan = $('#' + field.errorId);

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
                            success: function (response) {

                                Swal.fire({
                                    title: "Məlumatlar dəyişdirildi.",
                                    text: response.message,
                                    icon: "success"
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href = response.route;
                                    }
                                });
                            }
                        });
                    }
                });
            }
        });
    </script>
@endsection

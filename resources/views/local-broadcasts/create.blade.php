  @extends('layouts.app')
@section('content')

    <div class="row mb-4">
        <div class="col-md-12 mb-4">

            <div class="d-flex justify-content-between align-items-center">
                <h3>Yeni yerli hesabat</h3>
                <a href="{{route('local-broadcasts.index')}}">
                    <button class="btn btn-danger">
                                <span class="me-2">
                                    <i class="nav-icon i-Arrow-Back-2"></i>
                                </span>
                        Yerli hesabatlar
                    </button>
                </a>
            </div>
            <hr>
            <form method="POST" action="{{route('local-broadcasts.store')}}" class="store-local-report-form">
                @csrf
                <div class="form_inputs_container position-relative">
                    <div class="row position-relative form_block" id="formRow">
                        <div class="col-md-4 form-group mb-3">
                            <div class="select_label ui sub header ">Tezlik (kanal)</div>
                            <select frequency="true" id="frequency_select" name="frequencies_id[]" class="form-control ui fluid search dropdown create_form_dropdown frequency_select_cl">
                                <option value="">Tezliyi seçin və ya daxil edin</option>
                                @forelse($frequencies as $item)
                                    <option value="{{$item->value}}" {{ old('frequencies_id')==$item->id ? 'selected' : '' }}>{{$item->value}}</option>
                                @empty
                                    <option disabled selected>Məlumat yoxdur</option>
                                @endforelse

                            </select>
                            <span class="text-danger error_message" id="frequencies_idError"></span>
                        </div>

                        <div class="col-md-4 form-group mb-3">
                            <div class="select_label ui sub header">Proqram adı</div>
                            <select id="program_name_select" disabled name="program_names_id[]"
                                    class="form-control ui fluid search dropdown create_form_dropdown depended_from_frequency">
                                <option value="">Proqram adı seçin</option>
                            </select>
                            <span class="text-danger error_message" id="program_names_idError"></span>
                        </div>

                        <div class="col-md-4 form-group mb-3">
                            <div class="select_label ui sub header">İstiqamət</div>
                            <select id="direction_select" disabled name="directions_id[]"
                                    class="form-control ui fluid search dropdown create_form_dropdown create_form_dropdown depended_from_frequency">
                            </select>
                            <span class="text-danger error_message" id="directions_idError"></span>
                        </div>

                        <div class="col-md-4 form-group mb-3">
                            <div class="select_label ui sub header ">Proqram dili</div>
                            <select id="program_lang" disabled name="program_languages_id[]"
                                    class="form-control ui fluid search dropdown create_form_dropdown depended_from_frequency">
                            </select>
                            <span class="text-danger error_message" id="program_langError"></span>
                        </div>


                        <div class="col-md-4 form-group mb-3">
                            <div class="select_label ui sub header ">Elektromaqnit sahə gərginliyinin səviyyəsi (dBμV/m)
                            </div>
                            <div class="ui input">
                                <input id="emfs_level" disabled name="emfs_level[]" value="{{old('emfs_level')}}"
                                       step=any type="number" placeholder="">
                            </div>
                            <span class="text-danger error_message" id="emfs_levelError"></span>
                        </div>

                        <div class="col-md-4 form-group mb-3">
                            <div class="select_label ui sub header ">Kanalın qəbul edildiyi istiqamət (azimut, dərəcə)</div>
                            <div class="ui input">
                                <input id="response_direction" value="{{old('response_direction')}}" disabled
                                       name="response_direction[]" type="number" placeholder="">
                            </div>
                             <span class="text-danger error_message" id="response_directionError"></span>
                        </div>

                        <div class="col-md-4 form-group mb-3">
                            <div class="select_label ui sub header ">Polyarizasiya</div>
                            <select id="polarization" disabled name="polarization[]"
                                    class="form-control ui fluid search dropdown create_form_dropdown depended_from_frequency">
                            </select>
                            <span class="text-danger error_message" id="polarizationError"></span>
                        </div>

                        <div class="col-md-4 form-group mb-3">
                            <div class="select_label ui sub header ">Qəbulun keyfiyyəti və interferensiya yaratması</div>

                            <div class="ui input">
                                <select id="response_quality" name="response_quality[]" myUniqueItem="response_quality_local"
                                        class="form-control ui fluid search dropdown create_form_dropdown">
                                    <option value="">Qəbulun keyfiyyəti və interferensiya yaratmasını seçin</option>
                                    <option value="Yaxşı" {{ old('response_quality') == 'Yaxşı' ?  'selected' : '' }}>
                                        Yaxşı
                                    </option>
                                    <option value="Zəif" {{ old('response_quality') == 'Zəif' ?  'selected' : '' }}>Zəif
                                    </option>
                                    <option value="Kafi" {{ old('response_quality') == 'Kafi' ?  'selected' : '' }}>Kafi
                                    </option>
                                </select>
                            </div>
                            <span class="text-danger error_message" id="response_qualityError"></span>
                        </div>
                    </div>
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
                    <span class="text-danger" id="deviceError"></span>
                </div>

                <div class="col-md-12 form-group mb-3 mt-2">
                    <label for="device">Əlavə qeyd</label>
                    <textarea class="form-control" rows="6" name="note"
                              placeholder="Əlavə qeydi daxil edin.."></textarea>
                </div>

                <div class="lower_buttons_container d-flex align-items-center row">
                    <div class="col-6 ">
                        <button class="btn btn-success btn-lg">Hesabatı daxil et</button>
                    </div>

                    <div class="col-6 ">
                        <button type="button" class="btn btn-success btn-lg" id="addRow">Yenisini əlavə et</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('js')
    <script>
        // const addNewBtn = document.getElementById('addRow');
        let rowCount = 0;

        let fields = [
            { id: 'frequency_select', name: 'Tezlik', errorId: 'frequencies_idError', errorMessage: 'Zəhmət olmasa tezlik seçin', num: 0, },
            { id: 'direction_select', name: 'İstiqamət', errorId: 'directions_idError', errorMessage: 'Zəhmət olmasa istiqamət seçin', num: 0, },
            { id: 'program_name_select', name: 'Proqram adı', errorId: 'program_names_idError', errorMessage: 'Zəhmət olmasa proqram adını seçin', num: 0, },
            { id: 'program_lang', name: 'Proqram dili', errorId: 'program_langError', errorMessage: 'Zəhmət olmasa proqram dilini seçin', num: 0, },
            { id: 'emfs_level', name: 'Elektromaqnit sahə gərginliyinin səviyyəsi', errorId: 'emfs_levelError', errorMessage: 'Zəhmət olmasa EMSG səviyyəsini daxil edin', num: 0, },
            { id: 'response_direction', name: 'Kanalın qəbul edildiyi istiqamət', errorId: 'response_directionError', errorMessage: 'Zəhmət olmasa dərəcəni daxil edin', num: 0, },
            { id: 'polarization', name: 'Polyarizasiya', errorId: 'polarizationError', errorMessage: 'Zəhmət olmasa polyarizasiya seçin', num: 0, },
            { id: 'response_quality', name: 'Qəbulun keyfiyyəti və interferensiya yaratması', errorId: 'response_qualityError', errorMessage: 'Zəhmət olmasa qəbul keyfiyyətini seçin', num: 0, }
        ];

        addNewBtn.addEventListener('click', function () {
            rowCount++;
            const formsContainer = document.querySelector('.form_inputs_container');
            const defaultForm = document.getElementById('formRow');

            const clone = defaultForm.cloneNode(true);
            clone.id += rowCount;
            const inputs = clone.querySelectorAll('input');
            const selects = clone.querySelectorAll('select');
            const error_messages = clone.querySelectorAll('.error_message');
            const delete_button = clone.querySelectorAll('.delete_block');

            inputs.forEach((input) => {
                const $input = $(input);
                const $textDiv = $input.siblings('div.text');
                $textDiv.empty();
                input.value = '';
                input.id ? input.id += rowCount : null;
            });

            selects.forEach((select) => {
                const $select = $(select);
                $select.find(":selected").val('');
                const $textDiv = $select.siblings('div.text');
                $textDiv.empty();
                if (select.id) {
                    select.id += rowCount;
                }
            });

            error_messages.forEach(message => message.id ? message.id += rowCount : null);

            delete_button.forEach(button => button.id ? button.id += rowCount : null);

            formsContainer.appendChild(clone);

            const dynamicForm = document.getElementById(`formRow${rowCount}`);
            if(rowCount > 0){
                const deleteContainer = document.createElement('div');
                deleteContainer.id = `delete_container${rowCount}`;
                deleteContainer.classList.add('delete_block');
                deleteContainer.textContent = 'Bloku sil';
                dynamicForm.appendChild(deleteContainer);
            };

            document.getElementById(`emfs_level${rowCount}`).disabled = true;
            document.getElementById(`response_direction${rowCount}`).disabled = true;

            $('.ui.create_form_dropdown').dropdown({
                clearable: true,
            });

            $('.frequency_select_cl').dropdown({
                allowAdditions: true,
                clearable: true,
            });

            let newFields = fields.slice(0, 8).map((field) => {
                return {
                    id: `${field.id}${rowCount}`,
                    name: `${field.name}${rowCount}`,
                    errorId: `${field.errorId}${rowCount}`,
                    errorMessage: field.errorMessage,
                    num: rowCount
                };
            });

            fields.push(...newFields);
            console.log(fields)
        });

        $(document).on('click', '[id^="delete_container"]', function(e) {
            const number = e.target.id.substring(16, e.target.id.length);
            const container = document.querySelector(`#formRow${number}`);
            container.remove();
            rowCount--;
            fields = fields.filter(field => field.num != number)
            console.log(fields)
        });

    </script>

    <script>
        $(document).ready(function () {
            let $frequency_select_cl = $('.frequency_select_cl')

            addNewBtn.addEventListener('click', function () {
                $frequency_select_cl = $('.frequency_select_cl');
            })

            $('.form_inputs_container').on('change', $frequency_select_cl, function(e){
                if($(e.target).attr('frequency') === 'true'){
                    const id = e.target.id;
                    let lastChar = '';
                    if(id && id.length > 0) {
                        const char = Number(id.substring(16, id.length));
                        if(char > 0){
                            lastChar = char;
                        }
                    }

                    const frequencies_id = e.target.value;
                    if(frequencies_id){
                        const programNamesSelect = $(`#program_name_select${lastChar}`);
                        programNamesSelect.closest('div').addClass('shimmer');

                        const directionsSelect = $(`#direction_select${lastChar}`);
                        directionsSelect.closest('div').addClass('shimmer');

                        const programLanguagesSelect = $(`#program_lang${lastChar}`);
                        programLanguagesSelect.closest('div').addClass('shimmer');

                        const polarizationSelect = $(`#polarization${lastChar}`);
                        polarizationSelect.closest('div').addClass('shimmer');

                        $.ajax({
                            url: "{{ route('get-data-by-frequency') }}",
                            method: "POST",
                            data: {
                                "_token": "{{csrf_token()}}",
                                "frequencies_id": frequencies_id
                            },
                            success: function (response) {
                                programNamesSelect.empty();
                                    programNamesSelect.append($("<option>", {
                                        value: response.program_names.id,
                                        text: response.program_names.name
                                    }));
                                programNamesSelect.attr('disabled', false);
                                programNamesSelect.closest('div').removeClass('shimmer');

                                directionsSelect.empty();
                                directionsSelect.append($("<option>", {
                                    value: response.directions.id,
                                    text: response.directions.name
                                }));
                                directionsSelect.attr('disabled', false);
                                directionsSelect.closest('div').removeClass('shimmer');

                                programLanguagesSelect.empty();
                                programLanguagesSelect.append($("<option>", {
                                    value: response.program_languages.id,
                                    text: response.program_languages.name
                                }));
                                programLanguagesSelect.attr('disabled', false);
                                programLanguagesSelect.closest('div').removeClass('shimmer');

                                polarizationSelect.empty();
                                polarizationSelect.append($("<option>", {
                                    value: response.polarizations.id,
                                    text: response.polarizations.name
                                }));
                                polarizationSelect.attr('disabled', false);
                                polarizationSelect.closest('div').removeClass('shimmer');

                            }
                        });
                    } else console.log('No value!')
                }
            });


        });

        $('.store-local-report-form').submit(function(e) {
            e.preventDefault();
            const form = $(this);
            var formValid = true;

            fields.forEach(function(field) {
                var value = $('#' + field.id).val();
                value ? value.trim() : null;
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

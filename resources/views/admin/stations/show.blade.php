@extends('admin.layouts.app')
@section('content')
    <div class="col-lg-12 col-md-12 mb-4">
        <!-- order -->
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="text-primary">{{$station->station_name}}</h3>
                <button class="btn btn-danger">Girişi məhdudlaşdır</button>
            </div>
            <div class="card-body">

                <div class="card-body">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="home-basic-tab" data-toggle="tab" href="#yerli" role="tab"
                               aria-controls="homeBasic" aria-selected="true">Yerli hesabatlar</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="profile-basic-tab" data-toggle="tab" href="#kenar" role="tab"
                               aria-controls="profileBasic" aria-selected="false">Kənar hesabatlar</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="yerli" role="tabpanel"
                             aria-labelledby="home-basic-tab">
                            <div class="table-responsive">
                                <table id="local-broadcasts-table" class="display table table-striped"
                                       style="width:100%">
                                    <thead>
                                    <tr>
                                        <th>№</th>
                                        <th>Tarix</th>
                                        <th>Tezlik (kanal)</th>
                                        <th>Proqramın adı</th>
                                        <th>İstiqamət</th>
                                        <th>Proqramın yayımlandığı dil</th>
                                        <th>ESG səviyyəsi</th>
                                        <th>Dərəcə</th>
                                        <th>Polyarizasiya</th>
                                        <th>Qəbulun keyfiyyəti</th>
                                        <th>Təsdiq statusu</th>
                                        <th>Əməliyyatlar</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($reports as $report)
                                        <tr class="font-weight-bold">
                                            <td>{{ $report->id }}</td>
                                            <td>{{\Carbon\Carbon::parse($report->report_date)->format('d.m.Y')}}</td>
                                            <td>{{$report->frequencies->value}}</td>
                                            <td>{{$report->program_names->name}}</td>
                                            <td>{{$report->directions->name}}</td>
                                            <td>{{$report->program_languages->name}}</td>
                                            <td>{{$report->emfs_level}}</td>
                                            <td>{{$report->response_direction}}</td>
                                            <td>{{$report->polarization}}</td>
                                            @php
                                                if ($report->response_quality == 'Yaxşı')
                                                    {
                                                        $text_class = 'success';
                                                    }
                                                elseif ($report->response_quality == 'Orta')
                                                    {
                                                        $text_class = 'warning';
                                                    }
                                                else
                                                    {
                                                        $text_class = 'danger';
                                                    }
                                            @endphp
                                            <td>
                                                <p class="text-{{$text_class}}">
                                                    {{$report->response_quality}}
                                                </p>
                                            </td>
                                            <td>
                                                @if($report->accepted_status ==0)
                                                    <p class="text-primary">Təsdiq gözləyir</p>
                                                @elseif($report->accepted_status == 2)
                                                    <p class="text-warning">Düzəliş üçün göndərildi</p>
                                                @elseif($report->accepted_status == 1)
                                                    <p class="text-success">Təsdiq edilib</p>
                                                @endif
                                            </td>
                                            <td>
                                                @if($report->accepted_status == 0)
                                                    <button class="btn btn-warning change-status-edit"
                                                            data-report-id="{{$report->id}}" data-accepted-status="2">
                                                        <span>
                                                            <i class="nav-icon i-Pen-2 font-weight-bold"></i>
                                                        </span>
                                                    </button>

                                                    <button class="btn btn-success change-status-confirm"
                                                            data-report-id="{{$report->id}}"
                                                            data-accepted-status="1">
                                                        <span>
                                                            <i class="nav-icon i-Check font-weight-bold"></i>
                                                        </span>
                                                    </button>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="kenar" role="tabpanel" aria-labelledby="profile-basic-tab">
                            <div class="table-responsive">
                                <table id="local-broadcasts-table" class="display table table-striped"
                                       style="width:100%">
                                    <thead>
                                    <tr>
                                        <th>№</th>
                                        <th>Tarix</th>
                                        <th>Tezlik (kanal)</th>
                                        <th>Proqramın adı</th>
                                        <th>İstiqamət</th>
                                        <th>Proqramın yayımlandığı dil</th>
                                        <th>ESG səviyyəsi</th>
                                        <th>Dərəcə</th>
                                        <th>Polyarizasiya</th>
                                        <th>Qəbulun keyfiyyəti</th>
                                        <th>Vurulma istiqaməti</th>
                                        <th>Təsdiq statusu</th>
                                        <th>Əməliyyatlar</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($freports as $report)
                                        <tr class="font-weight-bold">
                                            <td>{{ $report->id }}</td>
                                            <td>{{\Carbon\Carbon::parse($report->report_date)->format('d.m.Y')}}</td>
                                            <td>{{$report->frequencies->value}}</td>
                                            <td>{{$report->program_names->name}}</td>
                                            <td>{{$report->directions->name}}</td>
                                            <td>{{$report->program_languages->name}}</td>
                                            <td>{{$report->emfs_level_in}} @if($report->emfs_level_out) /{{$report->emfs_level_out}} @endif </td>
                                            <td>{{$report->response_direction_in}} @if($report->response_direction_in) /{{$report->response_direction_out}} @endif</td>
                                            <td>{{$report->polarization}}</td>
                                            @php
                                                if ($report->response_quality == 'Yaxşı')
                                                    {
                                                        $text_class = 'success';
                                                    }
                                                elseif ($report->response_quality == 'Orta')
                                                    {
                                                        $text_class = 'warning';
                                                    }
                                                else
                                                    {
                                                        $text_class = 'danger';
                                                    }
                                            @endphp
                                            <td>
                                                <p class="text-{{$text_class}}">
                                                    {{$report->response_quality}}
                                                </p>
                                            </td>
                                            <td>
                                                {{$report->sending_from}}
                                            </td>
                                            <td>
                                                @if($report->accepted_status ==0)
                                                    <p class="text-primary">Təsdiq gözləyir</p>
                                                @elseif($report->accepted_status == 2)
                                                    <p class="text-warning">Düzəliş üçün göndərildi</p>
                                                @elseif($report->accepted_status == 1)
                                                    <p class="text-success">Təsdiq edilib</p>
                                                @endif
                                            </td>
                                            <td>
                                                @if($report->accepted_status == 0)
                                                    <button class="btn btn-warning f-change-status-edit" id=""
                                                            data-report-id="{{$report->id}}" data-accepted-status="2">
                                                            <span>
                                                                <i class="nav-icon i-Pen-2 font-weight-bold"></i>
                                                            </span>
                                                    </button>

                                                    <button class="btn btn-success f-change-status-confirm" id=""
                                                            data-report-id="{{$report->id}}"
                                                            data-accepted-status="1">
                                                    <span>
                                                        <i class="nav-icon i-Check font-weight-bold"></i>
                                                    </span>
                                                    </button>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>


            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function () {

            // send to update function
            $('.change-status-edit').on('click', function () {
                const button = $(this);
                Swal.fire({
                    title: "Zəhmət olmasa düzəlişə göndərilmə səbəbini daxil edin",
                    input: "text",
                    inputAttributes: {
                        autocapitalize: "off"
                    },
                    showCancelButton: true,
                    cancelButtonText: "Ləğv edin",
                    confirmButtonText: "Göndərin",
                    showLoaderOnConfirm: true,
                    preConfirm: async (reason) => {
                        const status_data = button.data('accepted-status');
                        const report_id = button.data('report-id');
                        try {
                            const response = await fetch("{{ route('dashboard-local-broadcasts.send-to-update') }}", {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                                },
                                body: JSON.stringify({
                                    report_id: report_id,
                                    accepted_status: status_data,
                                    reason: reason
                                })
                            });

                            if (!response.ok) {
                                throw new Error(await response.json());
                            }

                            const responseData = await response.json();
                            if(responseData.status == 200)
                            {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Uğurlu',
                                    text: responseData.message
                                }).then((result) => {
                                    if(result.isConfirmed) {
                                        window.location.href = responseData.route;
                                    }
                                });
                            }
                        } catch (error) {
                            Swal.showValidationMessage(`${error.message}`);
                        }
                    },
                    allowOutsideClick: () => !Swal.isLoading()
                })
            })

            //confirm function
            $('.change-status-confirm').on('click', function () {
                const button = $(this);
                Swal.fire({
                    title: "Məlumatların düzgünlüyünü təsdiq edirsiniz ?",
                    icon: "warning",
                    showCancelButton: true,
                    cancelButtonText: "Ləğv edin",
                    confirmButtonColor: "#4caf50",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Təsdiq edin!"
                }).then((result) => {
                    const status_data = button.data('accepted-status');
                    const report_id = button.data('report-id');
                    $.ajax({
                        url:"{{route('dashboard-local-broadcasts.confirm')}}",
                        method:"POST",
                        data:{
                            "_token":"{{csrf_token()}}",
                            "report_id": report_id,
                            "accepted_status": status_data,
                        },
                        success:function(){
                            location.reload();
                        }
                    })
                });
            })


            $('.f-change-status-edit').on('click', function () {
                const button = $(this);
                Swal.fire({
                    title: "Zəhmət olmasa düzəlişə göndərilmə səbəbini daxil edin",
                    input: "text",
                    inputAttributes: {
                        autocapitalize: "off"
                    },
                    showCancelButton: true,
                    cancelButtonText: "Ləğv edin",
                    confirmButtonText: "Göndərin",
                    showLoaderOnConfirm: true,
                    preConfirm: async (reason) => {
                        const status_data = button.data('accepted-status');
                        const report_id = button.data('report-id');
                        try {
                            const response = await fetch("{{ route('dashboard-foreign-broadcasts.send-to-update') }}", {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                                },
                                body: JSON.stringify({
                                    report_id: report_id,
                                    accepted_status: status_data,
                                    reason: reason
                                })
                            });

                            if (!response.ok) {
                                throw new Error(await response.json());
                            }

                            const responseData = await response.json();
                            if(responseData.status == 200)
                            {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Uğurlu',
                                    text: responseData.message
                                }).then((result) => {
                                    if(result.isConfirmed) {
                                        window.location.href = responseData.route;
                                    }
                                });
                            }
                        } catch (error) {
                            Swal.showValidationMessage(`${error.message}`);
                        }
                    },
                    allowOutsideClick: () => !Swal.isLoading()
                })
            })

            //confirm function
            $('.f-change-status-confirm').on('click', function () {
                const button = $(this);
                Swal.fire({
                    title: "Məlumatların düzgünlüyünü təsdiq edirsiniz ?",
                    icon: "warning",
                    showCancelButton: true,
                    cancelButtonText: "Ləğv edin",
                    confirmButtonColor: "#4caf50",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Təsdiq edin!"
                }).then((result) => {
                    if(result.isConfirmed)
                    {
                        const status_data = button.data('accepted-status');
                        const report_id = button.data('report-id');
                        $.ajax({
                            url:"{{route('dashboard-foreign-broadcasts.confirm')}}",
                            method:"POST",
                            data:{
                                "_token":"{{csrf_token()}}",
                                "report_id": report_id,
                                "accepted_status": status_data,
                            },
                            success:function(response){
                                if(response.status == 200)
                                {
                                    Swal.fire({
                                        title: "Məlumatlar daxil edildi",
                                        text: response.message,
                                        icon: "success"
                                    }).then((result) => {
                                        console.log(result);
                                        if(result.isConfirmed) {
                                            window.location.href = response.route;
                                        }
                                    });
                                }
                            }
                        })
                    }
                });
            })
        })

    </script>
@endsection

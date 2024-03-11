@extends('layouts.app')
@section('content')
    <div class="row mb-4">
        <div class="col-md-12 mb-4">

            <div class="d-flex justify-content-between align-items-center">
                <h3>Yerli hesabatlar</h3>
                @if($local_broadcast_button_status)
                <a href="{{route('local-broadcasts.create')}}">
                    <button class="btn btn-success">
                                <span class="me-2">
                                    <i class="nav-icon i-Add-File"></i>
                                </span>
                        Yeni yerli hesabat
                    </button>
                </a>
                @endif
            </div>
            <div class="table-responsive">
                <table id="local-broadcasts-table" class="display table table-striped" style="width:100%">
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
                        <th>Cihazlar</th>
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
                            <td>{{ $report->device }}</td>
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
                                @if($report->accepted_status == 0)
                                    <p class="text-primary">Təsdiq üçün göndərildi</p>
                                @elseif($report->accepted_status == 2)
                                    <p class="text-warning">Düzəliş tələb olunur</p>
                                @elseif($report->accepted_status == 1)
                                    <p class="text-success">Təsdiq olunub</p>
                                @endif
                            </td>
                            <td>
                                @if($report->accepted_status == 2)
                                    <a href="{{ route('local-broadcasts.edit', $report->id ) }}"
                                       class="text-success mr-2">
                                        <i class="nav-icon i-Pen-2 font-weight-bold"></i>
                                    </a>
                                @endif
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
            $('#local-broadcasts-table').DataTable();

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
        })
    </script>
@endsection

@extends('layouts.app')
@section('content')
    <div class="row mb-4">
        <div class="col-md-12 mb-4">

            <div class="d-flex justify-content-between align-items-center">
                <h3>Kənar hesabatlar</h3>
                @if($foreign_broadcast_button_status)
                <a href="{{route('foreign-broadcasts.create')}}">
                    <button class="btn btn-success">
                                <span class="me-2">
                                    <i class="nav-icon i-Add-File"></i>
                                </span>
                        Yeni kənar hesabat
                    </button>
                </a>
                @endif
            </div>
            <div class="table-responsive">
                <table id="foreign-broadcasts-table" class="display table table-striped" style="width:100%">
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
                    @foreach($reports as $report)
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
                                <a href="{{ route('foreign-broadcasts.edit', $report->id ) }}" class="text-success mr-2">
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
            $('#foreign-broadcasts-table').DataTable();
        })
    </script>
@endsection

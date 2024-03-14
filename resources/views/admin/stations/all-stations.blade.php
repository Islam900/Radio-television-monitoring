@extends('admin.layouts.app')
@section('content')
    <div class="col-lg-12 col-md-12 mb-4">
        <!-- order -->
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="text-primary">Bütün məntəqələr</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="local-broadcasts-table" class="display table table-striped" style="width:100%">
                        <thead>
                        <tr>
                            <th>№</th>
                            <th>Məntəqə adı</th>
                            <th>İstifadəçilər</th>
                            <th>Email ünvanları</th>
                            <th>Aktivlik statusu</th>
                            <th>Əməliyyatlar</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($stations as $station)
                            <tr class="font-weight-bold">
                                <td>{{ $station->id }}</td>
                                <td>{{ $station->station_name }}</td>
                                <td>
                                    <ul>
                                        @foreach($station->user as $user)
                                            <li>
                                                {{ $user->name_surname }}
                                            </li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td>
                                    <ul>
                                        @foreach($station->user as $user)
                                            <li>
                                                {{ $user->email }}
                                            </li>
                                        @endforeach
                                    </ul>
                                </td>

                                <td>
                                    <button class="btn btn-{{ $station->status==1 ? 'success' : '' }}">{{ $station->status==1 ? 'Aktiv' : 'Məhdudlaşdırılıb' }}</button>
                                </td>

                                <td>
                                    <a href="{{ route('stations.show', $station->id) }}">
                                        <button class="btn btn-info">
                                            <span>
                                                <i class="nav-icon i-Eye font-weight-bold"></i>
                                            </span>
                                        </button>
                                    </a>
{{--                                    <a href="{{ route('stations.edit', $station->id) }}">--}}
{{--                                        <button class="btn btn-warning">--}}
{{--                                            <span>--}}
{{--                                                <i class="nav-icon i-Pen-2 font-weight-bold"></i>--}}
{{--                                            </span>--}}
{{--                                        </button>--}}
{{--                                    </a>--}}
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

@section('js')
    <script>
        $(document).ready(function() {

            // send to update function
            $('#change-status-edit').on('click', function() {
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
                            Swal.fire({
                                icon: 'success',
                                title: 'Uğurlu',
                                text: responseData.message
                            });
                            setTimeout(function, milliseconds);
                            // location.reload();
                        } catch (error) {
                            Swal.showValidationMessage(`${error.message}`);
                        }
                    },
                    allowOutsideClick: () => !Swal.isLoading()
                })
            })

            //confirm function
            $('#change-status-confirm   ').on('click', function() {
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
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: "Deleted!",
                            text: "Your file has been deleted.",
                            icon: "success"
                        });
                    }
                });
            })
        })

    </script>
@endsection

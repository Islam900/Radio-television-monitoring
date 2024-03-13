@extends('admin.layouts.app')
@section('content')
    <div class="col-lg-12 col-md-12 mb-4">
        <!-- order -->
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="text-primary">Sistem istifadəçiləri</h3>
                <a href="{{ route('station-users.create') }}">
                    <button class="btn btn-success">Yeni istifadəçi</button>
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="local-broadcasts-table" class="display table table-striped" style="width:100%">
                        <thead>
                        <tr>
                            <th>№</th>
                            <th>Ad soyad</th>
                            <th>Məntəqə</th>
                            <th>Vəzifə</th>
                            <th>Aktivlik statusu</th>
                            <th>Əməliyyatlar</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr class="font-weight-bold">
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name_surname }}</td>
                                <td>{{ $user->stations->station_name }}</td>
                                <td>
                                    @if($user->roles->isNotEmpty())
                                        <strong>{{ $user->roles->first()->name }}</strong>
                                    @else
                                        <strong>Vəzifə təyin olunmayıb</strong>
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-{{ $user->activity_status==1 ? 'success' : '' }}">{{ $user->activity_status==1 ? 'Aktiv' : 'Məhdudlaşdırılıb' }}</button>
                                </td>
                                <td>
                                    @if($user->activity_status == 0)
                                        <button class="btn btn-success unban-user" data-user-id="{{$user->id}}">
                                        <span>
                                            <i class="nav-icon i-Unlock font-weight-bold"></i>
                                        </span>
                                        </button>
                                    @endif
                                    @if($user->activity_status == 1)
                                        <button class="btn btn-danger ban-user" data-user-id="{{$user->id}}">
                                        <span>
                                            <i class="nav-icon i-Lock font-weight-bold"></i>
                                        </span>
                                        </button>
                                    @endif
                                    <a href="{{ route('station-users.edit', $user->id) }}">
                                        <button class="btn btn-warning">
                                            <span>
                                                <i class="nav-icon i-Pen-2 font-weight-bold"></i>
                                            </span>
                                        </button>
                                    </a>
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
            $('.ban-user').on('click', function() {
                const button = $(this);
                Swal.fire({
                    title: "Zəhmət olmasa son tarix seçin",
                    input: "date",
                    inputAttributes: {
                        autocapitalize: "off"
                    },
                    showCancelButton: true,
                    cancelButtonText: "Ləğv edin",
                    confirmButtonText: "Təsdiq edin",
                    showLoaderOnConfirm: true,
                    preConfirm: async (ban_end_date) => {
                        const user_id = button.data('user-id');
                        try {
                            const response = await fetch("{{ route('station-users.ban-user') }}", {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                                },
                                body: JSON.stringify({
                                    user_id: user_id,
                                    ban_end_date: ban_end_date
                                })
                            });

                            if (!response.ok) {
                                throw new Error(await response.json());
                            }

                            const responseData = await response.json();
                            if(responseData.status == 200)
                            {
                                Swal.fire({
                                    title: "Giriş məhdudlaşdırıldı",
                                    text: responseData.message,
                                    icon: "success"
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
            });

            $('.unban-user').on('click', async function() {
                let timerInterval;
                const button = $(this);

                const user_id = button.data('user-id');
                try {
                    const response = await fetch("{{ route('station-users.unban-user') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({
                            user_id: user_id,
                        })
                    });

                    if (!response.ok) {
                        throw new Error('Xəta!');
                    }

                    const responseData = await response.json();
                            if(responseData.status == 200)
                            {
                                Swal.fire({
                                    title: "Girişi bərpa edilir!",
                                    html: "İstifadəçinin məhdudlaşdırılması aradan qaldırılır.",
                                    timer: 2000,
                                    timerProgressBar: true,
                                    didOpen: () => {
                                        Swal.showLoading();
                                        setTimeout(() => {
                                            const timer = Swal.getPopup().querySelector("b");
                                            if(timer){
                                                timer.textContent = 'Merhaba';
                                                timerInterval = setInterval(() => {
                                                    timer.textContent = 'Merhaba';
                                                }, 100);
                                            }
                                        }, 100);
                                    },
                                    willClose: () => {
                                        clearInterval(timerInterval);
                                        window.location.href = responseData.route;
                                    }
                                }).then(async (result) => {
                                    if (result.isDismissed) return;
                                });
                            }
                } catch (error) {
                    Swal.fire('Xəta!', error.message, 'error');
                }

            });

        })

    </script>
@endsection

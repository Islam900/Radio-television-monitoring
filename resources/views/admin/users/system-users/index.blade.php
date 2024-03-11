@extends('admin.layouts.app')
@section('content')
    <div class="col-lg-12 col-md-12 mb-4">
        <!-- order -->
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="text-primary">Sistem istifadəçiləri</h3>
                <a href="{{ route('system-users.create') }}">
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
                                    <button class="btn btn-primary ban-user" data-user-id="{{$user->id}}">
                                        <span>
                                            <i class="nav-icon i-Lock font-weight-bold"></i>
                                        </span>
                                    </button>
                                    <a href="{{ route('system-users.edit', $user->id) }}">
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
                            const response = await fetch("{{ route('system-users.ban-user') }}", {
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
                                    icon: 'success',
                                    title: 'Uğurlu',
                                    text: responseData.message
                                });
                            }
                        } catch (error) {
                            Swal.showValidationMessage(`${error.message}`);
                        }
                    },
                    allowOutsideClick: () => !Swal.isLoading()
                })
            })
        })

    </script>
@endsection

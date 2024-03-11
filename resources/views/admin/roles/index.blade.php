@extends('admin.layouts.app')
@section('content')
    <div class="col-lg-12 col-md-12 mb-4">
        <!-- order -->
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="text-primary">Vəzifələr</h3>
                <a href="{{ route('roles.create') }}">
                    <button class="btn btn-success">Yeni vəzifə</button>
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="local-broadcasts-table" class="display table table-striped" style="width:100%">
                        <thead>
                        <tr>
                            <th>№</th>
                            <th>Vəzifə</th>
                            <th>Əməliyyatlar</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($roles as $role)
                            <tr class="font-weight-bold">
                                <td>{{ $role->id }}</td>
                                <td>{{ $role->name }}</td>
                                <td>
                                    <a href="{{ route('roles.edit', $role->id) }}">
                                        <button class="btn btn-info">
                                            <span>
                                                <i class="nav-icon i-Pen-2 font-weight-bold"></i>
                                            </span>
                                        </button>
                                    </a>
                                    <button class="btn btn-danger delete-role" data-role-id="{{$role->id}}">
                                        <span>
                                            <i class="nav-icon i-Folder-Trash font-weight-bold"></i>
                                        </span>
                                    </button>
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
        $(document).ready(function () {
            $('.delete-role').on('click', function () {
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: "btn btn-success",
                        cancelButton: "btn btn-danger me-2"
                    },
                    buttonsStyling: false
                });
                swalWithBootstrapButtons.fire({
                    title: "Silmək istədiyinizdən əminsiniz ?",
                    text: "Buna bağlı bütün məlumatlar silinəcək !",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Sil!",
                    cancelButtonText: "Ləğv et!",
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        let role_id = $(this).data('role-id');
                        $.ajax({
                            url: "/roles/" + role_id,
                            type:"DELETE",
                            data: {
                                "_token":"{{csrf_token()}}",
                                "role_id": role_id
                            },
                            success: function (response) {
                                if(response.status == 200){
                                    Swal.fire({
                                        title: "Məlumatlar silindi",
                                        text: response.message,
                                        icon: "success"
                                    }).then((result) => {
                                        if(result.isConfirmed) {
                                            window.location.href = response.route;
                                        }
                                    });
                                }
                                else
                                {
                                    swalWithBootstrapButtons.fire({
                                        title: "Xəta baş verdi",
                                        text: "Məlumatlar silinmədi",
                                        icon: "error"
                                    });
                                }
                            }
                        })
                    } else if (
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                        swalWithBootstrapButtons.fire({
                            title: "Ləğv etdiniz",
                            text: "Məlumatlar silinmədi",
                            icon: "error"
                        });
                    }
                });
            })
        })
    </script>
@endsection

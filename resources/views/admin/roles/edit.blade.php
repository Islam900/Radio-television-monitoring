@extends('admin.layouts.app')
@section('content')

    <div class="row mb-4">
        <div class="col-md-12 mb-4">

            <div class="d-flex justify-content-between align-items-center">
                <h3>{{ $role->name }}</h3>
                <a href="{{route('roles.index')}}">
                    <button class="btn btn-danger">
                                <span class="me-2">
                                    <i class="nav-icon i-Arrow-Back-2"></i>
                                </span>
                        Vəzifələr
                    </button>
                </a>
            </div>
            <hr>
            <form method="POST" id="store-system-user-form" action="{{route('roles.update', $role->id)}}">
                @csrf
                @method('PUT')
                <div class="form-group row">
                    <label for="name_surname" class="col-sm-2 col-form-label">Vəzifə adı</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" required name="role"
                               placeholder="Ad soyad daxil edin..." value="{{$role->name}}" id="name_surname">
                        <span class="text-danger" id="name_surnameError"></span>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="name_surname" class="col-sm-2 col-form-label">Səlahiyyətlər</label>
                    <div class="col-sm-10">
                        <div class="row">
                            @foreach($permissions as $permission)
                                <div class="col-md-3">
                                    <label class="checkbox checkbox-success">
                                        <input type="checkbox" value="{{$permission->id}}" {{ in_array($permission->name, $role->permissions->pluck('name')->toArray()) ? 'checked' : ''  }} name="permission[]">
                                        <span>{{$permission->name}}</span>
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-success">Daxil edin</button>
                </div>
            </form>

        </div>
    </div>
@endsection


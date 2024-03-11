@extends('admin.layouts.app')
@section('content')

    <div class="row mb-4">
        <div class="col-md-12 mb-4">

            <div class="d-flex justify-content-between align-items-center">
                <h3>Yeni tezlik</h3>
                <a href="{{route('frequencies.index')}}">
                    <button class="btn btn-danger">
                                <span class="me-2">
                                    <i class="nav-icon i-Arrow-Back-2"></i>
                                </span>
                        Tezliklər
                    </button>
                </a>
            </div>
            <hr>
            <form method="POST" id="store-system-user-form" action="{{route('system-users.store')}}">
                @csrf
                <div class="form-group row">
                    <label for="name_surname" class="col-sm-2 col-form-label">Ad soyad</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" required name="name_surname" placeholder="Ad soyad daxil edin..." id="name_surname">
                        <span class="text-danger" id="name_surnameError"></span>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="email" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                        <input type="email" required name="email" placeholder="Email adresi daxil edin ..." class="form-control" id="email">
                        <span class="text-danger" id="emailError"></span>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="contact_number" class="col-sm-2 col-form-label">Əlaqə nömrəsi</label>
                    <div class="col-sm-10">
                        <input type="text" required name="contact_number" placeholder="Əlaqə nömrəsini daxil edin ..." class="form-control" id="contact_number">
                        <span class="text-danger" id="contact_numberError"></span>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="role" class="col-sm-2 col-form-label">Vəzifə</label>
                    <div class="col-sm-10">
                        <select id="role" required name="role"
                                class="form-control ui fluid search dropdown create_form_dropdown">
                            @foreach($roles as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                        <span class="text-danger" id="roleError"></span>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="inputPassword" class="col-sm-2 col-form-label">Password</label>
                    <div class="col-sm-10">
                        <input type="password" required name="password" class="form-control" id="password" placeholder="Password">
                        <span class="text-danger" id="passwordError"></span>
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-success">Daxil edin</button>
                </div>
            </form>

        </div>
    </div>
@endsection


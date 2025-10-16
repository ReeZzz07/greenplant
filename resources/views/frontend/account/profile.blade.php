@extends('frontend.layout')

@section('title', 'Настройки профиля - GreenPlant')

@section('content')
@include('frontend.account.partials.hero', ['title' => 'Настройки профиля'])

<!-- Breadcrumbs Section -->
<section class="breadcrumbs-section bg-white py-3" style="border-bottom: 1px solid #e9ecef;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <p class="breadcrumbs mb-0">
                    <span class="mr-2"><a href="{{ route('home') }}">Главная</a></span>
                    <span class="mr-2"><a href="{{ route('account.dashboard') }}">Кабинет</a></span>
                    <span>Профиль</span>
                </p>
            </div>
        </div>
    </div>
</section>

<section class="ftco-section">
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 mb-4">
                @include('frontend.account.partials.sidebar')
            </div>

            <!-- Main Content -->
            <div class="col-md-9">
                <!-- Личная информация -->
                <div class="card p-4 mb-4" style="background: white; border-radius: 10px; box-shadow: 0 0 15px rgba(0,0,0,0.1);">
                    <h4 class="mb-4"><i class="fas fa-user"></i> Личная информация</h4>
                    
                    <form action="{{ route('account.profile.update') }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Имя <span style="color: red;">*</span></label>
                                    <input type="text" class="form-control" name="name" id="name" 
                                           value="{{ old('name', auth()->user()->name) }}" required>
                                    @error('name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email <span style="color: red;">*</span></label>
                                    <input type="email" class="form-control" name="email" id="email" 
                                           value="{{ old('email', auth()->user()->email) }}" required>
                                    @error('email')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Сохранить изменения</button>
                    </form>
                </div>

                <!-- Изменение пароля -->
                <div class="card p-4" style="background: white; border-radius: 10px; box-shadow: 0 0 15px rgba(0,0,0,0.1);">
                    <h4 class="mb-4"><i class="fas fa-lock"></i> Изменить пароль</h4>
                    
                    <form action="{{ route('account.password.update') }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="current_password">Текущий пароль <span style="color: red;">*</span></label>
                                    <input type="password" class="form-control" name="current_password" id="current_password" required>
                                    @error('current_password')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password">Новый пароль <span style="color: red;">*</span></label>
                                    <input type="password" class="form-control" name="password" id="password" 
                                           placeholder="Минимум 8 символов" required>
                                    @error('password')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password_confirmation">Подтвердите пароль <span style="color: red;">*</span></label>
                                    <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" 
                                           placeholder="Повторите пароль" required>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Изменить пароль</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection


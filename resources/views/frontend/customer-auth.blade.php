@extends('frontend.layout')

@section('title', 'Вход / Регистрация - GreenPlant')

@section('content')
@include('frontend.account.partials.hero', ['title' => 'Вход в личный кабинет', 'subtitle' => 'Войдите в существующий аккаунт или создайте новый'])

<!-- Breadcrumbs Section -->
<section class="breadcrumbs-section bg-white py-3" style="border-bottom: 1px solid #e9ecef;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <p class="breadcrumbs mb-0">
                    <span class="mr-2"><a href="{{ route('home') }}">Главная</a></span>
                    <span>Вход в личный кабинет</span>
                </p>
            </div>
        </div>
    </div>
</section>

<section class="ftco-section">
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="row justify-content-center">
            <!-- Вход -->
            <div class="col-md-6 mb-4">
                <div class="contact-wrap w-100 p-4" style="background: white; border-radius: 10px; box-shadow: 0 0 20px rgba(0,0,0,0.1); height: 100%;">
                    <h3 class="mb-4 text-center"><i class="fas fa-sign-in-alt"></i> Вход в личный кабинет</h3>
                    <p class="text-center text-muted mb-4">Войдите, чтобы отслеживать заказы и управлять адресами</p>

                    @if($errors->any())
                        <div class="alert alert-danger">
                            @foreach($errors->all() as $error)
                                {!! $error !!}<br>
                            @endforeach
                        </div>
                    @endif

                    <form action="{{ route('customer.login.submit') }}" method="POST" class="contactForm">
                        @csrf

                        <div class="form-group">
                            <label for="login_email">Email <span style="color: red;">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="login_email" 
                                   placeholder="your@email.com" 
                                   value="{{ old('email') }}" required autofocus>
                            @error('email')
                                <small class="text-danger">{!! $message !!}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="login_password">Пароль <span style="color: red;">*</span></label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="login_password" 
                                   placeholder="••••••••" required>
                            @error('password')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                <label class="form-check-label" for="remember">Запомнить меня</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary py-3 px-5 w-100">Войти</button>
                        </div>
                    </form>

                    <div class="text-center mt-3">
                        <a href="{{ route('password.request') }}" style="color: #82ae46;">Забыли пароль?</a>
                    </div>
                </div>
            </div>

            <!-- Регистрация -->
            <div class="col-md-6 mb-4">
                <div class="contact-wrap w-100 p-4" style="background: white; border-radius: 10px; box-shadow: 0 0 20px rgba(0,0,0,0.1); height: 100%;">
                    <h3 class="mb-4 text-center"><i class="fas fa-user-plus"></i> Регистрация</h3>
                    <p class="text-center text-muted mb-4">Создайте аккаунт для удобных покупок</p>

                    <form action="{{ route('register') }}" method="POST" class="contactForm">
                        @csrf

                        <div class="form-group">
                            <label for="register_name">Ваше имя <span style="color: red;">*</span></label>
                            <input type="text" class="form-control" name="name" id="register_name" 
                                   placeholder="Иван Петров" 
                                   value="{{ old('name') }}" required>
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="register_email">Email <span style="color: red;">*</span></label>
                            <input type="email" class="form-control" name="email" id="register_email" 
                                   placeholder="your@email.com" 
                                   value="{{ old('email') }}" required>
                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="register_password">Пароль <span style="color: red;">*</span></label>
                            <input type="password" class="form-control" name="password" id="register_password" 
                                   placeholder="Минимум 8 символов" required>
                            @error('password')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="register_password_confirmation">Подтвердите пароль <span style="color: red;">*</span></label>
                            <input type="password" class="form-control" name="password_confirmation" id="register_password_confirmation" 
                                   placeholder="Повторите пароль" required>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary py-3 px-5 w-100">Зарегистрироваться</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="row justify-content-center mt-4">
            <div class="col-md-8 text-center">
                <div class="p-4" style="background: #f8f9fa; border-radius: 10px;">
                    <h5><i class="fas fa-lightbulb"></i> Преимущества регистрации:</h5>
                    <div class="row mt-3">
                        <div class="col-md-4">
                            <i class="fas fa-truck" style="font-size: 32px; color: #82ae46;"></i>
                            <p class="mt-2 mb-0"><strong>Быстрое оформление</strong><br><small class="text-muted">Сохраненные адреса</small></p>
                        </div>
                        <div class="col-md-4">
                            <i class="fas fa-history" style="font-size: 32px; color: #82ae46;"></i>
                            <p class="mt-2 mb-0"><strong>История заказов</strong><br><small class="text-muted">Отслеживание статусов</small></p>
                        </div>
                        <div class="col-md-4">
                            <i class="fas fa-star" style="font-size: 32px; color: #82ae46;"></i>
                            <p class="mt-2 mb-0"><strong>Специальные предложения</strong><br><small class="text-muted">Для постоянных клиентов</small></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection


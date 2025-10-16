@extends('frontend.layout')

@section('title', 'Регистрация - GreenPlant')

@section('content')
<div class="hero-wrap hero-bread" style="background-image: url('{{ asset('assets/images/bg_6.jpg') }}'); background-size: cover; background-position: center;">
    <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center" style="height: 300px;">
            <div class="col-md-9 ftco-animate text-center">
                <h1 class="mb-0 bread">Регистрация</h1>
            </div>
        </div>
    </div>
</div>

<!-- Breadcrumbs Section -->
<section class="breadcrumbs-section bg-white py-3" style="border-bottom: 1px solid #e9ecef;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <p class="breadcrumbs mb-0">
                    <span class="mr-2"><a href="{{ route('home') }}">Главная</a></span>
                    <span>Регистрация</span>
                </p>
            </div>
        </div>
    </div>
</section>

<section class="ftco-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="contact-wrap w-100 p-md-5 p-4" style="background: white; border-radius: 10px; box-shadow: 0 0 20px rgba(0,0,0,0.1);">
                    <h3 class="mb-4 text-center"><i class="fas fa-user-plus"></i> Создать аккаунт</h3>
                    <p class="text-center text-muted mb-4">Зарегистрируйтесь, чтобы отслеживать заказы и сохранять адреса доставки</p>

                    <form action="{{ route('register') }}" method="POST" class="contactForm">
                        @csrf

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name">Ваше имя <span style="color: red;">*</span></label>
                                    <input type="text" class="form-control" name="name" id="name" 
                                           placeholder="Иван Петров" 
                                           value="{{ old('name') }}" required>
                                    @error('name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="email">Email <span style="color: red;">*</span></label>
                                    <input type="email" class="form-control" name="email" id="email" 
                                           placeholder="your@email.com" 
                                           value="{{ old('email') }}" required>
                                    @error('email')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="password">Пароль <span style="color: red;">*</span></label>
                                    <input type="password" class="form-control" name="password" id="password" 
                                           placeholder="Минимум 8 символов" required>
                                    @error('password')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                    <small class="form-text text-muted">Используйте буквы, цифры и специальные символы</small>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="password_confirmation">Подтвердите пароль <span style="color: red;">*</span></label>
                                    <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" 
                                           placeholder="Повторите пароль" required>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary py-3 px-5">Зарегистрироваться</button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="text-center mt-4">
                        <p class="text-muted">Уже есть аккаунт? <a href="{{ route('login') }}" style="color: #82ae46; font-weight: 600;">Войти</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection


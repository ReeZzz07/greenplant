<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добавить пользователя - GreenPlant</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: #f5f7fa; color: #333; }
        .header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 20px 40px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .header-content { display: flex; justify-content: space-between; align-items: center; }
        .header h1 { font-size: 24px; }
        .back-link { background: rgba(255,255,255,0.2); color: white; padding: 8px 20px; border-radius: 8px; text-decoration: none; }
        .back-link:hover { background: rgba(255,255,255,0.3); }
        .container { max-width: 900px; margin: 40px auto; padding: 0 20px; }
        .card { background: white; border-radius: 15px; padding: 40px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
        .form-group { margin-bottom: 25px; }
        label { display: block; margin-bottom: 8px; font-weight: 500; color: #495057; }
        .required { color: #dc3545; }
        input, select { width: 100%; padding: 12px 15px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 15px; }
        input:focus, select:focus { outline: none; border-color: #667eea; }
        .invalid-feedback { color: #dc3545; font-size: 14px; margin-top: 5px; }
        .is-invalid { border-color: #dc3545; }
        .form-text { font-size: 13px; color: #6c757d; margin-top: 5px; }
        .btn { padding: 12px 24px; border-radius: 8px; text-decoration: none; display: inline-block; font-size: 14px; font-weight: 500; border: none; cursor: pointer; margin-right: 10px; }
        .btn-primary { background: #667eea; color: white; }
        .btn-primary:hover { background: #5568d3; }
        .btn-secondary { background: #6c757d; color: white; }
        .info-box { background: #e7f3ff; padding: 20px; border-radius: 10px; border-left: 4px solid #007bff; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-content">
            <h1>➕ Добавить нового пользователя</h1>
            <a href="{{ route('admin.users.index') }}" class="back-link">← Назад к списку</a>
        </div>
    </div>

    <div class="container">
        <div class="card">
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label>Имя пользователя <span class="required">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" 
                           class="@error('name') is-invalid @enderror" 
                           placeholder="Иван Петров" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Email <span class="required">*</span></label>
                    <input type="email" name="email" value="{{ old('email') }}" 
                           class="@error('email') is-invalid @enderror" 
                           placeholder="user@greenplant.ru" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-text">Email будет использоваться для входа в систему</div>
                </div>

                <div class="form-group">
                    <label>Пароль <span class="required">*</span></label>
                    <input type="password" name="password" 
                           class="@error('password') is-invalid @enderror" 
                           placeholder="Минимум 8 символов" required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-text">Используйте надежный пароль</div>
                </div>

                <div class="form-group">
                    <label>Подтвердите пароль <span class="required">*</span></label>
                    <input type="password" name="password_confirmation" 
                           placeholder="Повторите пароль" required>
                </div>

                <div class="form-group">
                    <label>Роль <span class="required">*</span></label>
                    <select name="role" class="@error('role') is-invalid @enderror" required>
                        <option value="">Выберите роль...</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->name }}" {{ old('role') == $role->name ? 'selected' : '' }}>
                                @if($role->name === 'admin')
                                    👑 Администратор
                                @elseif($role->name === 'content-manager')
                                    ✏️ Контент-менеджер
                                @else
                                    {{ ucfirst($role->name) }}
                                @endif
                            </option>
                        @endforeach
                    </select>
                    @error('role')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div style="margin-top: 30px;">
                    <button type="submit" class="btn btn-primary">💾 Создать пользователя</button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">❌ Отмена</a>
                </div>
            </form>

            <div class="info-box">
                <h4 style="margin-bottom: 10px;">ℹ️ Информация</h4>
                <p style="margin: 0; line-height: 1.6;"><strong>Администратор</strong> - полный доступ ко всем функциям<br>
                <strong>Контент-менеджер</strong> - управление контентом без доступа к заказам и настройкам</p>
            </div>
        </div>
    </div>
</body>
</html>

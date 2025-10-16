<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Редактировать пользователя - GreenPlant</title>
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
        .alert { padding: 15px 20px; border-radius: 10px; margin-bottom: 20px; background: #d1ecf1; color: #0c5460; border: 1px solid #bee5eb; }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-content">
            <h1>✏️ Редактировать пользователя</h1>
            <a href="{{ route('admin.users.index') }}" class="back-link">← Назад к списку</a>
        </div>
    </div>

    <div class="container">
        <div class="card">
            @if($user->id === auth()->id())
                <div class="alert">ℹ️ Вы редактируете свой собственный аккаунт</div>
            @endif

            <form action="{{ route('admin.users.update', $user) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label>Имя пользователя <span class="required">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" 
                           class="@error('name') is-invalid @enderror" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Email <span class="required">*</span></label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" 
                           class="@error('email') is-invalid @enderror" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Новый пароль</label>
                    <input type="password" name="password" 
                           class="@error('password') is-invalid @enderror" 
                           placeholder="Оставьте пустым, чтобы не менять">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-text">Заполните только если хотите изменить пароль (минимум 8 символов)</div>
                </div>

                <div class="form-group">
                    <label>Подтвердите новый пароль</label>
                    <input type="password" name="password_confirmation" 
                           placeholder="Повторите новый пароль">
                </div>

                <div class="form-group">
                    <label>Роль <span class="required">*</span></label>
                    <select name="role" class="@error('role') is-invalid @enderror" required>
                        @foreach($roles as $role)
                            <option value="{{ $role->name }}" 
                                    {{ old('role', $user->roles->first()?->name) == $role->name ? 'selected' : '' }}>
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
                    <button type="submit" class="btn btn-primary">💾 Сохранить изменения</button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">❌ Отмена</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>

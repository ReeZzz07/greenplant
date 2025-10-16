@extends('frontend.layout')

@section('title', 'Адреса доставки - GreenPlant')

@section('content')
@include('frontend.account.partials.hero', ['title' => 'Адреса доставки'])

<!-- Breadcrumbs Section -->
<section class="breadcrumbs-section bg-white py-3" style="border-bottom: 1px solid #e9ecef;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <p class="breadcrumbs mb-0">
                    <span class="mr-2"><a href="{{ route('home') }}">Главная</a></span>
                    <span class="mr-2"><a href="{{ route('account.dashboard') }}">Кабинет</a></span>
                    <span>Адреса</span>
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

            <!-- Addresses -->
            <div class="col-md-9">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4><i class="fas fa-map-marker-alt"></i> Мои адреса</h4>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addAddressModal">
                        Добавить адрес
                    </button>
                </div>

                @if($addresses->count() > 0)
                    <div class="row">
                        @foreach($addresses as $address)
                            <div class="col-md-6 mb-4">
                                <div class="card p-4" style="border-radius: 10px; box-shadow: 0 0 15px rgba(0,0,0,0.1); {{ $address->is_default ? 'border: 2px solid #82ae46;' : '' }}">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <h5 style="margin: 0;">{{ $address->label }}</h5>
                                        @if($address->is_default)
                                            <span class="badge badge-success">Основной</span>
                                        @endif
                                    </div>
                                    
                                    <p style="margin: 10px 0 5px;"><strong>{{ $address->full_name }}</strong></p>
                                    <p style="margin: 0;"><small>{{ $address->phone }}</small></p>
                                    <hr>
                                    <p style="margin: 0;">{{ $address->full_address }}</p>
                                    @if($address->comment)
                                        <p style="margin: 10px 0 0;"><small class="text-muted">{{ $address->comment }}</small></p>
                                    @endif
                                    
                                    <div class="mt-3 d-flex gap-2" style="gap: 10px;">
                                        @if(!$address->is_default)
                                            <form action="{{ route('account.addresses.set-default', $address->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline-success">Сделать основным</button>
                                            </form>
                                        @endif
                                        <button type="button" class="btn btn-sm btn-outline-warning" 
                                                onclick="editAddress({{ $address->id }}, '{{ $address->label }}', '{{ $address->full_name }}', '{{ $address->phone }}', '{{ $address->city }}', '{{ $address->address }}', '{{ $address->postal_code }}', '{{ $address->comment }}', {{ $address->is_default ? 'true' : 'false' }})">
                                            Редактировать
                                        </button>
                                        <form action="{{ route('account.addresses.destroy', $address->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" 
                                                    onclick="return confirm('Удалить этот адрес?')">
                                                Удалить
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="card p-5 text-center" style="background: white; border-radius: 10px; box-shadow: 0 0 15px rgba(0,0,0,0.1);">
                        <i class="fas fa-map-marker-alt" style="font-size: 64px; color: #ccc;"></i>
                        <p class="text-muted mt-3">У вас пока нет сохраненных адресов</p>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addAddressModal">
                            Добавить первый адрес
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

<!-- Modal Добавить адрес -->
<div class="modal fade" id="addAddressModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-plus-circle"></i> Добавить адрес</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form action="{{ route('account.addresses.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Название адреса</label>
                                <input type="text" class="form-control" name="label" placeholder="Дом, Работа, Дача..." required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Получатель</label>
                                <input type="text" class="form-control" name="full_name" value="{{ auth()->user()->name }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Телефон</label>
                                <input type="text" class="form-control" name="phone" placeholder="+7 (999) 123-45-67" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Город</label>
                                <input type="text" class="form-control" name="city" placeholder="Москва" required>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label>Адрес</label>
                                <input type="text" class="form-control" name="address" placeholder="Улица, дом, квартира" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Индекс</label>
                                <input type="text" class="form-control" name="postal_code" placeholder="101000">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Комментарий</label>
                                <textarea class="form-control" name="comment" rows="2" placeholder="Подъезд, этаж, домофон..."></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="is_default" id="is_default" value="1">
                                <label class="form-check-label" for="is_default">Сделать основным адресом</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                    <button type="submit" class="btn btn-primary">Сохранить адрес</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Редактировать адрес -->
<div class="modal fade" id="editAddressModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-edit"></i> Редактировать адрес</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="editAddressForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Название адреса</label>
                                <input type="text" class="form-control" name="label" id="edit_label" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Получатель</label>
                                <input type="text" class="form-control" name="full_name" id="edit_full_name" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Телефон</label>
                                <input type="text" class="form-control" name="phone" id="edit_phone" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Город</label>
                                <input type="text" class="form-control" name="city" id="edit_city" required>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label>Адрес</label>
                                <input type="text" class="form-control" name="address" id="edit_address" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Индекс</label>
                                <input type="text" class="form-control" name="postal_code" id="edit_postal_code">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Комментарий</label>
                                <textarea class="form-control" name="comment" id="edit_comment" rows="2"></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="is_default" id="edit_is_default" value="1">
                                <label class="form-check-label" for="edit_is_default">Сделать основным адресом</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                    <button type="submit" class="btn btn-primary">Сохранить изменения</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function editAddress(id, label, fullName, phone, city, address, postalCode, comment, isDefault) {
    document.getElementById('editAddressForm').action = '/account/addresses/' + id;
    document.getElementById('edit_label').value = label;
    document.getElementById('edit_full_name').value = fullName;
    document.getElementById('edit_phone').value = phone;
    document.getElementById('edit_city').value = city;
    document.getElementById('edit_address').value = address;
    document.getElementById('edit_postal_code').value = postalCode || '';
    document.getElementById('edit_comment').value = comment || '';
    document.getElementById('edit_is_default').checked = isDefault;
    
    $('#editAddressModal').modal('show');
}
</script>
@endsection


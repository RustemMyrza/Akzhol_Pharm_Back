<div class="row">
    @isset($formMode)
        <div class="col-12 col-md-6 col-lg-4">
            <div class="form-group required">
                <label for="product_name" class="control-label">Товар ({{ $orderProduct->vendor_code }})</label>
                <input type="text" class="form-control @error('product_name') is-invalid @enderror"
                       name="product_name" readonly disabled
                       value="{{ isset($orderProduct) ? $orderProduct->product_name : (old('product_name') ?? '') }}"
                       maxlength="255">
                @error('product_name')
                <span class="error invalid-feedback"> {{ $message }} </span>
                @enderror
            </div>
        </div>
    @else
        <div class="col-12 col-md-6 col-lg-3">
            <div class="form-group required">
                <label for="product_id" class="control-label">Товар </label>
                <select name="product_id" class="form-control select2" style="width: 100%;">
                    <option value="">Выберите товар ...</option>
                    @forelse($products as $product)
                        <option value="{{ $product->id }}"
                            {{ (isset($orderProduct) && $orderProduct->product_id == $product->id)
                                ? 'selected' : (old('product_id') == $product->id ? 'selected' : '')  }}>
                            {{ $product->titleTranslate?->ru }} ({{ $product->vendor_code  }})
                        </option>
                    @empty
                        <option selected disabled>
                            Товары не найдены
                        </option>
                    @endforelse
                </select>
                @error('product_id')
                <span class="error invalid-feedback"> {{ $message }} </span>
                @enderror
            </div>
        </div>
    @endisset

    <div class="col-12 col-md-6 col-lg-2 d-none">
        <div class="form-group required">
            <label for="product_name" class="control-label">Товар </label>
            <input type="text" class="form-control @error('product_name') is-invalid @enderror"
                   name="product_name"
                   value="{{ isset($orderProduct) ? $orderProduct->product_name : (old('product_name') ?? '') }}"
                   maxlength="255">
            @error('product_name')
            <span class="error invalid-feedback"> {{ $message }} </span>
            @enderror
        </div>
    </div>

    <div class="col-12 col-md-6 col-lg-2 d-none">
        <div class="form-group required">
            <label for="vendor_code" class="control-label">Артикул </label>
            <input type="text" class="form-control @error('vendor_code') is-invalid @enderror"
                   name="vendor_code"
                   value="{{ isset($orderProduct) ? $orderProduct->vendor_code : (old('vendor_code') ?? '') }}"
                   maxlength="255">
            @error('vendor_code')
            <span class="error invalid-feedback"> {{ $message }} </span>
            @enderror
        </div>
    </div>

    <div class="col-12 col-md-6 col-lg-2">
        <div class="form-group">
            <label for="price" class="control-label">Цена </label>
            <input type="number" class="form-control @error('price') is-invalid @enderror" name="price"
                   value="{{ isset($orderProduct) ? $orderProduct->price : (old('price') ?? 0) }}">
            @error('price')
            <span class="error invalid-feedback"> {{ $message }} </span>
            @enderror
        </div>
    </div>

    <div class="col-12 col-md-6 col-lg-1">
        <div class="form-group">
            <label for="quantity" class="control-label">Количество </label>
            <input type="number" class="form-control @error('quantity') is-invalid @enderror" name="quantity"
                   value="{{ isset($orderProduct) ? $orderProduct->quantity : (old('quantity') ?? 0) }}">
            @error('quantity')
            <span class="error invalid-feedback"> {{ $message }} </span>
            @enderror
        </div>
    </div>

    <div class="col-12 col-md-6 col-lg-1">
        <div class="form-group">
            <label for="discount" class="control-label">Скидка </label>
            <input type="number" class="form-control @error('discount') is-invalid @enderror" name="discount" min="0"
                   max="100"
                   value="{{ isset($orderProduct) ? $orderProduct->discount : (old('discount') ?? 0) }}">
            @error('discount')
            <span class="error invalid-feedback"> {{ $message }} </span>
            @enderror
        </div>
    </div>

    <div class="col-12 col-md-12 col-lg-2">
        <div class="form-group">
            <label for="total_price" class="control-label">Обшая цена </label>
            <input type="number" class="form-control @error('total_price') is-invalid @enderror" name="total_price"
                   value="{{ isset($orderProduct) ? $orderProduct->total_price : (old('total_price') ?? 0) }}">
            @error('total_price')
            <span class="error invalid-feedback"> {{ $message }} </span>
            @enderror
        </div>
    </div>

    @isset($formMode)
        <div class="col-12 col-md-6 col-lg-2">
            <div class="form-group ">
                <label for="quantity" class="control-label"> &nbsp; </label>
                <button type="submit" class="btn btn-primary form-control">
                    Обновить
                </button>
            </div>
        </div>
    @else
        <div class="col-12 col-md-6 col-lg-2">
            <div class="form-group ">
                <label for="quantity" class="control-label"> &nbsp; </label>
                <button type="submit" class="btn btn-primary form-control">
                    <i class="fas fa-plus"></i>
                    Добавить
                </button>
            </div>
        </div>
    @endisset
</div>

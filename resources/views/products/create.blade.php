<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ $direction ?? (app()->getLocale() === 'ar' ? 'rtl' : 'ltr') }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.msg_product_created') }} — {{ __('messages.store_name') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600&family=Inter:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        body {
            background-color: var(--color-onyx-canvas);
            padding: 40px 20px;
        }
        .form-container {
            max-width: 640px;
            margin: 0 auto;
            background-color: var(--color-graphite-card);
            padding: var(--card-padding);
            border-radius: var(--radius-cards);
            border: 1px solid rgba(226, 227, 237, 0.04);
            text-align: start;
        }
        h1 {
            color: var(--color-ivory-text);
            font-size: var(--text-heading-sm);
            font-weight: 480;
            margin-bottom: 2rem;
        }
        .form-group {
            margin-bottom: 1.25rem;
        }
        label {
            display: block;
            margin-bottom: 0.5rem;
            color: var(--color-ash-text);
            font-size: var(--text-body-sm);
            font-weight: 400;
        }
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }
        .form-buttons {
            display: flex;
            gap: 12px;
            margin-top: 2rem;
        }
        .btn-submit {
            flex: 1;
            padding: 13px 24px;
            background-color: var(--color-cobalt);
            color: var(--color-pure-white);
            border: none;
            border-radius: var(--radius-buttons);
            cursor: pointer;
            font-size: var(--text-body-sm);
            font-weight: 480;
            transition: background-color 0.2s ease;
        }
        .btn-submit:hover {
            background-color: var(--color-cobalt-hover);
        }
        .btn-cancel {
            flex: 1;
            padding: 13px 24px;
            background-color: transparent;
            color: var(--color-ivory-text);
            border: 1px solid rgba(226, 227, 237, 0.2);
            border-radius: var(--radius-buttons);
            text-decoration: none;
            text-align: center;
            font-size: var(--text-body-sm);
            transition: all 0.2s ease;
        }
        .btn-cancel:hover {
            background-color: var(--color-obsidian-button);
            color: var(--color-pure-white);
        }
        .error {
            color: #fca5a5;
            font-size: var(--text-caption);
            margin-top: 5px;
        }
        .errors {
            background-color: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.2);
            color: #fca5a5;
            padding: 14px 18px;
            border-radius: var(--radius-cards);
            margin-bottom: 24px;
            font-size: var(--text-body-sm);
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h1>🌱 {{ __('messages.product_create_title') }}</h1>
        @if ($errors->any())
            <div class="errors">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="category_id">{{ __('messages.form_category') }}</label>
                <select name="category_id" id="category_id" required>
                    <option value="">{{ __('messages.form_select_category') }}</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
                @error('category_id')<div class="error">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label for="name">{{ __('messages.form_product_name') }}</label>
                <input type="text" name="name" id="name" required value="{{ old('name') }}">
                @error('name')<div class="error">{{ $message }}</div>@enderror
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="price">{{ __('messages.form_price') }}</label>
                    <input type="number" name="price" id="price" required step="0.01" min="0" value="{{ old('price') }}" placeholder="0.00">
                    @error('price')<div class="error">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label for="quantity">{{ __('messages.form_quantity') }}</label>
                    <input type="number" name="quantity" id="quantity" required min="0" value="{{ old('quantity') }}" placeholder="0">
                    @error('quantity')<div class="error">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="form-group">
                <label for="description">{{ __('messages.form_description') }}</label>
                <textarea name="description" id="description">{{ old('description') }}</textarea>
                @error('description')<div class="error">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label for="image">{{ __('messages.form_image') }}</label>
                <input type="file" name="image" id="image" accept="image/*" style="border-radius: var(--radius-cards); padding: 10px;">
                @error('image')<div class="error">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label for="video">{{ __('messages.form_video') }}</label>
                <input type="text" name="video" id="video" value="{{ old('video') }}">
                @error('video')<div class="error">{{ $message }}</div>@enderror
            </div>
            <div class="form-buttons">
                <button type="submit" class="btn-submit">{{ __('messages.btn_add_product') }}</button>
                <a href="{{ route('products.index') }}" class="btn-cancel">{{ __('messages.btn_cancel') }}</a>
            </div>
        </form>
    </div>
</body>
</html>

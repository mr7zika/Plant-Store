<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تعديل {{ $product->name }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Arial', sans-serif; background-color: #f8f9fa; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        h1 { color: #1e3a8a; margin-bottom: 30px; text-align: right; }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; color: #1e3a8a; font-weight: bold; text-align: right; }
        input, textarea, select { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-family: 'Arial', sans-serif; }
        input:focus, textarea:focus, select:focus { outline: none; border-color: #2563eb; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; }
        textarea { resize: vertical; min-height: 100px; }
        .form-buttons { display: flex; gap: 10px; margin-top: 30px; }
        .btn-submit, .btn-cancel { flex: 1; padding: 12px; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; font-weight: 600; transition: all 0.3s; }
        .btn-submit { background-color: #2563eb; color: white; }
        .btn-submit:hover { background-color: #1e3a8a; }
        .btn-cancel { background-color: #64748b; color: white; text-decoration: none; text-align: center; }
        .btn-cancel:hover { background-color: #475569; }
        .error { color: #dc3545; font-size: 14px; margin-top: 5px; }
        .errors { background-color: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; padding: 15px; border-radius: 4px; margin-bottom: 20px; }
        .current-image { margin-top: 10px; max-width: 150px; border-radius: 4px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>✏️ تعديل {{ $product->name }}</h1>
        @if ($errors->any())
            <div class="errors">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="form-group">
                <label for="category_id">الفئة *</label>
                <select name="category_id" id="category_id" required>
                    <option value="">اختر فئة</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
                @error('category_id')<div class="error">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label for="name">اسم المنتج *</label>
                <input type="text" name="name" id="name" required value="{{ old('name', $product->name) }}">
                @error('name')<div class="error">{{ $message }}</div>@enderror
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="price">السعر (ريال) *</label>
                    <input type="number" name="price" id="price" required step="0.01" min="0" value="{{ old('price', $product->price) }}">
                    @error('price')<div class="error">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label for="quantity">الكمية *</label>
                    <input type="number" name="quantity" id="quantity" required min="0" value="{{ old('quantity', $product->quantity) }}">
                    @error('quantity')<div class="error">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="form-group">
                <label for="description">الوصف</label>
                <textarea name="description" id="description">{{ old('description', $product->description) }}</textarea>
                @error('description')<div class="error">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label for="image">الصورة</label>
                @if($product->image)
                    <p style="color: #666; font-size: 14px; margin-bottom: 10px;">الصورة الحالية:</p>
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="current-image">
                @endif
                <input type="file" name="image" id="image" accept="image/*">
                @error('image')<div class="error">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label for="video">رابط الفيديو</label>
                <input type="text" name="video" id="video" value="{{ old('video', $product->video) }}">
                @error('video')<div class="error">{{ $message }}</div>@enderror
            </div>
            <div class="form-buttons">
                <button type="submit" class="btn-submit">حفظ التغييرات</button>
                <a href="{{ route('products.show', $product) }}" class="btn-cancel">إلغاء</a>
            </div>
        </form>
    </div>
</body>
</html>

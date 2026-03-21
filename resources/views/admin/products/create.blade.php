@extends('layouts.admin')

@section('page-title', 'Add New Product')

@section('content')
<div class="card" style="background: white; padding: 2rem; border-radius: 12px; box-shadow: var(--shadow); max-width: 800px; margin: 0 auto;">
    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div style="margin-bottom: 2rem; border-bottom: 2px solid #f1f5f9; padding-bottom: 1rem;">
            <div style="display: flex; gap: 1rem; margin-bottom: 1rem;">
                <button type="button" onclick="switchLang('en')" id="btn-en" style="padding: 8px 16px; border-radius: 6px; border: 1px solid #e2e8f0; background: #6366f1; color: white; cursor: pointer; font-weight: 600;">English</button>
                <button type="button" onclick="switchLang('ar')" id="btn-ar" style="padding: 8px 16px; border-radius: 6px; border: 1px solid #e2e8f0; background: white; color: #64748b; cursor: pointer; font-weight: 600;">العربية (Arabic)</button>
            </div>

            <div id="lang-en">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                    <div class="form-group">
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Product Name (EN) *</label>
                        <input type="text" name="name_en" class="form-control" required style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 8px;">
                    </div>
                    <div class="form-group">
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">ERP Code (Unique)</label>
                        <input type="text" name="code" class="form-control" placeholder="E.g. KT-001" style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 8px;">
                    </div>
                </div>
                <div class="form-group" style="margin-bottom: 1.5rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Description (EN)</label>
                    <textarea name="description_en" rows="4" style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 8px;"></textarea>
                </div>
            </div>

            <div id="lang-ar" style="display: none;" dir="rtl">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                    <div class="form-group">
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">اسم المنتج (AR) *</label>
                        <input type="text" name="name_ar" class="form-control" required style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 8px;">
                    </div>
                    <div class="form-group">
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">كود المنتج (ERP)</label>
                        <input type="text" disabled value="Unique Code" style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 8px; background: #f8fafc; color: #94a3b8;">
                    </div>
                </div>
                <div class="form-group" style="margin-bottom: 1.5rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">الوصف (AR)</label>
                    <textarea name="description_ar" rows="4" style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 8px;"></textarea>
                </div>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
            <div class="form-group">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Category *</label>
                <select name="category_id" class="form-control" required style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 8px;">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Stock Quantity *</label>
                <input type="number" name="stock_quantity" class="form-control" required min="0" style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 8px;">
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
            <div class="form-group">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Standard Price (Piece) *</label>
                <input type="number" name="price" step="0.01" class="form-control" required style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 8px;">
            </div>
            <div class="form-group">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Package Price</label>
                <input type="number" name="package_price" step="0.01" class="form-control" style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 8px;">
            </div>
        </div>

        <script>
            function switchLang(lang) {
                document.getElementById('lang-en').style.display = lang === 'en' ? 'block' : 'none';
                document.getElementById('lang-ar').style.display = lang === 'ar' ? 'block' : 'none';
                
                document.getElementById('btn-en').style.background = lang === 'en' ? '#6366f1' : 'white';
                document.getElementById('btn-en').style.color = lang === 'en' ? 'white' : '#64748b';
                
                document.getElementById('btn-ar').style.background = lang === 'ar' ? '#6366f1' : 'white';
                document.getElementById('btn-ar').style.color = lang === 'ar' ? 'white' : '#64748b';
            }
        </script>

        <div class="form-group" style="margin-bottom: 1.5rem;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Product Image</label>
            <input type="file" name="image" style="width: 100%;">
        </div>

        <div class="form-group" style="margin-bottom: 2rem;">
            <label style="display: flex; align-items: center; gap: 0.5rem; font-weight: 600; cursor: pointer;">
                <input type="checkbox" name="is_visible" value="1" checked>
                Visible on Public Site
            </label>
        </div>

        <div style="display: flex; gap: 1rem; justify-content: flex-end;">
            <a href="{{ route('admin.products.index') }}" style="padding: 10px 20px; border: 1px solid #e2e8f0; border-radius: 8px; text-decoration: none; color: #64748b;">Cancel</a>
            <button type="submit" style="padding: 10px 25px; background: var(--primary); color: black; border: 1px solid #e2e8f0 ; border-radius: 8px; cursor: pointer; font-weight: 600;">Create Product</button>
        </div>
    </form>
</div>
@endsection

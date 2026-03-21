@extends('layouts.admin')

@section('page-title', 'Add Category')

@section('content')
<div class="card" style="background: white; padding: 2rem; border-radius: 12px; box-shadow: var(--shadow); max-width: 600px; margin: 0 auto;">
    <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf

        <div style="margin-bottom: 2rem; border-bottom: 2px solid #f1f5f9; padding-bottom: 1rem;">
            <div style="display: flex; gap: 1rem; margin-bottom: 1rem;">
                <button type="button" onclick="switchLang('en')" id="btn-en" style="padding: 8px 16px; border-radius: 6px; border: 1px solid #e2e8f0; background: #6366f1; color: white; cursor: pointer; font-weight: 600;">English</button>
                <button type="button" onclick="switchLang('ar')" id="btn-ar" style="padding: 8px 16px; border-radius: 6px; border: 1px solid #e2e8f0; background: white; color: #64748b; cursor: pointer; font-weight: 600;">العربية (Arabic)</button>
            </div>

            <div id="lang-en">
                <div class="form-group" style="margin-bottom: 1.5rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Category Name (EN) *</label>
                    <input type="text" name="name_en" class="form-control" required style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 8px;">
                </div>

            </div>

            {{-- <div id="lang-ar" style="display: none;" dir="rtl">
                <div class="form-group" style="margin-bottom: 1.5rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">اسم القسم (AR) *</label>
                    <input type="text" name="name_ar" class="form-control" required style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 8px;">
                </div>

            </div> --}}
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

        <div style="display: flex; gap: 1rem; justify-content: flex-end;">
            <a href="{{ route('admin.categories.index') }}" style="padding: 10px 20px; border: 1px solid #e2e8f0; border-radius: 8px; text-decoration: none; color: #64748b;">Cancel</a>
            <button type="submit" style="padding: 10px 25px; background: var(--primary); color: black; border: 1px solid #64748b; border-radius: 8px; cursor: pointer; font-weight: 600;">Create Category</button>
        </div>
    </form>
</div>
@endsection

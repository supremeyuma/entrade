@extends('layouts.admin')

@section('content')
<div class="p-6 max-w-xl mx-auto">
    <h1 class="text-2xl font-bold mb-4">Edit FAQ Category</h1>
    <form action="{{ route('admin.faq-categories.update', $faqCategory) }}" method="POST">
        @method('PUT')
        @include('admin.faq_categories.form')
        <button class="mt-4 bg-indigo-600 text-white px-4 py-2 rounded">Update</button>
    </form>
</div>
@endsection

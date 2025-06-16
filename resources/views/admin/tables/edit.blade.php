@extends('layouts.admin')
@section('title', 'Edit Meja')
@section('content')
<h1 class="text-3xl font-bold mb-8">Edit Meja: {{ $table->name }}</h1>
<div class="bg-white dark:bg-gray-800 p-8 rounded-lg shadow-lg max-w-2xl mx-auto">
    <form action="{{ route('admin.tables.update', $table->id) }}" method="POST">
        @csrf
        @method('PUT')
        @include('admin.tables._form', ['table' => $table])
        <div class="flex justify-end mt-6">
            <button type="submit" class="bg-indigo-600 text-white font-bold py-2 px-4 rounded">Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection
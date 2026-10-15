@extends('layouts.app')

@section('title', 'Edit Peserta')

@section('content')
<div class="max-w-3xl mx-auto bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm p-6">
    <h2 class="text-xl font-bold text-slate-800 dark:text-white mb-6">Form Edit Peserta Sertifikasi</h2>

    <form action="{{ route('peserta.update', $peserta) }}" method="POST">
        @method('PUT')
        @include('peserta._form', ['submitButtonText' => 'Perbarui'])
    </form>
</div>
@endsection

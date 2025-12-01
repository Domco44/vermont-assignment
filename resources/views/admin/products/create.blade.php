@extends('admin.layout')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">{{__('Create Product')}}</h1>
        @include('admin.products.form')
    </div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Inventory</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('items.store') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Item') }}</label>

                            <div class="col-md-6">
                                <input id="item" type="text" class="form-control @error('name') is-invalid @enderror" name="item[name]" value="{{ old('item[name]') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Add') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="card-body">
                    @foreach($items as $item)
                        

                        <form method="POST" action="{{ route('items.destroy', [$item->id]) }}">
                        @csrf
                        <input type="hidden" name="_method" value="delete" />

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{$item->name}}</label>

                            <div class="col-md-6">
                                <button type="submit" class="btn btn-danger">
                                    {{ __('Delete') }}
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

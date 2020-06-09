@extends('layouts.app')

@section('content')

<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-6 mt-4">
            <div class="card">
                <div class="card-header">Admin</div>

                <div class="card-body">
                    <div>
                        

                        <form method="POST" action="{{ route('company.update', [$user->id]) }}">
                            @csrf
                            <input type="hidden" name="_method" value="patch" />

                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="name" class="col-form-label text-md-right">{{ __('Customer Calendar Link (share with your customers)') }}</label>
                                </div>

                                <div class="col-md-6">
                                    <a href="/customer/bookings/{{$user->customer_link}}">View</a>
                                </div>
                            </div>

                            <hr/>

                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="name" class="col-form-label text-md-right">{{ __('Booking Page Info') }}</label>
                                </div>

                                <div class="col-md-6">
                                    <textarea class="form-control" name="company[customer_page_info]">{{$user->customer_page_info}}</textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Update') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                        
                    </div>
                </div>

             
            </div>
        </div>

    
        <div class="col-md-6 mt-4">
            <div class="card">
                <div class="card-header">Inventory <small><b>Manage Iventory</b></small></div>

             
                <div class="card-body">
                    <small><b>New Item</b></small>
                    <form method="POST" action="{{ route('items.store') }}">
                        @csrf

                        <div class="form-group row">

                            <div class="col-md-2">
                                <label for="name" class="col-form-label text-md-right">{{ __('Item') }}</label>
                            </div>

                            <div class="col-md-4">
                                <input placeholder="Item Name" id="item" type="text" class="form-control @error('item[name]') is-invalid @enderror" name="item[name]" value="{{ old('item[name]') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-2">
                                <input id="quantity" type="number" class="form-control @error('item[quantity]') is-invalid @enderror" name="item[quantity]" value="1" required >

                                @error('quantity')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Add') }}
                                </button>
                            </div>

                        </div>
                        
                    </form>
                </div>

                <hr/>


                <div class="card-body">
                    <small><b>Current Items</b></small>
                    @foreach($items as $item)                           

                        <div class="row">

                         

                            <div class="col-md-2">
                                <label for="name" class="col-form-label text-md-right">{{$item->name}}</label>
                            </div>

                            

                            <div class="col-md-4">
                                <form method="POST" action="{{ route('items.update', [$item->id]) }}">
                                    @csrf
                                    <input type="hidden" name="_method" value="patch" />

                                    <div class="row">

                                        <div class="col-md-6">
                                            <input class="form-control" type="number" name="item[quantity]" value="{{$item->quantity}}" />
                                        </div>

                                        <div class="col-md-6">
                                            <button type="submit" class="btn btn-warning">
                                                {{ __('Update') }}
                                            </button>
                                           
                                        </div>

                                    </div>

                                </form>
                            </div>

                            <div class="col-md-2">
                                <form method="POST" action="{{ route('items.destroy', [$item->id]) }}">
                                    @csrf
                                    <input type="hidden" name="_method" value="delete" />
                                    <button type="submit" class="btn btn-danger">
                                        {{ __('Delete') }}
                                    </button>
                                </form>
                            </div>
                            
                           

                        </div>
                        
                    @endforeach
                </div>
            </div>
        </div>

    </div>

    <div class="row justify-content-center mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Bookings <small><b>Manually Enter Booking</b></small></div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                </div>

                <div class="card-body">
                    <small><b>New Booking Items</b></small>
                    <form method="POST" action="company/bookings">
                        @csrf
                        <input type="hidden" name="booking[company_user_id]" value="{{ Auth::user()->id }}"/>


                        <div class="form-group row">

                        @foreach($items as $item)
                            <div class="row col-md-12" >

                                <label for="item" class="col-md-4 col-form-label text-md-right">{{$item->name}} ({{$item->quantity}})</label>

                                <div class="col-md-2">
                                    <input type="checkbox" name="items[{{$item->id}}]" value="1" />
                                </div>
                                <div class="col-md-2">
                                    <input value="1" class="form-control" type="number" name="items_quantity[{{$item->id}}]" />
                                </div>
                            </div>
                        @endforeach

                        </div>
                        <hr/>

                        <small><b>New Booking Info</b></small>

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Date') }}</label>

                            <div class="col-md-6">
                                <input id="bookingDate" type="datetime-local" class="form-control @error('booking[date]') is-invalid @enderror" name="booking[date]" value="{{ old('booking[date]') }}" required autofocus>

                                @error('booking[date]')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="bookingName" type="text" class="form-control @error('booking[name]') is-invalid @enderror" name="booking[name]" value="{{ old('booking[name]') }}" required autofocus>

                                @error('booking[name]')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Email') }}</label>

                            <div class="col-md-6">
                                <input id="bookingEmail" type="email" class="form-control @error('booking[email]') is-invalid @enderror" name="booking[email]" value="{{ old('booking[email]') }}" autofocus>

                                @error('booking[email]')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Telephone') }}</label>

                            <div class="col-md-6">
                                <input id="bookingTelephone" type="telephone" class="form-control @error('booking[telephone]') is-invalid @enderror" name="booking[telephone]" value="{{ old('booking[telephone]') }}" autofocus>

                                @error('booking[email]')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Info') }}</label>

                            <div class="col-md-6">
                                <textarea id="bookingInfo" class="form-control @error('booking[information]') is-invalid @enderror" name="booking[information]" value="{{ old('booking[information]') }}" autofocus></textarea>

                                @error('booking[info]')
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
                    <div id='calendar'></div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@section('scripts')

<script>

    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            header: {
                left: 'prev,next',
                center: 'title',
                right: 'listMonth'
            },
            dateClick: function() {
                calendar.changeView('timeGridDay');
            },
            plugins: [ 'dayGrid','interaction','timeGrid', 'timeGridPlugin', 'list'],
            defaultView: 'listMonth',
            eventLimit: true, // allow "more" link when too many events
           
            events: {!!json_encode($bookingsArray)!!},
            

        });

        calendar.render();
    });

</script>

@endsection
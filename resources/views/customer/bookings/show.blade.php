@extends('layouts.customer')

@section('content')

<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{$parent->company_name}} <small><b>Place a Booking</b></small></div>

               
                <div class="card-body">

                    <small><b>Info</b></small>

                    <div class="row">
                        <div class="row col-md-12" >
                            <div class="col-4">
                                
                            </div>
                            <div class="col-4">
                               {{$parent->customer_page_info}}
                            </div>
                            <div class="col-4">
                                
                            </div>
                        </div>
                    </div>

                    <hr/>

                    <small><b>Items</b></small>
                    <form method="POST" action="/customer/bookings">
                        @csrf
                       
                        <div class="form-group row">

                        @foreach($items as $item)
                            <div class="row col-md-12" >
                                 
                                <div class="col-4" style="text-align:right;">
                                    <input type="checkbox"  name="items[{{$item->id}}]" value="1" style="margin-top: 10px;" />
                                    
                                </div>

                                <div class="col-4">
                                    <label for="item" class="col-form-label text-md-right">{{$item->name}}</label>
                                </div>


                                <div class="col-4">
                                    x<input style="width:50%;display: inline-block;" type="number" class="form-control" name="items_quantity[{{$item->id}}]" value="1" />
                                </div>
                               
                            </div>
                        @endforeach

                        </div>

                        <hr/>

                        <small><b>Booking Info</b></small>

                        @if(Auth::check())
                        <input type="hidden" name="booking[company_user_id]" value="{{ $parent->id }}"/>
                        <input type="hidden" name="booking[email]" value="{{ Auth::user()->email }}"/>
                        <input type="hidden" name="booking[telephone]" value="{{ Auth::user()->telephone }}"/>
                        <input type="hidden" name="booking[name]" value="{{ Auth::user()->name }}"/>

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Date') }}</label>

                            <div class="col-md-8">
                                <input id="bookingDate" type="datetime-local" class="form-control @error('booking[date]') is-invalid @enderror" name="booking[date]" value="{{ old('booking[date]') }}" required autofocus>

                                @error('booking[date]')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                       
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Info') }}</label>

                            <div class="col-md-8">
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
                                    {{ __('Add Booking') }}
                                </button>
                            </div>
                        </div>
                        @else
                         <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                Please signup or login in order to process booking
                            </div>
                        </div>
                        @endif
                    </form>
                </div>
            
                
              <!--   <div class="card-body">
                    <div id='calendar'></div>
                </div> -->
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
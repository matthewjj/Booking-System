@extends('layouts.app')

@section('content')

<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Booking</div>


                <div class="card-body">
                    <form method="POST" action="{{ route('bookings.store') }}">
                        @csrf
                        <input type="hidden" name="booking[company_user_id]" value="{{ Auth::user()->id }}"/>


                        <div class="form-group row">

                        @foreach($items as $item)
                            <div class="row col-md-12" >
                                <label for="item" class="col-md-4 col-form-label text-md-right">{{$item->name}}</label>
                                <div class="col-md-2">
                                    <input type="checkbox" name="items[{{$item->id}}]" value="1" />
                                </div>
                                <div class="col-md-4">
                                    <input type="text "name="items_quantity[{{$item->id}}]" />
                                </div>
                            </div>
                        @endforeach

                        </div>
                        <hr/>

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
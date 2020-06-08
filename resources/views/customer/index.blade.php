@extends('layouts.customer')

@section('content')

<div class="container">

    <div class="col-md-12">
            <div class="card">
                <div class="card-header">Bookings</b></small></div>

               
                <div class="card-body">
                    <small><b>All Bookings</b></small>

                    <table class="table">
                        <thead>
                            <tr>
                            
                                <th>Date</th>
                                <th>Company</th>
                                <th>Infomation</th>

                            </tr>

                        </thead>
                            @foreach($bookings as $booking)
                            <tr>
                            
                                <td>{{date('H:i, d-m-Y', strtotime($booking->date))}}</td>
                                <td>{{$booking->company_name}}</td>
                                <td>{{$booking->information}}</td>

                            </tr>

                            @endforeach

                    </table>

                </div>

            </div>

        </div>

    </div>

</div>
@endsection

@section('scripts')



@endsection
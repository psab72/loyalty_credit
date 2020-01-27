@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @include('includes.alert')
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h4>Notifications</h4>
                                <table class="table table-striped table-bordered table-responsive-md datatable">
                                    <thead>
                                    <th> Date Created</th>
                                    <th> Content</th>
                                    {{--<th> Action</th>--}}
                                    </thead>
                                    <tbody>
                                    @foreach ($notifications as $n)
                                        <tr>
                                            <td> {{ !empty($n->created_at) ? date('M j, Y', strtotime($n->created_at)) : '--' }}</td>
                                            <td>{{ $n->message }}</td>
                                            {{--<td align="center">--}}
                                                {{--<div class="dropdown">--}}
                                                    {{--<a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
                                                        {{--<i class="fa fa-chevron"></i>--}}
                                                    {{--</a>--}}
                                                    {{--<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">--}}
                                                        {{--<a href="{{ url('merchant/' . $m->id) }}" class="dropdown-item">View</a>--}}
                                                        {{--@if(!empty($m->kyc_id))--}}
                                                            {{--<a href="#" class="btn-view-merchant-kyc dropdown-item" data-kyc-id="{{ $m->kyc_id }}" data-toggle="modal" data-target="#kyc-modal">View Merchant Details</a>--}}
                                                        {{--@endif--}}
                                                    {{--</div>--}}
                                                {{--</div>--}}
                                            {{--</td>--}}
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
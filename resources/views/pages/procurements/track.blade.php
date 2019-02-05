@extends('layouts.app')

@section('content')
    @include('includes.sidenav')

    {{-- Right Content --}}
    <div class="body-right">
        <div class="container-fluid">
            <h1>Track Products</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    @if(Auth::user()->type == 'admin')
                        <li class="breadcrumb-item" aria-current="page">
                            <a href="/dashboard">Dashboard</a>
                        </li>
                    @endif
                    <li class="breadcrumb-item" aria-current="page"><a href="/procurement">Procurement</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Track Products</li>
                </ol>
            </nav>

            @include('includes.messages')
            {{--<div class="button-holder text-right">--}}
                {{--<a href="/guide/procurement" class="btn btn-outline-dark mt-1"><i class="fas fa-info-circle"></i> Guide</a>--}}
            {{--</div>--}}

            <div class="lists-table table-responsive mt-3">
                {!! $tracks->appends(\Request::except('page'))->render() !!}
                <table class="table table-hover table-striped py-3 text-center">
                    <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Type</th>
                            <th scope="col">Description</th>
                            <th scope="col">Previous</th>
                            <th scope="col">Updated</th>
                            <th scope="col">Difference</th>
                            <th scope="col">Date modified</th>
                            <th scope="col">Modified by</th>
                            @if(Auth::user()->type == 'admin')
                                <th scope="col">Delete</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($tracks) > 0)
                            @foreach($tracks as $track)
                                <tr>
                                    <td onclick="window.location = '/products/{{$track->product->id}}'" style="cursor: pointer">{{$track->name}}</td>
                                    <td>{{$track->product_type}}</td>
                                    <td>{{$track->desc}}</td>
                                    <td>{{$track->previous}}</td>
                                    <td>{{$track->updated}}</td>
                                    <td>{{$track->updated - $track->previous}}</td>
                                    <td>{{date('D M d\'y H:i', strtotime($track->date_modified))}}</td>
                                    <td>{{$track->user_name}}</td>

                                    @if(Auth::user()->type == 'admin')
                                        <td class="icons">
                                        {!!Form::open(['action' => ['ProductsController@destroyTrack', $track->id], 'method' => 'POST', 'class' => 'delete'])!!}
                                        {{Form::hidden('_method', 'DELETE')}}
                                        {!! Form::button('<i class="fa fa-trash"></i>', ['class'=>'del-btn', 'type'=>'submit']) !!}
                                        {!!Form::close()!!}
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        @else
                        <tr class="text-center">
                            <th colspan="7">No tracks found</th>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>

        </div>
    </div>

@endsection
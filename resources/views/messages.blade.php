<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if (Session::get('flash_success'))
                <div class="alert alert-success">
                    @if(is_array(Session::get('flash_success')))
                        <ul>
                            @foreach(Session::get('flash_success') as $msg)
                                <li>{!! $msg !!}</li>
                            @endforeach
                        </ul>
                    @else
                        {!! Session::get('flash_success') !!}
                    @endif
                </div>
            @endif
            @if (Session::get('flash_warning'))
                <div class="alert alert-warning">
                    @if(is_array(Session::get('flash_warning')))
                        <ul>
                            @foreach(Session::get('flash_warning') as $msg)
                                <li>{!! $msg !!}</li>
                            @endforeach
                        </ul>
                    @else
                        {!! Session::get('flash_warning') !!}
                    @endif
                </div>
            @endif
            @if (Session::get('flash_info'))
                <div class="alert alert-info">
                    @if(is_array(Session::get('flash_info')))
                        <ul>
                            @foreach(Session::get('flash_info') as $msg)
                                <li>{!! $msg !!}</li>
                            @endforeach
                        </ul>
                    @else
                        {!! Session::get('flash_info') !!}
                    @endif
                </div>
            @endif
            @if (Session::get('flash_danger'))
                <div class="alert alert-danger">
                    @if(is_array(Session::get('flash_danger')))
                        <ul>
                            @foreach(Session::get('flash_danger') as $msg)
                                <li>{!! $msg !!}</li>
                            @endforeach
                        </ul>
                    @else
                        {!! Session::get('flash_danger') !!}
                    @endif
                </div>
            @endif
            @if (Session::get('flash_message'))
                <div class="alert alert-info">
                    @if(is_array(Session::get('flash_message')))
                        <ul>
                            @foreach(Session::get('flash_message') as $msg)
                                <li>{!! $msg !!}</li>
                            @endforeach
                        </ul>
                    @else
                        {!! Session::get('flash_message') !!}
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>
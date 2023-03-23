@extends('contents/template')
@section('content')
<body>
<div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center mt-5">

        <div class="col-xl-6 col-lg-10 col-md-9">

            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                       
                        <div class="col-lg-12">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Sign In!</h1>
                                </div>
                                @if(Session::has("error_message"))
                                <div class="alert alert-danger">{{Session::get("error_message")}}</div>
                                {{Session::forget("error_message")}}
                                @endif
                                <form class="user" method="post" action="{{url('/Auth/signin')}}">
                                    @csrf
                                    <div class="form-group">
                                        <input type="text" name="username" class="form-control form-control-user"
                                            id="exampleInputEmail" aria-describedby="emailHelp"
                                            placeholder="Enter Username">
                                    </div>
                                    <button  class="btn btn-primary btn-user btn-block">
                                        Login
                                    </button>

                                </form>
                             
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>
</body>
@endsection
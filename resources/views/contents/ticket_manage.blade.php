@extends('contents/template2')
@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Create Ticket</h1>
            {{-- <a href="{{url("/Dashboard/TicketManage")}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                    class="fas fa-plus fa-sm text-white-50"></i> Add Ticket</a> --}}
        </div>

        <div class="row">
            <div class="card w-100">
                <div class="card-header bg-transparent">
                    <h5 class="card-title">Ticket Information</h5>
                </div>
                <form action="{{url('Dashboard/TicketManage/Ticket/save_ticket')}}" method="post">
                <div class="card-body">
                    <div class="form-group">
                        @csrf
                        <div class="row">
                            <div class="col-1"><label for="">Ticket Title:</label></div>
                            <div class="col-5"><input type="text" class="form-control" name="ticket_title" id="" value="{{$ticket_data[0]["ticket_title"]}}"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-1"><label for="">Status:</label></div>
                            <div class="col-5"><input type="text" class="form-control" name="ticketstatus" id="" value="{{$ticket_data[0]["ticket_status"]}}"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-1"><label for="">Priorities:</label></div>
                            <div class="col-5"><input type="text" class="form-control" name="ticketpriorities" id="" value="{{$ticket_data[0]["ticket_priority"]}}"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-1"><label for="">Assign to:</label></div>
                            <div class="col-5">
                            <select class="form-control" id="select_assign_to" name="assigned_user_id">
                                <option value="" disabled selected>--SELECT ASSIGN--</option>
                                @foreach ($select_users as $item)
                                    <option value="{{$item["id"]}}">{{$item["name"]}}</option>
                                @endforeach
                            </select>
                        </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent">
                    <div class="d-flex justify-content-end">
                        <button class="btn btn-success" >Save</button>
                        &nbsp;&nbsp;
                        <a href="{{url('/Home')}}" class="btn btn-danger">Cancel</a>
                    </div>
                    
                </div>
                <input type="hidden" value="{{$ticket_data[0]["assign_name"]}}" id="assign_to">
                <input type="hidden" name="ticket_id" value="{{$ticket_id}}" id="">
            </form>
            </div>
        </div>
    </div>

@endsection
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>   
<script>
    $(function(){
        var assign = $("#assign_to").val();
        if(assign == ""){
            assign = "--SELECT ASSIGN--";
        }
        $("#select_assign_to option:contains('"+assign+"')").prop("selected",true);
    })
</script>
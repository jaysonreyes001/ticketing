@extends('contents/template2')
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">
                <!-- End of Topbar -->
                    
                <!-- Begin Page Content asd -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Ticket</h1>
                        <a href="{{url("/Dashboard/TicketManage")}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-plus fa-sm text-white-50"></i> Add Ticket</a>
                    </div>
                    
                    <div class="table-reponsive bg-white shadow p-4">
                     
                            <table class="table table-striped table-bordered " id="table_ticketlist">
                                <thead>
                                    <th>Ticket ID</th>
                                    <th>Ticket Title</th>
                                    <th>Status</th>
                                    <th>Priorities</th>
                                    <th>Assigned To</th>
                                    <th>Action</th>
                                </thead>
                                <tbody>
                                    <td>test</td>
                                    <td>test</td>
                                    <td>test</td>
                                    <td>test</td>
                                    <td>test</td>
                                    <td>test</td>
                                </tbody>
                            </table>
                     
                    </div>
                </div>


               
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>    
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>
<script>

   
 var table = "";
    $(document).ready(function () {
    table = $('#table_ticketlist').DataTable({
        "ajax" :{
            "url":"Testing"
        }
    });


   
});






    
</script>
    @endsection


@extends('layouts.admin')

@section('content')
<div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        <div style="overflow-x:auto;">
                        <table id="table_id" class="table table-striped table-bordered ">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">First</th>
                                <th scope="col">Last</th>
                                <th scope="col">Handle</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>Mark</td>
                                <td>Otto</td>
                                <td>@mdo</td>
                            </tr>
                            <tr>
                                <th scope="row">2</th>
                                <td>Jacob</td>
                                <td>Thornton</td>
                                <td>@fat</td>
                            </tr>
                            <tr>
                                <th scope="row">3</th>
                                <td>Larry</td>
                                <td>the Bird</td>
                                <td>@twitter</td>
                            </tr>
                            </tbody>
                            <tfoot>
                            <th scope="col">#</th>
                                <th scope="col">First</th>
                                <th scope="col">Last</th>
                                <th scope="col">Handle</th>
                            </tfoot>
                        </table>
                        </div>
                        </div>
                    </div>
                </div>
</div>
<script>           
    $(document).ready(function(){
        $('#table_id tfoot th').each(function (){
            var title = $(this).text();
            $(this).html('<input type="text" placeholder="'+title+'" />');
        });
        var table =$('#table_id').DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                        {
                            extend: 'excelHtml5',
                            
                            className: 'btn btn-info',
                                    exportOptions: {
                                columns: [ 0, 1, 2,3]
                        }   
                        },
                        {
                            extend: 'csvHtml5',
                            className: 'btn btn-info',
                                    exportOptions: {
                                        columns: [ 0, 1, 2,3]
                        }   
                        },
                        {
                            extend: 'pdfHtml5',
                            messageTop: 'All customer from database.',
                            className: 'btn btn-info',
                                    exportOptions: {
                                        columns: [ 0, 1, 2,3]
                        }   
                        },
                        {
                            extend: 'print',
                            className: 'btn btn-info',
                                    exportOptions: {
                                        columns: [ 0, 1, 2,3]
                        }   
                        }
                    ],
                    "paging":   true,
                    "ordering": true,
                    "info":     true,
                });
            table.columns().every( function () {
            var that = this;
            $('input',this.footer() ).on('keyup change', function () {
                if ( that.search() !== this.value ){
                    that
                        .search(this.value)
                        .draw();
                }
            });
        } );
    });
</script>
@endsection
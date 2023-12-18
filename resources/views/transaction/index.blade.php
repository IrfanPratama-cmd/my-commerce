@extends('data-table.main')

@section('table')

    <div class="row py-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered data-table" id="transactionsTable">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>User Name</th>
                                <th>Transaction ID</th>
                                <th>Transaction Code</th>
                                <th>Status</th>
                                <th>Total Price</th>
                                <th width="100px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

       <!-- Detail Modal -->
    <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailModalLabel">Transaction Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table" id="transactionDetailTable">
                        <thead>
                            <tr>
                                <th>Product Name</th>
                                <th>Qty</th>
                                <th>Price</th>
                                <!-- Add more detailed columns as needed -->
                            </tr>
                        </thead>
                        <tbody id="transactionDetailTableBody">
                            <!-- Transaction details will be populated here -->
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
@endsection

@section('script')
<script type="text/javascript">
    $(function () {

        $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });

      var table = $('.data-table').DataTable({
          processing: true,
          serverSide: true,
          ajax: "/transactions",
          columns: [
              {data: 'transaction_time', name: 'transaction_time'},
              {data: 'user.name', name: 'user.name'},
              {data: 'id', name: 'id'},
              {data: 'transaction_code', name: 'transaction_code'},
              {data: 'transaction_status', name: 'transaction_status'},
              {data: 'formatted_price', name: 'price_after_tax'},
              {data: 'action', name: 'action', orderable: false, searchable: false},
          ]
      });


    //   $('body').on('click', '.detailTransaction', function () {
    //         var id = $(this).data('id');
    //         var table = $('.data-table').DataTable({
    //         processing: true,
    //             serverSide: true,
    //             ajax: `/transactions/${id}`,
    //             columns: [
    //                 {data: 'checkout.product.product_name', name: 'checkout.product.product_name'},
    //                 {data: 'checkout.qty', name: 'checkout.qty'},
    //                 {data: 'checkout.product.price', name: 'checkout.product.price'},
    //             ]
    //         });
    //     });

    });
</script>
@endsection


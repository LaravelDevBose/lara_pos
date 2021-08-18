
    <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel17">View Payments</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="row">
            @if(!empty($data->expense_user))
                <div class="col-sm-12 col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <p class="font-medium-1 mb-0">Expense For:</p>
                            <b>{{ $data->expense_user->name }}</b>
                            <p class="mb-0"><b>Phone:</b> {{ $data->expense_user->phone }}</p>
                            <p class="mb-0"><b>Email:</b> {{ $data->expense_user->email }}</p>
                        </div>
                    </div>
                </div>
            @endif
            @if(!empty($data->location))
                <div class="col-sm-12 col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <p class="font-medium-1 mb-0">Store Location:</p>
                            <b>{{ $data->location->store_name }}</b>
                            <p class="mb-0">{!! $data->location->store_address !!}</p>
                            <p class="mb-0"><b>Phone:</b> {{ $data->location->phone_no }}</p>
                        </div>
                    </div>
                </div>
            @endif
            <div class="col-sm-12 col-md-4">
                <div class="card">
                    <div class="card-body">
                        <p class="font-medium-1 mb-0">Reference No.:</p>
                        <b>#{{ $data->reference_no }}</b>
                        <p class="mb-0"><b>Date:</b> {{ \Carbon\Carbon::parse($data->expense_date)->format('m/d/Y') }}</p>
                        <p class="mb-0"><b>Payment Status:</b> {{ $data->payment_status_label }}</p>
                        @if(!empty($data->head))
                            <p class="mb-0"><b>Expense Head:</b> {{ $data->head->head_title }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-3 offset-sm-9 text-right mb-2">
                <a href="#" class="btn btn-primary btn-sm">
                    <i class="d-inline ft-plus white"></i>
                    <span class="d-md-block d-none">Add Payment</span>
                </a>
            </div>
            <div class="col-12">
                <div class="table-responsive">
                    <table class="table table-striped table-borderless table-middle">
                        <thead>
                        <tr>
                            <th>Date</th>
                            <th class="text-right">Amount</th>
                            <th class="text-center">Payment Method</th>
                            <th>Payment Account</th>
                            <th>Payment Note</th>
                            <th class="text-center">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(!empty($data->transactions) && count($data->transactions) > 0)
                            @foreach($data->transactions as $transaction)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($transaction->transaction_date)->format('m/d/y') }}</td>
                                    <td class="text-right">{{ number_format($transaction->amount, 2) }}</td>
                                    <td class="text-center">{{ $transaction->method_label }}</td>
                                    <td>{{ !empty($transaction->account)? $transaction->account->account_name: '' }}</td>
                                    <td>
                                        @if(!empty($transaction->transaction_note))
                                            <details>
                                                <summary>View Note</summary>
                                                <p>{{ $transaction->transaction_note }}</p>
                                            </details>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a  href="#"  title="View" class="text-info mr-1"><i class="far fa-eye"></i></a>
                                            <a  href="#"  title="Edit" class="text-primary mr-1"><i class="far fa-edit"></i></a>
                                            <a  href="#"  title="Delete" class="text-danger"><i class="far fa-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
{{--    <div class="modal-footer">--}}
{{--        <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Close</button>--}}
{{--        <button type="button" class="btn btn-outline-primary">Save changes</button>--}}
{{--    </div>--}}



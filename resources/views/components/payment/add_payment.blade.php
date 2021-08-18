
<div class="modal-header">
    <h4 class="modal-title" id="myModalLabel17">{{ !empty($transaction)? 'Update Payment': 'Add Payment' }}</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@if(!empty($transaction))
    <form class="form GlobalFormValidation" method="post" action="{{ route('update.transactions', $transaction->transaction_id) }}" >
    @method('PUT')
@else
    <form class="form GlobalFormValidation" method="post" action="{{ route('store.transactions') }}">
@endif
@csrf
    <input type="hidden" name="model_id" value="{{ $id }}">
    <input type="hidden" name="model" value="{{ $model }}">
    <div class="modal-body">
        <div class="row">
            @if(!empty($data->expense_user))
                <div class="col-sm-12 col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <p class="font-medium-1 mb-0">Expense For:</p>
                            <b>{{ $data->expense_user->name }}</b>
                            <p class="mb-0">Phone: {{ $data->expense_user->phone }}</p>
                            <p class="mb-0">Email: {{ $data->expense_user->email }}</p>
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
                            <p class="mb-0">Phone: {{ $data->location->phone_no }}</p>
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
        @include('components.payment.payment_form')
    </div>
    <div class="modal-footer">
        <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success">Add Payment</button>
    </div>
</form>


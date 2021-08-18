<div class="row">
    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <div class="controls">
                <label>Paid amount <b class="font-weight-bold text-warning">*</b></label>
                <input type="number" class="form-control"
                       name="paid_amount"
                       value="{{ !empty($transaction)? $transaction->amount: (!empty($due)? $due: '0.00') }}"
                       placeholder="Paid amount"
                       step="0.01"
                       data-fv-notempty='true'
                       data-fv-blank='true'
                       data-rule-required='true'
                       data-fv-notempty-message='Paid amount Is Required'
                       required
                >
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label>Paid no <b class="font-weight-bold text-warning">*</b></label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <span class="la la-calendar-o"></span>
                    </span>
                </div>
                <input type='text' class="form-control pickadate datepicker" placeholder="select date"
                       name="paid_on"
                       value="{{ !empty($transaction)? $transaction->transaction_date: now()->format('m/d/Y') }}"
                       data-fv-notempty='true'
                       data-fv-blank='true'
                       data-rule-required='true'
                       data-fv-notempty-message='Paid on Is Required'
                       required
                />
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <div class="controls">
                <label>Payment Method <b class="font-weight-bold text-warning">*</b></label>
                <select class="select2 form-control" id="paymentMethodChange" name="payment_method"
                        data-fv-notempty='true'
                        data-fv-blank='true'
                        data-rule-required='true'
                        data-fv-notempty-message='Payment Method Is Required'
                        required
                >
                    @if(!empty($paymentMethods) && count($paymentMethods) > 0)
                        @foreach($paymentMethods as $key => $value)
                            <option value="{{ $key }}" {{ !empty($transaction) && $transaction->method == $key ? 'selected' : '' }}>{{ $value }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <div class="controls">
                <label>Payment Account <b class="font-weight-bold text-warning">*</b></label>
                <select class="select2 form-control" name="account_id"
                        data-fv-notempty='true'
                        data-fv-blank='true'
                        data-rule-required='true'
                        data-fv-notempty-message='Payment Account Is Required'
                        required
                >
                    <option value="0">None</option>
                    @if(!empty($bankAccounts) && count($bankAccounts) > 0)
                        @foreach($bankAccounts as $accountId => $accountInfo)
                            <option value="{{ $accountId }}" {{ !empty($transaction) && $transaction->account_id == $accountId ? 'selected' : '' }} >{{ $accountInfo }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
        </div>
    </div>
</div>
<hr>
<div class="row" id="cardInfo" @if(!empty($transaction) && $transaction->method == \App\Models\Transaction::Methods['Card']) style="display: block" @else style="display: none;" @endif>
    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <div class="controls">
                <label>Card Number</label>
                <input type="hidden" name="payment_details[0][label]" value="Card Number">
                <input type="text" class="form-control"
                       name="payment_details[0][card_number]"
                       placeholder="Card number"
                       value="{{ !empty($transaction)? $transaction->payment_details[0]['card_number']: '' }}"
                >
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <div class="controls">
                <label>Card holder name</label>
                <input type="hidden" name="payment_details[1][label]" value="Card holder name">
                <input type="text" class="form-control"
                       name="payment_details[1][card_holder_name]"
                       placeholder="Card holder name"
                       value="{{ !empty($transaction)?$transaction->payment_details[1]['card_holder_name']: '' }}"
                >
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <div class="controls">
                <label>Card Transaction No.</label>
                <input type="hidden" name="payment_details[2][label]" value="Transaction No.">
                <input type="text" class="form-control"
                       name="payment_details[2][card_transaction_no]"
                       placeholder="Card Transaction no."
                       value="{{ !empty($transaction)?$transaction->payment_details[2]['card_transaction_no']: '' }}"
                >
            </div>
        </div>
    </div>
</div>
<div class="row" id="chequeInfo" @if(!empty($transaction) && $transaction->method == \App\Models\Transaction::Methods['Cheque']) style="display: block" @else style="display: none" @endif>
    <div class="col-sm-12">
        <div class="form-group">
            <div class="controls">
                <label>Cheque No</label>
                <input type="hidden" name="payment_details[3][label]" value="Cheque No">
                <input type="text" class="form-control"
                       name="payment_details[3][cheque_no]"
                       placeholder="Cheque No"
                       value="{{ !empty($transaction)?$transaction->payment_details[3]['cheque_no']: '' }}"
                >
            </div>
        </div>
    </div>
</div>
<div class="row" id="bankInfo" @if(!empty($transaction) && $transaction->method == \App\Models\Transaction::Methods['Bank Transfer']) style="display: block" @else style="display: none" @endif>
    <div class="col-sm-12">
        <div class="form-group">
            <div class="controls">
                <label>Bank Account no</label>
                <input type="hidden" name="payment_details[4][label]" value="Bank Account no">
                <input type="text" class="form-control"
                       name="payment_details[4][bank_account_no]"
                       placeholder="Bank Account no"
                       value="{{ !empty($transaction)?$transaction->payment_details[4]['bank_account_no']: '' }}"
                >
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="form-group">
            <div class="controls">
                <label>Payment Note</label>
                <textarea name="payment_note" rows="2" class="form-control" placeholder="Payment note..">{{ !empty($transaction)? $transaction->transaction_note: '' }}</textarea>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12 col-md-6 offset-md-6">
        @include('layouts.includes.alert_messages')
    </div>
</div>

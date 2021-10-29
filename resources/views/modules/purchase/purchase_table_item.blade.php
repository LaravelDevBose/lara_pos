<tr class="demo">
    <td>
        {{ $product->product_name }} ({{ $product->product_code }})
        <br> <small>Current Stock: {{ $product->current_stock }} {{ $product->unit->sort_form }}(s)</small>
        <input type="hidden" name="purchase[{{$rowCount}}][product_id]" value="{{ $product->product_id }}">
    </td>
    <td>
        <input type="number" name="purchase[{{$rowCount}}][quantity]" value="1.00" step="0.01" class="form-control input-sm purchase_quantity" autocomplete="off">
        <p class="text-left mb-0"><small class="text-muted">{{ $product->unit->sort_form }}(s)</small></p>
    </td>
    <td>
        <input type="number" name="purchase[{{$rowCount}}][unit_pp_without_discount]" value="{{ $product->product_dpp }}" step="0.01" class="form-control input-sm unit_cost_without_discount" autocomplete="off">
    </td>
    <td>
        <input type="number" name="purchase[{{$rowCount}}][discount_percent]" value="0.00" step="0.01" class="form-control input-sm inline_discount" autocomplete="off">
    </td>
    <td>
        <input type="number" name="purchase[{{$rowCount}}][unit_purchase_price]" value="{{ $product->product_dpp }}" step="0.01" class="form-control input-sm unit_purchase_price" autocomplete="off">
    </td>
    <td>
        <span class="row_subtotal_before_tax_text">{{ $product->product_dpp }}</span>
        <input type="hidden" class="row_subtotal_before_tax" value="{{ $product->product_dpp }}">
    </td>
    <td>
        <div class="input-group input-group-sm">
            <select class="form-control purchase_line_tax_id input-sm" name="purchase[{{$rowCount}}][tax_id]" >
                <option value="" data-percent="0"> None</option>
                @if(!empty($taxes) && count($taxes) > 0)
                    @foreach($taxes as $tax)
                        <option value="{{ $tax->tax_id }}" data-percent="{{ $tax->tax_percent }}" {{ !empty($product) && $product->tax_id==$tax->id ? 'selected': '' }}> {{ $tax->tax_info }} </option>
                    @endforeach
                @endif
            </select>
            <input type="hidden" name="purchase[{{$rowCount}}][item_tax]" value="0.00" step="0.01" class="form-control input-sm purchase_unit_tax" autocomplete="off">
            <div class="input-group-append">
                <span class="purchase_product_unit_tax_text input-group-text">0.00</span>
            </div>
        </div>
    </td>
    <td>
        <input type="number" name="purchase[{{$rowCount}}][purchase_price_inc_tax]" value="{{ $product->product_dpp }}" step="0.01" class="form-control input-sm purchase_unit_price_inc_tax" autocomplete="off">
    </td>
    <td>
        <span class="row_subtotal_after_tax_text">{{ $product->product_dpp }}</span>
        <input type="hidden" class="row_subtotal_after_tax" value="{{ $product->product_dpp }}">
    </td>
    <td>
        <input type="number" name="purchase[{{$rowCount}}][profit_percent]" value="0.00" step="0.01" class="form-control input-sm line_profit_percent" autocomplete="off">
    </td>
    <td>
        <input type="number" name="purchase[{{$rowCount}}][default_sell_price]" value="{{ $product->product_dsp }}" step="0.01" class="form-control input-sm default_sell_price" autocomplete="off">
    </td>
    <td>
        <i class="fa fa-times remove_purchase_entry_row text-danger" title="Remove" style="cursor:pointer;"></i>
    </td>
</tr>

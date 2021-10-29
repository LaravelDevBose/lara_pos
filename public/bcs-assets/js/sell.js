$(document).ready(()=>{
    $('.BCS-product-data-ajax').on('select2:select', function (e) {
        let row_count = $('#total_row').val();
        var data ={
            product_id: e.params.data.product_id,
            row_count:row_count,
            location_id: ''
        }
        $.ajax({
            url: $(this).data('sell_entry_url'),
            data:data,
            success: (response) =>{
                if (response.status === 200){
                    $('#BCS_sell_entry_table tbody').append(response.html);
                    __calculate_total();
                }
            }
        })
        $(this).val(null).trigger('change');
    });

    $(document).on('change', '.sell_quantity, .unit_sell_without_discount, .inline_discount, .sell_line_tax_id', function (){
        var row = $(this).closest('tr');
        __calculate_line(row, 1);
    });
    
    $(document).on('change', '.sell_line_tax_id', function (){
        var row = $(this).closest('tr');
        __calculate_tax(row);

    });

    $(document).on('change', '.unit_sell_price', function (){
        var row = $(this).closest('tr');
        __calculate_line(row, 2);
    });

    $(document).on('change', '.sell_unit_price_inc_tax', function (){
        var row = $(this).closest('tr');
        __calculate_line(row, 3);
    });

    $(document).on('change', '.line_profit_percent', function (){
        var row = $(this).closest('tr');
        let percent = parseFloat($(this).val());
        let unit_price_inc_tax = parseFloat(row.find('.sell_unit_price_inc_tax').val());
        let profit = ((percent/100) * unit_price_inc_tax);
        // get Default Sell price
        let dsp = (unit_price_inc_tax + profit);
        row.find('.default_sell_price').val(dsp.toFixed(2));
    });

    $(document).on('change', '.default_sell_price', function (){
        var row = $(this).closest('tr');
        __calculate_profit_percent(row);
    });


    function __calculate_tax(row){
        let tax = parseFloat(row.find('.sell_line_tax_id').find(':selected').data('percent'));
        let unit_sell_price = parseFloat(row.find('.unit_sell_price').val());
        let quantity = parseFloat(row.find('.sell_quantity').val());

        tax = isNaN(tax)? 0: tax;
        let tax_value = unit_sell_price * (tax/100);
        let sell_unit_price_inc_tax = unit_sell_price + tax_value;
        let row_subtotal_after_tax = quantity * sell_unit_price_inc_tax;


        row.find('.sell_unit_tax').val(tax_value.toFixed(2));
        row.find('.sell_product_unit_tax_text').html(tax_value.toFixed(2));
        row.find('.sell_unit_price_inc_tax').val(sell_unit_price_inc_tax.toFixed(2));

        row.find('.row_subtotal_after_tax').val(row_subtotal_after_tax.toFixed(2));
        row.find('.row_subtotal_after_tax_text').html(row_subtotal_after_tax.toFixed(2));

        __calculate_total();
    }
    function __calculate_line(row, flow){
        let subtotal_before_tax = 0;
        let quantity = parseFloat(row.find('.sell_quantity').val());
        let unit_sell_without_discount = parseFloat(row.find('.unit_sell_without_discount').val());
        let inline_discount = parseFloat(row.find('.inline_discount').val());
        let unit_sell_price = parseFloat(row.find('.unit_sell_price').val());
        let unit_price_inc_tax = parseFloat(row.find('.sell_unit_price_inc_tax').val());
        let tax = parseFloat(row.find('.sell_line_tax_id').find(':selected').data('percent'));

        inline_discount = isNaN(inline_discount)? 0: inline_discount;

        if(flow === 3){
            tax = isNaN(tax)? 0: tax;
            tax = ((100 + tax)/100);
            unit_sell_price = unit_price_inc_tax / tax;
            inline_discount = ((100 -inline_discount)/100);
            unit_sell_without_discount = unit_sell_price /inline_discount;
        }else if(flow === 2){
            inline_discount = ((100 -inline_discount)/100);
            unit_sell_without_discount = unit_sell_price /inline_discount;
        }else{
            // calculate Unit Sell Price With Discount
            unit_sell_price = (unit_sell_without_discount - (unit_sell_without_discount * (inline_discount/100)));

        }
        subtotal_before_tax = quantity * unit_sell_price;

        row.find('.unit_sell_without_discount').val(unit_sell_without_discount.toFixed(2));
        row.find('.unit_sell_price').val(unit_sell_price.toFixed(2));
        row.find('.row_subtotal_before_tax_text').html(subtotal_before_tax.toFixed(2));
        row.find('.row_subtotal_before_tax').val(subtotal_before_tax.toFixed(2));

        __calculate_tax(row);
       
    }

    // function __calculate_profit_percent(row) {
    //     let dsp = parseFloat(row.find('.default_sell_price').val());
    //     let unit_price_inc_tax = parseFloat(row.find('.sell_unit_price_inc_tax').val());
    //     let profit = dsp - unit_price_inc_tax;
    //     let profit_percent = ((profit /unit_price_inc_tax) *100);
    //     row.find('.line_profit_percent').val(profit_percent.toFixed(2));
    // }

    function __calculate_total() {
        var rows = $('#BCS_sell_entry_table tbody').find('tr');
        console.log(rows);
        let BCS_total_item = 0;
        let BCS_total_amount = 0;
        let total_row = 0;

        $('#BCS_sell_entry_table tbody tr')
            .each(function (){
            BCS_total_item += parseFloat($(this).find('.sell_quantity').val());
            BCS_total_amount += parseFloat($(this).find('.row_subtotal_after_tax').val());
            total_row++;
        })
        $('#total_row').val(total_row);
        $('#BCS_total_item').html(BCS_total_item.toFixed(2));
        $('#BCS_total_amount').html(BCS_total_amount.toFixed(2));
    }
});
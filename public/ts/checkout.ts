$(document).on('click', '.quantityIncrement', function(e) {
    e.preventDefault();
    calculateAndDisplay('increment', this);
});


$(document).on('click', '.quantityDecrement', function(e) {
    e.preventDefault();
    calculateAndDisplay('decrement', this);
});

$('#taxType').change(function () {
    let taxRate : number = parseInt($(this).find(':selected').data('tax_rate'));
    let totalAmount : number = parseFloat($('#subTotalAmount').text());
    let TaxOnAmount : number = (taxRate / 100 ) * totalAmount;
    let totalAmountIncludingTax : number = totalAmount + TaxOnAmount;
    if (TaxOnAmount > 0) {
        $('#totalAmount').empty().text(totalAmountIncludingTax.toFixed(2)+" (Including Tax)");
    }else{
        $('#totalAmount').empty().text(totalAmountIncludingTax.toFixed(2));
    }
    $('#taxInput').val(TaxOnAmount.toFixed(2));
    $('#totalInput').val(totalAmountIncludingTax.toFixed(2));
});


let calculateAndDisplay = (type:string, clickedElement:object) :void => {
    let rowId:number = $(clickedElement).data('id');
    let quantity:number = parseInt($(clickedElement).siblings('span').text());
    let availableQuantity : any = $(clickedElement).siblings("input[name=stock_quantity]").val();
    let stockQuantity = parseInt(availableQuantity);

    let totalQuantity:number;
    if (type==='increment') {
        totalQuantity = quantity + 1;
    }else {
        totalQuantity = quantity - 1;
        if (totalQuantity < 1) {
            return;
        }
    }

    if (totalQuantity > stockQuantity) {
        displayErrorMessage('Quantity Limit Exceeded');
        return;
    }

    let rateElement:any = $(clickedElement).closest('tr').find('.rate');
    let rateValue : number = parseFloat(rateElement.text());

    let subtotal = totalQuantity * rateValue;
    let prevSubTotalAmount : number = parseFloat($('#subTotalAmount').text());


    let taxAmount : number = 0;
    if ($("select[name='tax_type_id'] option:selected").length > 0) {
        let selectedValue = $("select[name='tax_type_id']").find(':selected').data('tax_rate');

        if (!isNaN(parseInt(selectedValue))) {
            taxAmount = parseInt(selectedValue);
        }
    }


    let newSubTotalAmount:number;
    if (type ==='increment') {
        newSubTotalAmount = prevSubTotalAmount + rateValue;
    } else {
        newSubTotalAmount = prevSubTotalAmount - rateValue;
    }

    let totalAmountWithTax : number = newSubTotalAmount + (newSubTotalAmount * taxAmount) / 100;

    $(clickedElement).siblings('span').text(totalQuantity);
    $(clickedElement).closest('tbody').find('.finalQuantity_'+rowId).val(totalQuantity);

    $(clickedElement).closest('tr').find('.subtotal').text(subtotal.toFixed(2));
    $(clickedElement).closest('tbody').find('.subtotal_'+rowId).val(subtotal.toFixed(2));

    $('#subTotalAmount').text(newSubTotalAmount.toFixed(2));
    $('#totalAmount').text(totalAmountWithTax.toFixed(2));
    $('#totalInput').val(totalAmountWithTax.toFixed(2));
}

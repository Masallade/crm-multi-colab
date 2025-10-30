$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(".razorpay-payment-button").hide();
});

$("#payNowBtn").click(function(){
    $("#payNowBtn").text('Please wait...');
});

$("#payCancelBtn").click(function(){
    if (confirm('Are you sure to cancel ?')) {
        window.history.back();
    }
});

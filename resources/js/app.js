
 $.ajaxSetup({
     headers: {
         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
 });

  request
 function sendOrder(orderId) {
     $.post('/callback', { orderid: orderId }, function(response) {
       // Handle response
        console.log(response);
    }).fail(function(xhr) {
         // Handle error
        console.error(xhr.responseText);
     });
   
 }
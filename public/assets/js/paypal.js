var FUNDING_SOURCES = [
    paypal.FUNDING.PAYPAL
];

function purchaseTicket(showId, amount, showEndTime) {

	$.when(isUserLoggedIn(showId)).then(function(data, textStatus, jqXHR) {
		
		if (textStatus == 'success') {
			if (!data.isUserLoggedIn) {
		
				window.location.href = '/login';
		
			} else {
		
				if (data.currentTimestamp > showEndTime) {
					window.location.reload();
				}

		        $('#purchaseTicket' + showId).addClass('hide');
		        $('#cancelTicket' + showId).removeClass('hide');

		        $('.paypal-button-container').attr('id', '');
		        $('#ordered_' + showId + ' .paypal-button-container').attr('id', 'paypal-button');
		        $('#paypal-button').html('');

				// Loop over each funding source / payment method
				//paypal.getFundingSources().forEach(function(fundingSource) {
				FUNDING_SOURCES.forEach(function(fundingSource) {
				    // Initialize the buttons
				    var button = paypal.Buttons({
				        fundingSource: fundingSource,
				        style: {
							size: 'responsive'
						},
						createOrder: function(data, actions) {
			                // This function sets up the details of the transaction, including the amount and line item details.
			                return actions.order.create({
			                    purchase_units: [{
			                        amount: {
			                            value: amount
			                        }
			                    }]
			                });
			            },

			            onApprove: function(data, actions) {
			                // This function captures the funds from the transaction.
			                return actions.order.capture().then(function(details) {
			                	/*
			                	var purchaseUnits = details.payer.purchase_units;
			                	var payments = purchaseUnits[0].payments;
			                	var captures = payments.captures;

			                	var orderDetails = {
			                		'id': details.id,
			                		'orderId': data.orderID,
			                		'facilitatorAccessToken': data.facilitatorAccessToken,
			                		'create_time': details.create_time,
			                		'update_time': details.update_time,
			                		'status': details.status,
			                		'amount': amount,
			                		'intent': details.intent
		                			'payer_name': details.payer.name.given_name, 
		                			'payer_surname': details.payer.name.surname,
		                			'payer_email': details.payer.email_address, 
		                			'payer_payer_id': details.payer.payer_id,
		                			'payee_email': details.payee.email_address,
		                			'payee_merchant_id': details.payee.merchant_id,
									'payment_id': captures[0].id
			                	};
			                	*/

			                	var orderDetails = {
			                		'id': details.id,
			                		'orderId': data.orderID,
			                		'facilitatorAccessToken': data.facilitatorAccessToken,
			                		'create_time': details.create_time,
			                		'update_time': details.update_time,
			                		'status': details.status,
			                		'amount': amount,
			                		'intent': details.intent
			                	};

			                	createNewOrder(showId, orderDetails);

			                    // This function shows a transaction success message to your buyer.
			                    alert('Transaction completed by ' + details.payer.name.given_name);
			                    window.location.reload();
			                });
			            },

			            onCancel: function (data) {
							alert('Payment Cancel');
							window.location.reload();
						},

						onError: function (err) {
							alert('Something going wrong, please try again');
							window.location.reload();
							// For example, redirect to a specific error page
							//window.location.href = "/your-error-page-here";
						}
				    });

				    // Check if the button is eligible
				    if (button.isEligible()) {
				        // Render the standalone button for that funding source
				        button.render('#paypal-button');
				    }
				});
			}
		}
	
	});
}

function cancelTicket(showId) {
    $('#cancelTicket' + showId).addClass('hide');
    $('#purchaseTicket' + showId).removeClass('hide');

    $('#paypal-button').html('');
    $('.paypal-button-container').attr('id', '');
}

function isUserLoggedIn() {
	return $.ajax({
		url: '/api/user/isUserLoggedIn',
        type: 'GET'
    });
}

function createNewOrder(showId, data) {
	return $.ajax({
		url: '/api/order/post/' + showId,
        type: 'POST',
        data: data
    });
}

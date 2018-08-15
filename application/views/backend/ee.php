$.ajax({
            url: "<?php echo base_url();?>dashboard/addCurrencyData",
            type: "POST",
            dataType: 'json',
            data: {
                'currency_id': $('#catid').val(),
                //'pair': $('#pair').val(),
                'brate': $('#brate').val(),
                'srate': $('#srate').val(),
                //'date': $('#date').val(),
                //'cby': $('#cby').val(),
            },
            beforeSend: function() {
                $('#addcategory').html('Saving...');
            },
            success: function(response) {
                if (response.status == 'error') {
                    $(".flashmessage").fadeIn('fast').delay(3000).fadeOut('fast').html(response.message);
                } else if (response.status == 'success') {
                    $('#addcategory').html('Saved');
                    $(".flashmessage").fadeIn('fast').delay(3000).fadeOut('fast').html(response.message);
                    window.setTimeout(function() {
                        location.reload();
                    }, 3000);
                }
            },
            error: function(response) {
                console.error();
            }
        });
    });
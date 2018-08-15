<?php $this->load->view('backend/header'); ?>
<!--Include header section-->
<div class="wrapper-page">

    <div class="page-title" style="background-color: lightgray;">
        <h1 style="color: blue"><i class="icon-list"></i><b> View Currency Rate</b></h1>
    </div>
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="content_wrapper">
                        <div class="table_banner clearfix">
                            <h3 class="table_banner_title" style="color: blue">
                            <b>Currency Rate List</b></h3>
                            <div class="buy_button">
                                <button type="button" id="category" class="btn btn-custom pull-right">
                                <b>Add Currency</b>
                            </button>
                            </div>
                        </div>
                        <div class="table_banner clearfix">
                            <div class="buy_button">
                            <a class="" href="<?php echo base_url(); ?>crud/view_dashboard
                                " aria-expanded="false">
                                <button type="button" id="back" class="btn btn-custom pull-right">
                                <b>Back to Home</b>
                                </button>
                            </a>
                            </div>
                        </div>
                        <div class="table_body text-left" style="background-color: powderblue;">
                            <table id="example" class="table table-condensed responsive table_custom" cellspacing="0" width="100%">
                                <thead>
                                    <tr style="background-color: lightgreen">
                                        <th><h4><b>ID</b></h4></th>
                                        <th><h4><b>Currency Name</b></h4></th>
                                        <th><h4><b>Buy Rate</b></h4></th>
                                        <th><h4><b>Sell Rate</b></h4></th>
                                        <th><h4><b>Date</b></h4></th>
                                        <th><h4><b>Created By</b></h4></th>
                                        <th><h4><b>Action</b></h4></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($category as $value): ?>
                                    <tr>
                                        <td>
                                            <?php echo $value->rate_id ?>
                                        </td>
                                        
                                        <td>
                                            <?php echo $value->codes ?>
                                        </td>
                                        <td>
                                            <?php echo $value->buy_rate ?>
                                        </td>
                                         <td>
                                            <?php echo $value->sell_rate ?>
                                        </td>
                                         <td>
                                            <?php echo $value->date ?>
                                        </td>
                                         <td>
                                            <?php echo $value->created_by ?>
                                        </td>
                                        
                                        
                                        <td class="action-buttons">
                                            <button type="button" id="category" data-id="<?php echo $value->rate_id; ?>" name="submit" class="catbutton">
                                                    <i class="icon-pencil"></i>
                                            </button>
                                          <a onclick="confirm('Are you sure want to delet this currency?')" href="<?php echo base_url();?>crud/Delet_CurrencyRateInfo?D=<?php echo base64_encode($value->rate_id) ?>">
                                                        <i class="icon-close"></i>
                                                    </a> 
                                        </td>
                                    </tr>
                                    <?PHP endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<span class="flashmessage"></span>
<!--Category validation modal-->
<div aria-hidden="true" aria-labelledby="myModalLabel" class="modal fade" id="categoryform" role="dialog" style="display: none;" tabindex="-1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header modal-primary">
                <button aria-label="Close" class="close" data-dismiss="modal" onclick="location.reload()" type="button"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modal-label">Currency</h4>
            </div>
            <div class="successUpdate" style="color:green;padding:10px;font-size:20px"></div>
            <form enctype="multipart/form-data" id="catmodal" method="post" name="catmodal" role="form" accept-charset="utf-8">
                <div class="modal-body">
                     <div class="content_wrapper">           
                                <div class="table_body p2415">
                                
                                    <form role="form" action="addProductData" id="fileUploadForm" method="post" enctype="multipart/form-data" accept-charset="utf-8">


                                        <div class="form-group clearfix">
                                            <label for="category" class="col-md-3">Currency Name</label>
                                            <div class="col-md-9">
                                                <select class="form-control" id="pair"  name="pair" required>
                                                <option>Select Here..</option>
                                                <?php foreach($currency as $value): ?>
                                                <option value="<?php echo $value->currency_id; ?>"><?php echo $value->codes;?></option>
                                                <?php endforeach; ?>
                                                </select>
                                         </div>
                                     </div>
                                        <div class="form-group clearfix">
                                            <label for="brate" class="col-md-3">Buy Rate</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" name="brate" id="brate" placeholder="Buy Rate" required>
                                            </div>
                                        </div>
                                        <div class="form-group clearfix">
                                            <label for="srate" class="col-md-3">Sell Rate</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" name="srate" id="srate" placeholder="Sell Rate">
                                            </div>
                                        </div>
                                        
                                        <div class="form-group clearfix">
                                            <label for="date" class="col-md-3">Created By</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" name="cby" id="cby" placeholder="created name">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                           <input id="catid" name="catid" type="hidden" value="">
                                           <button class="btn btn-custom" id="addcategory" name="submit" type="submit">Save</button>
                                        </div>
                              
                                    </form>
                                </div>
                            </div>
                        </div>
               
            </form>
        </div>
    </div>
</div>
<!--Category modal show-->
<script type="text/javascript">
    $(document).ready(function() {
        $("#category").click(function(e) {
            e.preventDefault(e);
            $('#categoryform').modal('show');
        });
    });
</script>
<!--Category update and insert script-->
<script>
    $("#addcategory").on("click", function(event) {
        event.preventDefault();
        $.ajax({
            url: "<?php echo base_url();?>crud/addCurrencyRateData",
            type: "POST",
            dataType: 'json',
            data: {
                'rate_id': $('#catid').val(),
                'pair': $('#pair').val(),
                'brate': $('#brate').val(),
                'srate': $('#srate').val(),
                //'date': $('#date').val(),
                'cby': $('#cby').val(),
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
</script>
<!--category form data show in field-->
<script type="text/javascript">
    $(document).ready(function() {
        $(".catbutton").click(function(e) {
            e.preventDefault(e);
            // Get the record's ID via attribute  
            var iid = $(this).attr('data-id');
            $('#catmodal').trigger("reset");
            $('#categoryform').modal('show');
            $.ajax({
                url: '<?php echo base_url();?>crud/currencyRateById?id=' + iid,
                method: 'GET',
                data: '',
                dataType: 'json',
            }).done(function(response) {
                /*console.log(response);*/
                // Populate the form fields with the data returned from server
                $('#catmodal').find('[name="catid"]').val(response.catvalue.rate_id).end();
                $('#catmodal').find('[name="pair"]').val(response.catvalue.currency_id).end();
                $('#catmodal').find('[name="brate"]').val(response.catvalue.buy_rate).end();
                $('#catmodal').find('[name="srate"]').val(response.catvalue.sell_rate).end();
                //$('#catmodal').find('[name="date"]').val(response.catvalue.date).end();
                $('#catmodal').find('[name="cby"]').val(response.catvalue.created_by).end();
            });
        });
    });
</script>

<script type="text/javascript">
    function OnCountry(){
        var x = document.getElementById("pair").value;
        //console.log(x);
    $.ajax({
      type: "GET",
      url: 'getCurrencyRateByID?c=' + x,
      success: function(response) {
        $("#subcatlist").html(response);
        //console.log(response);
      }

    });                     
    }
    </script> 
<!--Include footer section-->
<?php $this->load->view('backend/footer'); ?>







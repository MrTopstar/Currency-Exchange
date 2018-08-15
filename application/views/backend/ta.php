<?php $this->load->view('backend/header'); ?>
<!--Include header section-->

                        
        <div aria-hidden="true" aria-labelledby="myModalLabel" class="modal fade" id="categoryform" role="dialog" style="display: none;" tabindex="-1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header modal-primary">
                <button aria-label="Close" class="close" data-dismiss="modal" onclick="location.reload()" type="button"><span aria-hidden="true">&times;</span></button>
                 <h1 style="color:green">
                    <p style="text-align: left;">
                       <b><i> Currency Exchange Form</i> </b>
                    </p>
                 </h1>
            </div>
            <div class="successUpdate" style="color:green;padding:10px;font-size:20px"></div>
            <form enctype="multipart/form-data" id="catmodal" method="post" name="catmodal" role="form" accept-charset="utf-8">
                <div class="modal-body">
                   <table>
                        <h3>
                         <label class="control-label col-sm-2" for="amount" style="color: blue">Original Amount:</label> 
                        </h3>
         
                      <div class="col-sm-2">
                        <input type="number" class="form-control" id="amount" placeholder="Enter Amount" name="amount" autofocus>
                      </div>
         
            <br><br>

                    <h3>
                      <label class="control-label col-sm-2" for="fromcur" style="color: blue">From Currency:</label>
                    </h3>
                        <div class="col-sm-2">          
                            <select class="form-control" id="fromcur"  name="fromcur" required>
                               <option>USD</option>
                               <option>MMK</option>
                               <option>SGD</option>
                               <option>EUR</option>
                             </select>

                      </div>
       
      <br><br>
   
       <h3>
         <label class="control-label col-sm-2" for="tocur" style="color: blue">To Currency:</label>
       </h3>

      <div class="col-sm-2">          
        <select class="form-control" id="tocur"  name="tocur" required>
           <option>USD</option>
           <option>MMK</option>
           <option>SGD</option>
           <option>EUR</option>
        </select>

      </div>
    
  <br><br>

    <tr>
        <div class="container-fluid">
            <div class="col-sm-4 text-center"><br><br>
       <button class="btn btn-primary btn-lg" title="Buy" id="btnbuy">Buy</button>
       <button class="btn btn-primary btn-lg" title="Sell" id="btnsell">Sell</button>
       <button class="btn btn-warning btn-lg" title="Exit" id="btnexit">Exit</button>
      </div>
    </div>
    </tr>
       <div class="modal-footer">
                    <input id="catid" name="catid" type="hidden" value="">
                    <button class="btn btn-custom" id="addcategory" name="submit" type="submit">Save</button>
                </div>

  </table>
</div>
 </form>
</div>
            
        </div>
    </div>
                    
                
            
        
    

<span class="flashmessage"></span>
<!--Category validation modal-->


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
            url: "<?php echo base_url();?>ta/addCategoryData",
            type: "POST",
            dataType: 'json',
            data: {
                'transaction_id': $('#catid').val(),
                'amount': $('#amount').val(),
                
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
                url: '<?php echo base_url();?>category/categoryById?id=' + iid,
                method: 'GET',
                data: '',
                dataType: 'json',
            }).done(function(response) {
                /*console.log(response);*/
                // Populate the form fields with the data returned from server
                $('#catmodal').find('[name="catid"]').val(response.catvalue.cat_id).end();
                $('#catmodal').find('[name="name"]').val(response.catvalue.cat_name).end();
                $('#catmodal').find('[name="status"]').val(response.catvalue.cat_status).end();
            });
        });
    });
</script>
<!--Include footer section-->
<?php $this->load->view('backend/footer'); ?>
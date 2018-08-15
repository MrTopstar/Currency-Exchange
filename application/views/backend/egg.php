 

 <section>

          <h2> 
             <input type="radio" name="buy" value="buy" style="color: blue" checked>Buy
          </h2>
<form class="form-group" action="/action_page.php" style="height: 400px; width: 50%;background-color: powderblue;" >
 
             
        
           

    
             <label class="control-label col-sm-2" for="amount" style="color: blue">Original Amount:</label>
     
          
          
              <input type="number" class="form-control" id="amount" placeholder="Enter Amount" name="amount" autofocus>
       
     
   
         <br><br>

     
        <h3>
           <label class="control-label col-sm-2" for="fromcur" style="color: blue">From Currency:</label>
        </h3>
  
           <div class="col-sm-2">          
              <select class="form-control" id="fcur"  name="fcur" required>
                 <option>Select Here..</option>
                    <?php foreach($category as $value): ?>
                    <option value="<?php echo $value->currency_id; ?>"><?php echo $value->codes;?>
                    </option>
                    <?php endforeach; ?>
              </select>

          </div>
                                       
    <br><br>
   
     
       <h3>
         <label class="control-label col-sm-2" for="tocur" style="color: blue">To Currency:</label>
       </h3>
  

           <div class="col-sm-2">       
              <select class="form-control" id="tcur"  name="tcur" required>
                   <option selected="">Select Here..</option>
                      <?php foreach($currency as $value): ?>
                    
                    <option value="<?php echo $value->buy_rate; ?>"><?php echo $value->codes;?>

                    </option>
                    <?php endforeach; ?>
                    
            </select>

          </div>
    
<br><br>

        <h3>
           <label class="control-label col-sm-2" for="amount" style="color: blue">
           Buy Rate:</label> 
        </h3>
      
         
           <div class="form-group clearfix">
               <div class="col-md-2">                           
                  <select class="form-control" id="brate"  name="brate" required>
                     <option selected="">Select Here..</option>
                      <?php foreach($dashboard as $value): ?>
                     <option value="<?php echo $value->rate_id; ?>"><?php echo $value->buy_rate;?>
                     </option>
                    <?php endforeach; ?>
                 </select>
              </div>
         </div>
     <br><br>

        <h3>
           <label class="control-label col-sm-2" for="amount" style="color: blue">
           Sell Rate:</label>
       </h3>
      
         <div class="form-group clearfix">
             <div class="col-md-2">                           
                 <select class="form-control" id="srate"  name="srate" required>
                   <option>Select Here..</option>
                    <?php foreach($dashboard as $value): ?>
                    <option value="<?php echo $value->rate_id; ?>"><?php echo $value->sell_rate;?>
                  </option>
                    <?php endforeach; ?>
                 </select>
            </div>
         </div>
 </form>
</style>
 </section>


 <section>
    <form class="form-group" action="/action_page.php" >
          <h3> 
             <input type="radio" name="buy" value="buy" style="color: blue" checked>Buy
          </h3>
          <br>

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
              <select class="form-control" id="fcur"  name="fcur" required>
                 <option>Select Here..</option>
                    <?php foreach($category as $value): ?>
                    <option value="<?php echo $value->currency_id; ?>"><?php echo $value->codes;?>
                    </option>
                    <?php endforeach; ?>
              </select>

          </div>
                                       
    <br><br>
   
     
       <h3>
         <label class="control-label col-sm-2" for="tocur" style="color: blue">To Currency:</label>
       </h3>
  

           <div class="col-sm-2">       
              <select class="form-control" id="tcur"  name="tcur" required>
                   <option selected="">Select Here..</option>
                      <?php foreach($currency as $value): ?>
                    
                    <option value="<?php echo $value->buy_rate; ?>"><?php echo $value->codes;?>

                    </option>
                    <?php endforeach; ?>
                    
            </select>

          </div>
    
<br><br>

        <h3>
           <label class="control-label col-sm-2" for="amount" style="color: blue">
           Buy Rate:</label> 
        </h3>
      
         
           <div class="form-group clearfix">
               <div class="col-md-2">                           
                  <select class="form-control" id="brate"  name="brate" required>
                     <option selected="">Select Here..</option>
                      <?php foreach($dashboard as $value): ?>
                     <option value="<?php echo $value->rate_id; ?>"><?php echo $value->buy_rate;?>
                     </option>
                    <?php endforeach; ?>
                 </select>
              </div>
         </div>
     <br><br>

        <h3>
           <label class="control-label col-sm-2" for="amount" style="color: blue">
           Sell Rate:</label>
       </h3>
      
         <div class="form-group clearfix">
             <div class="col-md-2">                           
                 <select class="form-control" id="srate"  name="srate" required>
                   <option>Select Here..</option>
                    <?php foreach($dashboard as $value): ?>
                    <option value="<?php echo $value->rate_id; ?>"><?php echo $value->sell_rate;?>
                  </option>
                    <?php endforeach; ?>
                 </select>
            </div>
         </div>
 </form>
 </section>






 <?php $this->load->view('backend/header'); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.min.js" integrity="sha256-UGwvyUFH6Qqn0PSyQVw4q3vIX0wV1miKTracNJzAWPc=" crossorigin="anonymous"></script>
<script>
    $(function() {
        localStorage.setItem('thisLink', 'dashboard');
        thisLink = localStorage.getItem('thisLink');
        if (thisLink) {
            $('#' + thisLink).addClass('active');
        }
    });
</script>
        <div class="wrapper-page">

            <div class="page-title">
                <h1><i class="icon-grid"></i> Dashboard</h1>
            </div>
            <div class="flashmessage">Faka?</div>
            <div class="page-content">
                <div class="container-fluid">                   
                    <div class="row">


                    <div>
                         <form class="form-group" action="/action_page.php">
  
        
      <h3>
           <label class="control-label col-sm-2" for="amount" style="color: blue">Original Amount:</label> </h3>
          
           <div class="col-sm-2">
              <input type="number" class="form-control" id="amount" placeholder="Enter Amount" name="amount" autofocus>

           </div>
      
   
         
      <br><br>

     
        <h3>
           <label class="control-label col-sm-2" for="fromcur" style="color: blue">From Currency:</label>

        </h3>
  
             <div class="col-sm-2">          
        <select class="form-control" id="fcur"  name="fcur" required>
                <option>Select Here..</option>
                    <?php foreach($category as $value): ?>
                    <option value="<?php echo $value->currency_id; ?>"><?php echo $value->codes;?>
                    </option>
                    <?php endforeach; ?>
        </select>

      </div>
                                       
    <br><br>
   
     
       <h3>
         <label class="control-label col-sm-2" for="tocur" style="color: blue">To Currency:</label>
       </h3>
  

           <div class="col-sm-2">       
        <select class="form-control" id="tcur"  name="tcur" required>
                <option selected="">Select Here..</option>
                    <?php foreach($currency as $value): ?>
                    
                    <option value="<?php echo $value->buy_rate; ?>"><?php echo $value->codes;?>

                    </option>
                    <?php endforeach; ?>
                    
        </select>

      </div>
    
  
<br>
<br>

   <h3>
           <label class="control-label col-sm-2" for="amount" style="color: blue">
           Buy Rate:</label> </h3>
      
         
    <div class="form-group clearfix">
                   <div class="col-md-2">                           
           <select class="form-control" id="brate"  name="brate" required>
                <option selected="">Select Here..</option>
                    <?php foreach($dashboard as $value): ?>
                    <option value="<?php echo $value->rate_id; ?>"><?php echo $value->buy_rate;?>
                    </option>
                    <?php endforeach; ?>
        </select>
    </div>
         
     <br><br>

     <h3>
           <label class="control-label col-sm-2" for="amount" style="color: blue">
           Sell Rate:</label> </h3>
      
         <div class="form-group clearfix">
                   <div class="col-md-2">                           
                <select class="form-control" id="srate"  name="srate" required>
                <option>Select Here..</option>
                    <?php foreach($dashboard as $value): ?>
                    <option value="<?php echo $value->rate_id; ?>"><?php echo $value->sell_rate;?>
                    </option>
                    <?php endforeach; ?>
        </select>
            </div>
    </div>
    <h3>
           <label class="control-label col-sm-2" for="note" style="color: blue">Note:</label> </h3>
      
         
           <div class="col-sm-2"> 
      <textarea name="note" rows="5" cols="40"></textarea>
       </div>
       <br>
       <br>
       <br>
       <br>
    <br><br><br>
  
  
        <div class="container-fluid">
           

       <input id="catid" name="catid" type="hidden" value="">
       <button class="btn btn-primary btn-lg" title="Buy" id="btnbuy">Buy</button>
       <button class="btn btn-primary btn-lg" title="Sell" id="btnsell">Sell</button>
       <button class="btn btn-warning btn-lg" title="Exit" id="btnexit">Exit</button>
      </div>
    </div>

 

                    </div>



                </div>
            </div><!-- /.page-content  -->
        </div>

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
    $("#btnbuy").on("click", function(event) {
        event.preventDefault();
        $.ajax({
            url: "<?php echo base_url();?>dashboard/addCurrencyData",
            type: "POST",
            dataType: 'json',
            data: {
                'transaction_id': $('#catid').val(),
                //'pair': $('#pair').val(),
                'amount': $('#amount').val(),
                //'srate': $('#srate').val(),
                //'date': $('#date').val(),
                //'cby': $('#cby').val(),
            },
            beforeSend: function() {
                $('#btnbuy').html('Saving...');
            },
            success: function(response) {
                if (response.status == 'error') {
                    $(".flashmessage").fadeIn('fast').delay(3000).fadeOut('fast').html(response.message);
                } else if (response.status == 'success') {
                    $('#btnbuy').html('Saved');
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
                url: '<?php echo base_url();?>currencyCode/currencyById?id=' + iid,
                method: 'GET',
                data: '',
                dataType: 'json',
            }).done(function(response) {
                /*console.log(response);*/
                // Populate the form fields with the data returned from server
                $('#catmodal').find('[name="catid"]').val(response.catvalue.currency_id).end();
                //$('#catmodal').find('[name="pair"]').val(response.catvalue.currency_id).end();
                $('#catmodal').find('[name="brate"]').val(response.catvalue.codes).end();
                $('#catmodal').find('[name="srate"]').val(response.catvalue.code_name).end();
                //$('#catmodal').find('[name="date"]').val(response.catvalue.date).end();
                //$('#catmodal').find('[name="cby"]').val(response.catvalue.created_by).end();
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
      url: 'getCurrencyByID?c=' + x,
      success: function(response) {
        $("#subcatlist").html(response);
        //console.log(response);
      }

    });                     
    }
    </script> 
<!--Include footer section-->
<?php $this->load->view('backend/footer'); ?>



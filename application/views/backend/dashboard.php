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
                <h1><i class="icon-grid"></i><b>Currency Exchange</b></h1>
            </div>
            <div class="flashmessage">Faka?</div>
            <div class="page-content">
                <div class="container-fluid">                   
                    <div class="row">

<button class="btn btn-custom" onclick="myFunction()" style=" font-size: 23px;"><b>Refresh</b></button>

<script type="text/javascript">
 function myFunction()
 {
  //if(new Date().getTime() - time >= 60000) 
            // window.location.reload(true);
         //else 
             //setTimeout(refresh, 10000);
  location.reload();
 }
</script>
<br>
<br>

      <div class="table_body text-left" style="background-color: powderblue;">
        <h3 style="color: blue;"><b>Today Currency Rate</b></h3><br>
                            <table id="example" class="table table-condensed responsive table_custom"  cellspacing="1" width="100%">

                                <thead>
                                    <tr style="background-color: lightgreen;">
                                        
                                        <th><h4><b>Code</b></h4></th>
                                        <th><h4><b>Buy Rate</b></h4></th>
                                        <th><h4><b>Sell Rate</b></h4></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($currency as $value): ?>
                                    <tr>
                                        <td>
                                            <?php echo $value->codes ?>
                                        </td>
                                        <td>
                                            <?php echo $value->buy_rate ?>
                                        </td>
                                        <td>
                                            <?php echo $value->sell_rate ?>
                                        </td>

                                    </tr>
                                  <?PHP endforeach; ?>
                                </tbody>
                                   
                            </table>
              </div>
                        <br><br>
     
<p>                          
<form class="form-group" action="/action_page.php" style="height: 300px; width: 50%;background-color: powderblue;" >
                            <div class="form-group">
    <br>
    <br>
                                <h2>
                                <label class="control-label col-sm-6" for="Aamount" style="color: blue"><b>Customer Sell:</b></label>
                                </h2>
          
                                <div class="col-sm-6">
                                   <input type="number" class="form-control" id="Aamount" placeholder="Enter Amount" name="amount" autofocus>

                                </div>
    <br><br>
   
                             <h2>
                                  <label class="control-label col-sm-6" for="Ato" style="color: blue"><b>From Currency:</b></label>

                                  </h2>
  
                                  <div class="col-sm-6">          
                                  <select class="form-control" id="AT"  name="AT" required>
                                    <option><b>Select Here..</b></option>
                                    <?php foreach($currency as $value): ?>
                                    <option value="<?php echo $value->codes; ?> , <?php echo $value->buy_rate; ?>"> <?php echo $value->codes;?> 
                                    </option>
                                    <?php endforeach; ?>
                                  </select>
                                
                             </div>
                             <br><br>
                             <h2>
                                  <label class="control-label col-sm-6" for="Afrom" style="color: blue"><b>To Currency:</b></label>

                                  </h2>
  
                                  <div class="col-sm-6">          
                                  
                                   <input id="AF" name="AF" type="text" value="MMK" class="form-control" disabled>
                             </div>
  
<br>
<br>
                <div class="modal-footer" style=" color: white;">
                     <input id="catid" name="catid" type="hidden" value="">
                     <input type="button" class="btn btn-custom" onclick="OnSelects()" name="buycheck" value="Check" style=" font-size: 20px;">

                     <input type="button" class="btn btn-custom" onclick="OnSelecteds()" name="buy" value="Buy" style=" font-size: 20px;">
                     
                 </div>

                  <link href="dist/x0popup.min.css" rel="stylesheet">
                  <script src="dist/x0popup.min.js"></script>

          
<script>


   
  function OnSelects()
  {

    var t = document.getElementById("AT");
    var selectedText = t.options[t.selectedIndex].text;
    var amu = document.getElementById("Aamount").value;
    var b=t.options[t.selectedIndex].value.split(",")[1];
    //var x = "0";
    if(amu=="")
   {
    alert(" Customer Sell Field is required");
    //x0p('Message', 'Hello world!', 'info');

   }
   else if(selectedText=="Select Here..")
   {
    alert(" From Currency Field is required");
   }
   else
   {
   switch (selectedText) {
    case "USD(100)":{
                      var ans=amu*b ;
                      alert("This rate is                  :    "+b+"   USD\nCustomer buys           :    "+amu+"   USD\nCustomer to be paid  :    "+ans.toFixed(2)+"  MMK"); 
                    }break;
    case "USD(50-5)":{
                      var ans=amu*b ;
                      alert("This rate is                  :    "+b+"   USD\nCustomer buys           :    "+amu+"   USD\nCustomer to be paid  :    "+ans.toFixed(2)+"  MMK"); 
                    }break;
    case "EUR(500-50)":{
                      var ans=amu*b ;
                      alert("This rate is                  :    "+b+"   USD\nCustomer buys           :    "+amu+"   EUR\nCustomer to be paid  :    "+ans.toFixed(2)+"  MMK"); 
                    }break;
    case "EUR(20-5)":{
                      var ans=amu*b ;
                      alert("This rate is                  :    "+b+"   USD\nCustomer buys           :    "+amu+"   EUR\nCustomer to be paid  :    "+ans.toFixed(2)+"  MMK"); 
                    }break;
    case "SGD":{
                      var ans=amu*b ;
                      alert("This rate is                  :    "+b+"   USD\nCustomer buys           :    "+amu+"   SGD\nCustomer to be paid  :    "+ans.toFixed(2)+"  MMK"); 
                    }break;
    case "THB":{
                      var ans=amu*b ;
                      alert("This rate is                  :    "+b+"   USD\nCustomer buys           :    "+amu+"   THB\nCustomer to be paid  :    "+ans.toFixed(2)+"  MMK"); 
                    }break;
    
    default:
        text = "Please enter some amount";
}
}
}


function OnSelecteds()
{

    var am = document.getElementById("Aamount").value;
    var a = document.getElementById("AT");
    var b = a.options[a.selectedIndex].text;


   if(am=="")
   {
    alert(" Customer Sell Field is required");
    //x0p('Message', 'Hello world!', 'info');

   }
   else if(b=="Select Here..")
   {
    alert(" From Currency Field is required");
   }
    else{
            alert("successfully added"); 

            $.ajax({
            url: "<?php echo base_url();?>crud/addCurrencyDashData",
            type: "POST",
            dataType: 'json',
            data: {
                'transaction_id': $('#catid').val(),
                'Aamount': $('#Aamount').val(),
                'AT': $('#AT').val(),
                'AF': $('#AF').val(),
                //'pair': $('#pair').val(),
                //'selectedText': $('#AT').val(),
                //'cby': $('#cby').val(),
                //'AT'   :$("#AT").val(selectedValue[0]);

            },
            beforeSend: function() {
                $('#buy').html('Saving...');
            },
            success: function(response) {
                if (response.status == 'error') {
                    $(".flashmessage").fadeIn('fast').delay(3000).fadeOut('fast').html(response.message);
                } else if (response.status == 'success') {
                    $('#buy').html('Saved');
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
    
  }
}


      </script>
     <br><br>

   
          </div>
        </div>
      </form>




                        
 <form class="form-group" action="/action_page.php" style="height: 300px; width: 50%;background-color: powderblue;" >
   <div class="form-group">
    <br>
    <br>
               <h2>
                   <label class="control-label col-sm-6" for="amount" style="color: blue"><b>Customer Buy:</b></label>
               </h2>
          
               <div class="col-sm-6">
                  <input type="number" class="form-control" id="Bamount" placeholder="Enter Amount" name="Bamount">

               </div>
      
   
         
      <br><br>

     
                <h2>
                <label class="control-label col-sm-6" for="Bfrom" style="color: blue"><b>From Currency:</b></label>

                </h2>
  
                <div class="col-sm-6">          
               <select class="form-control" id="BT" name="BT" required>
               <option selected=""><b>Select Here..</b></option>
              <?php foreach($currency as $value): ?>
                  <option value="<?php echo $value->codes ?> , <?php echo $value->sell_rate; ?>"><?php echo $value->codes;?>     
                  </option> 
             <?php endforeach; ?>
                    
      </select>

  </div>
                                       
    <br><br>
   
     
       <h2>
         <label class="control-label col-sm-6" for="Bto" style="color: blue"><b>To Currency:</b></label>
       </h2>
       <div class="col-sm-6">
          <input id="BF" name="BF" type="text" value="MMK" class="form-control" disabled>
       </div>

  <br>
<br>
    

<div class="modal-footer" style=" color: white;">
                
      <input type="button" class="btn btn-custom" onclick="OnSelect()" name="sellcheck" value="Check" style=" font-size: 20px;">
          
      <input type="button" class="btn btn-custom" onclick="OnSelected()" name="sell" value="Sell" style=" font-size: 20px;">
   </div>

   <script>

  function OnSelect()
  {
    //var tt=0;
    var tt = document.getElementById("BT");
    var selectedTexts = tt.options[tt.selectedIndex].text;
    var amus = document.getElementById("Bamount").value;
    var b=tt.options[tt.selectedIndex].value.split(",")[1];

    if(amus=="")
   {
    alert(" Customer Sell Field is required");
    //x0p('Message', 'Hello world!', 'info');

   }
   else if(selectedTexts=="Select Here..")
   {
    alert(" From Currency Field is required");
   }
   else
   {

    switch (selectedTexts) {
    case "USD(100)":{
                      var anss=amus*b ;
                      alert("This rate is                  :    "+b+"   USD\nCustomer buys           :    "+amus+"   USD\nCustomer to be paid  :    "+anss.toFixed(2)+"  MMK"); 
                    }break;
    case "USD(50-5)":{
                      var anss=amus*b ;
                      alert("This rate is                  :    "+b+"   USD\nCustomer buys           :    "+amus+"   USD\nCustomer to be paid  :    "+anss.toFixed(2)+"  MMK"); 
                    }break;
    case "EUR(500-50)":{
                      var anss=amus*b ;
                      alert("This rate is                  :    "+b+"   USD\nCustomer buys           :    "+amus+"   EUR\nCustomer to be paid  :    "+anss.toFixed(2)+"  MMK"); 
                    }break;
    case "EUR(20-5)":{
                      var anss=amus*b ;
                      alert("This rate is                  :    "+b+"   USD\nCustomer buys           :    "+amus+"   EUR\nCustomer to be paid  :    "+anss.toFixed(2)+"  MMK"); 
                    }break;
    case "SGD":{
                      var anss=amus*b ;
                      alert("This rate is                  :    "+b+"   USD\nCustomer buys           :    "+amus+"   SGD\nCustomer to be paid  :    "+anss.toFixed(2)+"  MMK"); 
                    }break;
    case "THB":{
                      var anss=amus*b ;
                      alert("This rate is                  :    "+b+"   USD\nCustomer buys           :    "+amus+"   THB\nCustomer to be paid  :    "+anss.toFixed(2)+"  MMK"); 
                    }break;
    
    default:
        text = "Please enter some amount";
}
}
}
function OnSelected(){
  var am = document.getElementById("Bamount").value;
    var a = document.getElementById("BT");
    var b = a.options[a.selectedIndex].text;
  if(am=="")
   {
    alert(" Customer Buy Field is required");
    //x0p('Message', 'Hello world!', 'info');

   }
   else if(b=="Select Here..")
   {
    alert(" From Currency Field is required");
   }
   else
   {
    alert("successfully added");
    $.ajax({
            url: "<?php echo base_url();?>crud/addCurrencyDashDatas",
            type: "POST",
            dataType: 'json',
            data: {
                'transaction_id': $('#catid').val(),
                'Bamount': $('#Bamount').val(),
                'BT': $('#BT').val(),
                'BF': $('#BF').val(),
                //'pair': $('#pair').val(),
                //'AT': $('#AT').val(),
                //'cby': $('#cby').val(),
            },
            beforeSend: function() {
                $('#sell').html('Saving...');
            },
            success: function(response) {
                if (response.status == 'error') {
                    $(".flashmessage").fadeIn('fast').delay(3000).fadeOut('fast').html(response.message);
                } else if (response.status == 'success') {
                    $('#sell').html('Saved');
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
  }
}
  </script>
</div>
</form>
</p>
</div>
</div>
</div><!-- /.page-content  -->
</div>

<span class="flashmessage"></span>
<div aria-hidden="true" aria-labelledby="myModalLabel" class="modal fade" id="categoryform" role="dialog" style="display: none;" tabindex="-1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header modal-primary">
                <button aria-label="Close" class="close" data-dismiss="modal" onclick="location.reload()" type="button"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title" id="modal-label"><b>Your Amount is</b></h3>
            </div>
            
            <form enctype="multipart/form-data" id="catmodal" method="post" name="catmodal" role="form" accept-charset="utf-8">
                <div class="modal-body">
                     <div class="content_wrapper">           
                                <div class="table_body p2415">
                                
                                    <form role="form" action="addProductData" id="fileUploadForm" method="post" enctype="multipart/form-data" accept-charset="utf-8">


                                        
                                    </form>
                                </div>
                      </div>
                 </div>
               
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $("#bbtn").click(function(e) {
            e.preventDefault(e);
            $('#categoryform').modal('show');
        });
    });
</script>




<!--Category update and insert script-->

<!--category form data show in field-->
<!--<script type="text/javascript">
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
</script>-->



<!--Include footer section-->
<?php $this->load->view('backend/footer'); ?>



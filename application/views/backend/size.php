<?php $this->load->view('backend/header'); ?>
        <div class="wrapper-page">

            <div class="page-title">
                <h1><i class="icon-list"></i> View Size</h1>
            </div>
            <div class="page-content">
                <div class="container-fluid">                   
                <div class="row">
                    <div class="col-md-12">
                        <div class="content_wrapper">
                            <div class="table_banner clearfix">
                                <h5 class="table_banner_title">Size List</h5>
                                
						        <div class="buy_button">
							        <button id="size" class="btn btn-custom pull-right">
                                    Add Size
                                    </button>
                                </div>	                                
                            </div>         
                            <div class="table_body text-left">
                            <table id="example" class="table table-condensed responsive table_custom" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Size Name</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       <?php foreach($size as $value): ?>
                                        <tr>
                                            <td><?php echo $value->size_id ?></td>
                                            <td><?php echo $value->size_name ?></td>
                                            <td><?php echo $value->size_status ?></td>
                                            <td class="action-buttons">
                                                <button type="button" data-id="<?php echo $value->size_id; ?>" name="submit" class="sizebutton">
                                                    <i class="icon-pencil"></i>
                                                </button>                  
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
		<div class="modal fade" id="sizeform" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                            <div class="modal-header modal-primary">
								<button type="button" class="close" data-dismiss="modal" onclick="location.reload()" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								<h4 class="modal-title" id="modal-label">Size</h4>
							</div>	
                          <div style="color:green;padding:10px;font-size:20px" class="successUpdate"> </div>  
			            <form role="form" action="" id="sizemodal" method="" enctype="multipart/form-data">
                            <div class="modal-body">
								<div class="form-group clearfix">
                                <label for="inputMaxLength" class="col-md-3">Size Name</label>
                                <div class="col-md-9">
                                    <input type="text" id="sizename" name="sizename" class="form-control" value='' placeholder="" required >
                                </div>
                                </div>
                                <div class="form-group clearfix">
                                    <label for="textareaMaxLength" class="col-md-3">Size Status</label>
    								<div class="col-md-9">
                                        <select id="status" name="status" class="form-control" style="width: 100%" required>                                    
                                            <option value="">Select Here..</option>
                                            <option value="ACTIVE">ACTIVE</option>
                                            <option value="INACTIVE">INACTIVE</option>  
                                        </select>                        
                                    </div>
                                </div>                                													
                            </div>
                            <div class="setmessage"></div>
                            <div class="modal-footer">
                               <input type="hidden" name="sizeid" id="sizeid" value="">
                                <button id="addSize" type="submit" name="submit" class="btn btn-custom">Save</button>
                            </div>
						</form>
                </div>
            </div>
        </div>
        <script>
        function OnclickReload(){
            location.reload();
        }            
        </script>	
<script type="text/javascript">
        $(document).ready(function () {
            $("#size").click(function (e) {
                e.preventDefault(e);
                $('#sizeform').modal('show');
            });
        });
</script>
<script>
  $("#addSize").on("click", function(event){
      event.preventDefault();
      $.ajax({
          url: "addSizeData",
          type:"POST",
          dataType:'json',
          data:
          {
          'size_id': $('#sizeid').val(),
          'size': $('#sizename').val(),
          'status': $('#status').val(),
          },
          beforeSend:function(){
				$('#addSize').html('Saving...');
			     },           
          success: function(response) {
              if(response.status == 'error') { 
              $(".flashmessage").fadeIn('fast').delay(3000).fadeOut('fast').html(response.message);
              } else if(response.status == 'success'){
                  $(".flashmessage").fadeIn('fast').delay(3000).fadeOut('fast').html(response.message);
                window.setTimeout(function() {location.reload();}, 3000);
              }              
          },
          error: function(response) {
            console.error();
          }
      });
  });			
</script>
<script type="text/javascript">
                                        $(document).ready(function () {
                                            $(".sizebutton").click(function (e) {
                                                e.preventDefault(e);
                                                // Get the record's ID via attribute  
                                                var iid = $(this).attr('data-id');
                                                $('#sizemodal').trigger("reset");
                                                $('#sizeform').modal('show');
                                                $.ajax({
                                                    url: '<?php echo base_url(); ?>crud/getSizeById?id=' + iid,
                                                    method: 'GET',
                                                    data: '',
                                                    dataType: 'json',
                                                }).done(function (response) {
                                                    // Populate the form fields with the data returned from server
													$('#sizemodal').find('[name="sizeid"]').val(response.sizevalue.size_id).end();
                                                    $('#sizemodal').find('[name="sizename"]').val(response.sizevalue.size_name).end();
                                                    $('#sizemodal').find('[name="status"]').val(response.sizevalue.size_status).end();
												});
                                            });
                                        });
</script>                		
<?php $this->load->view('backend/footer'); ?>
 <?php $this->load->view('backend/header'); ?> 
        <div class="wrapper-page">

            <div class="page-title">
                <h1><i class="icon-handbag"></i> Product</h1>
            </div>                                 
                                  <div class="form-group clearfix">
                                            <div class="col-md-9 col-md-offset-3">
                                                <div class="image-preview clearfix"></div>
                                                
                                                <label for="product_image" class="custom-file-upload ajaxified">Upload image</label>
                                                
                                                <input type="file" multiple class="" id="product_image" name="product_image[]" aria-describedby="fileHelp" required>
                                                <input type="file" class="" id="user_image" name="user_image" aria-describedby="fileHelp" accept="image/jpg,image/jpeg,image/png">
                                            </div>                                            
                                        </div>  
                                        </div>

                                        <div class="table_body text-left">
                            <table id="example" class="table table-condensed responsive table_custom" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($image as $value): ?>
                                    <tr>
                                        <td>
                                            <?php echo $value->img_url ?>
                                        </td>
                                      </tr>  
                                        
                                  <?PHP endforeach; ?>     
                                 </tbody>
                             </table>
                         </div>

<?php $this->load->view('backend/footer'); ?>

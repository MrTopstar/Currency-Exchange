<?php $this->load->view('backend/header'); ?>
<!--Include header section-->
<div class="wrapper-page">

    <div class="page-title">
        <h1><i class="icon-list"></i> View Currency</h1>
    </div>
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="content_wrapper">
                        <div class="table_banner clearfix">
                            <h5 class="table_banner_title">Currency List</h5>
                            <div class="buy_button">
                                <button type="button" id="category" class="btn btn-custom pull-right">
                                Add Currency
                            </button>
                            </div>
                        </div>
                        <div class="table_body text-left">
                            <table id="example" class="table table-condensed responsive table_custom" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Currency Code</th>
                                        <th>Currency Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($category as $value): ?>
                                    <tr>
                                        <td>
                                            <?php echo $value->currency_id ?>
                                        </td>
                                        <td>
                                            <?php echo $value->codes ?>
                                        </td>
                                        <td>
                                            <?php echo $value->code_name ?>
                                        </td>
                                      
                                        
                                        
                                        <td class="action-buttons">
                                            <button type="button" id="cat" data-id="<?php echo $value->currency_id; ?>" name="submit" class="catbutton">
                                                    <i class="icon-pencil"></i>
                                            </button>
                                          <a onclick="confirm('Are you sure want to delet this currency?')" href="<?php echo base_url();?>currencyCode/Delet_CurrencyInfo?D=<?php echo base64_encode($value->currency_id) ?>">
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
<?php $this->load->view('backend/footer'); ?>
<?php $this->load->view('backend/header'); ?>
<!--Include header section-->
<div class="wrapper-page">

    <div class="page-title" style="background-color: lightgray;">
        <h1 style="color: blue"><i class="icon-list"></i> <b>View Transaction Details</b></h1>
    </div>
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="content_wrapper">
                        <div class="table_banner clearfix">
                            <h3 class="table_banner_title" style="color: blue"><b>
                            Currency Details </b></h3>
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
                                        <th><h4><b>Amount</b></h4></th>
                                         <th><h4><b>Rate</b></h4></th>
                                        <th><h4><b>Currency_In </b></h4></th>
                                        <th><h4><b>Currency_Out </b></h4></th>
                                        <th><h4><b>Note </b></h4></th>
                                        <th><h4><b>Date </b></h4></th>
                                        <th><h4><b>Created_By</b></h4> </th>
                                        <th><h4><b>Operation</b></h4></th>
                                        <th><h4><b>Action</b></h4></th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($category as $value): ?>
                                    <tr>
                                        <td>
                                            <?php echo $value->detail_id ?>
                                        </td>
                                        
                                        <td>
                                            <?php echo $value->amount ?>
                                        </td>
                                        <td>
                                            <?php echo $value->rate ?>
                                        </td>
                                        <td>
                                            <?php echo $value->currency_in ?>
                                        </td>
                                        <td>
                                            <?php echo $value->currency_out ?>
                                        </td>
                                        <td>
                                            <?php echo $value->note ?>
                                        </td>
                                        <td>
                                            <?php echo $value->date ?>
                                        </td>
                                        <td>
                                            <?php echo $value->created_by ?>
                                        </td>
                                        <td>
                                            <?php echo $value->action ?>
                                        </td>
                                        <td class="action-buttons">
                                            <!--<button type="button" id="cat" data-id="<?php echo $value->detail_id; ?>" name="submit" class="catbutton">
                                                    <i class="icon-pencil"></i>
                                            </button>-->
                                          <a onclick="confirm('Are you sure want to delet this currency?')" href="<?php echo base_url();?>crud/Delet_CurrencyTranInfo?D=<?php echo base64_encode($value->detail_id) ?>">
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
<script type="text/javascript">
    $(document).ready(function() {
        $(".catbutton").click(function(e) {
            e.preventDefault(e);
            // Get the record's ID via attribute  
            var iid = $(this).attr('data-id');
            $('#catmodal').trigger("reset");
            $('#categoryform').modal('show');
            $.ajax({
                url: '<?php echo base_url();?>crud/currencyTranById?id=' + iid,
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
<?php $this->load->view('backend/footer'); ?>
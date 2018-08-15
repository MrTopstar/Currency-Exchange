<div class="wrapper-page">

    <div class="page-title">
        <h1><i class="icon-list"></i> Currency Exchange</h1>
    </div>
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="content_wrapper">
                        <div class="ter clearfix">
                            <h5 classable_bann="table_banner_title">Category Transaction</h5>
                            <div class="buy_button">
                                <button type="button" id="category" class="btn btn-custom pull-right">
                                Add Category
                            </button>
                            </div>
                        </div>
                        <div class="table_body text-left">
                            <table id="example" class="table table-condensed responsive table_custom" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Amount</th>
                                        <th>rate</th>
                                        <th>Note</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($ta as $value): ?>
                                    <tr>
                                        <td>
                                            <?php echo $value->transaction_id ?>
                                        </td>
                                        <td>
                                            <?php echo $value->amount?>
                                        </td>
                                         <td>
                                            <?php echo $value->rate?>
                                        </td>
                                         <td>
                                            <?php echo $value->note?>
                                        </td>
                                        
                                        <td class="action-buttons">
                                            <button type="button" id="category" data-id="<?php echo $value->transaction_id; ?>" name="submit" class="catbutton">
                                                    <i class="icon-pencil"></i>
                                                </button>
                                                 <a onclick="return confirm('Are you sure to delete this data?')" href="category_delet?id=<?php echo $value->transaction_id; ?>"<?php if($value->transaction_id == $this->session->userdata('user_login_id')){ echo 'hidden'; } ?> >
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
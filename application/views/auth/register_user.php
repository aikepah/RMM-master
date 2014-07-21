<?php $this->load->view('template/header'); ?>

            <div id="logo">
                <img src="<?php echo base_url();?>public/img/logo.png" alt="" />
            </div>
            <div id="loginbox" style='height: 200px;'>            
                <form>
    				<h3>Thank you for Registering</h3>
    				<p>To finish the registration process and activate your account give us a call at <strong>801-225-7907</strong>.  <!--Please have your credit card information ready.--></p>

                    <div class="form-actions clearfix">
                    </div>
                    <div class="footer-login" style>
                        <div><strong>User Id: <?php echo $new_user_id; ?></strong></div>
                    </div>
                </form>
                <div>
                </div>
            </div>

<script>
    $(document).ready(function () {

    }

</script>
<?php $this->load->view('template/footer'); ?>

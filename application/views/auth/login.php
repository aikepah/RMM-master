<?php $this->load->view('template/header'); ?>

            <div id="logo">
                <img src="<?php echo base_url();?>public/img/logo.png" alt="" />
            </div>
            <div id="user">
                <div class="avatar">
                    <div class="inner"></div>
                    <img src="<?php echo base_url();?>public/img/demo/av1_1.jpg" />
                </div>
                <div class="text">
                    <h4>Hello,<span class="user_name"></span></h4>
                </div>
            </div>
            <div id="loginbox">            
                <?php echo form_open("auth/login",array('id' => 'loginform'));?>
    				<p>Enter username and password to continue.</p>
                    <div class="input-group input-sm">
                        <span class="input-group-addon"><i class="icon-user"></i></span><input class="form-control" type="text" id="identity" name="identity" placeholder="Username" />
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="icon-lock"></i></span><input class="form-control" type="password" id="password" name="password" placeholder="Password" />
                    </div>
                    <div class="form-actions clearfix">
                        <div class="pull-left">
                            <a href="#registerform" class="flip-link to-register blue">Create new account</a>
                    </div>
                        <div class="pull-right">
                            <!--<a href="#recoverform" class="flip-link to-recover grey">Lost password?</a>-->
                        </div>
                        <input type="submit" name="submit" class="btn btn-block btn-primary btn-default" value="Login" />
                    </div>
                    <div class="footer-login">
                    </div>

                </form>
                <form id="recoverform" action="<?php echo site_url('auth/forgot_password') ?>" method="post">
    				<p>Enter your e-mail address below and we will send you instructions how to recover a password.</p>
    				<div class="input-group">
                        <span class="input-group-addon"><i class="icon-envelope"></i></span><input class="form-control" name="email" type="text" placeholder="E-mail address" />
                    </div>
                    <div class="form-actions clearfix">
                        <div class="pull-left">
                            <a href="#loginform" class="grey flip-link to-login">Click to login</a>
                        </div>
<!--                        <div class="pull-right">
                            <a href="#registerform" class="blue flip-link to-register">Create new account</a>
                    </div> -->
                        <input id="recoverButton" type="submit" class="btn btn-block btn-inverse" value="Recover" />
                    </div>
                </form>
                <form id="registerform"  action="<?php echo site_url('auth/register_user') ?>" method="post">
                    <p>Enter information required to register:</p>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="icon-user"></i></span><input class="form-control" type="text" name="company" placeholder="Enter Company Name" />
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="icon-user"></i></span><input class="form-control" type="text" name="first_name" placeholder="Enter Your First Name" />
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="icon-user"></i></span><input class="form-control" type="text" name="last_name" placeholder="Enter Your Last Name" />
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="icon-phone"></i></span><input class="form-control" type="text" name="phone" placeholder="Enter Phone Number" />
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="icon-envelope"></i></span><input class="form-control" type="text" name="email" placeholder="Enter E-mail address" />
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="icon-lock"></i></span><input class="form-control" type="password" name="new_password" placeholder="Choose Password" />
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="icon-lock"></i></span><input class="form-control" type="password" name="confirm_password" placeholder="Confirm password" />
                    </div>
                    <div class="form-actions clearfix">
                        <div class="pull-left">
                            <a href="#loginform" class="grey flip-link to-login">Click to login</a>
                        </div>
                        <div class="pull-right">
                            <!--<a href="#recoverform" class="grey flip-link to-recover">Lost password?</a>-->
                        </div>
                        <input type="submit" class="btn btn-block btn-success" value="Register" />
                    </div>
                </form>
            </div>

<script>
    $(document).ready(function () {

    }

</script>
<?php $this->load->view('template/footer'); ?>

<?php $this->view("header", $data); ?>

<section id="form" style="margin-top: 100px; margin-bottom: 100px;">
    <div class="container">
        <div class="row">

            <div class="col-sm-4 col-sm-offset-4">
                <div class="signup-form"><!--sign up form-->
                    <div class="text-danger">
                        <?php check_error(); ?>
                    </div>
                    <h2>New User Signup!</h2>
                    <form method="POST">
                        <input type="text" name="name" placeholder="Name" />
                        <input type="email" name="email" placeholder="Email Address" />
                        <input type="password" name="password" placeholder="Password" />
                        <input type="password" name="password2" placeholder="Confirm Password" />
                        <button type="submit" class="btn btn-default">Signup</button>
                    </form>
                    <br>
                    Already have an account?
                    <a href="<?= ROOT ?>login">
                        Login, please
                    </a>
                </div><!--/sign up form-->
            </div>
        </div>
    </div>
</section>


<?php $this->view("footer", $data);  ?>
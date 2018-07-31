<div class="container">
    <div class="row">
        <div class="col-10 offset-1 col-md-6 offset-md-3" style="background: #fff; border: 1px solid #c2c2c2; padding: 30px 15px; margin-top: 100px;">
            <?php echo form_open("admin/authentication/sign-in"); ?>
				<h2 class="form-signin-heading text-center" style="font-size: 30px; margin: 0 0 30px; text-align: center;">ADMINISZTRÁCIÓ</h2>
                <label for="inputEmail" class="sr-only">E-mail cím</label>
            	<input autofocus type="text" class="form-control" type="email" name="email" placeholder="E-mail cím" aria-describedby="basic-addon1">
            	&nbsp;
                <label for="inputPassword" class="sr-only">Jelszó</label>
                <input name="pwd" type="password" autocomplete="off" id="inputPassword" class="form-control" placeholder="Jelszó" required>
                &nbsp;
                <button class="btn btn-lg btn-primary btn-block" type="submit"><i class="fa fa-sign-in fa-lg fa-fw" aria-hidden="true"></i>&nbsp;Bejelentkezés</button>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
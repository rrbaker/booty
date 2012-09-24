<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title><?php echo Kohana::lang('ui_main.login');?></title>
	<?php
	echo html::stylesheet(url::file_loc('css').'media/css/jquery-ui-themeroller', '', TRUE);
	echo html::stylesheet(url::file_loc('css').'media/css/login', '', TRUE);
	echo html::stylesheet(url::file_loc('css').'media/css/openid', '', TRUE);
	echo html::stylesheet(url::file_loc('css').'media/css/global', '', TRUE);
	echo html::script(url::file_loc('js').'media/js/jquery', TRUE);
	echo html::script(url::file_loc('js').'media/js/openid/openid-jquery', TRUE);
	echo html::script(url::file_loc('js').'media/js/openid/openid-jquery-en', TRUE);
	echo html::script(url::file_loc('js').'media/js/global', TRUE);
	?>
	<link rel="stylesheet" href="/themes/booty/css/bootstrap.min.css">
	<link rel="stylesheet" href="/themes/booty/css/bootstrap-responsive.min.css">
	<link rel="stylesheet" href="/themes/booty/css/login.css">
	<script type="text/javascript">
		<?php echo $js; ?>
	</script>
</head>
<body>

<div id="login_container" class="container">

	<div class="row">
		<div class="span12">
			<div id="site_name" class="well">
				<h1><?php echo $site_name; ?></h1>
				<span><?php echo $site_tagline; ?></span>
			</div>
		</div>
	</div>

	<?php if ($message): ?>
	<div class="<?php echo $message_class; ?> alert">&#8226;&nbsp;<?php echo $message; ?></div>
	<?php endif; ?>

	<?php if ($form_error): ?>
		<div class="login_error ui-corner-all">
		<?php foreach ($errors as $error_item => $error_description): ?>
			<?php echo (!$error_description) ? '' : "&#8226;&nbsp;" . $error_description . "<br />"; ?>
		<?php endforeach; ?>
		</div>
	<?php endif; ?>

	<?php if (isset($_GET["reset"])): ?>
	<div id="password_reset_change_form" class="ui-corner-all">
		<h2><?php echo Kohana::lang('ui_main.create_new_password'); ?></h2>
		<?php echo form::open(NULL, array('id' => "changepass_form")); ?>
			<input type="hidden" name="action" value="changepass">
			<input type="hidden" name="changeid" value="<?php echo $changeid; ?>">

			<table>
				<?php
					$hidden = 'hidden';
					if (empty($token)) { $hidden = ''; }
				?>
				<tr class="<?php echo $hidden; ?>">
					<td><label><?php echo Kohana::lang('ui_main.token');?></label>
					<?php echo form::input('token', $token, 'class=""'); ?></td>
				</tr>
				<tr>
					<td><label><?php echo Kohana::lang('ui_main.password');?></label>
					<?php echo form::password('password', $form['password'], 'class=""'); ?></td>
				</tr>
				<tr>
					<td><label><?php echo Kohana::lang('ui_main.password_again');?></label>
					<?php echo form::password('password_again', $form['password_again'], 'class=""'); ?></td>
				</tr>
				<tr>
					<td><input type="submit" id="submit" name="submit" value="<?php echo Kohana::lang('ui_main.change_password'); ?>" class="btn btn-primary" /></td>
				</tr>
			</table>

		<?php echo form::close(); ?>
	</div>
	<?php endif; ?>

	<div class="row">
		<div class="span6">
			<div id="login" class="well">

			<?php if ($new_confirm_email_form): ?>
				<h1><?php echo Kohana::lang('ui_main.resend_confirm_email'); ?>:</h1>
				<div id="resend_confirm_email" class="signin_select">
					<?php echo form::open(NULL, array('id'=>"resendconfirm_form")); ?>
						<input type="hidden" name="action" value="resend_confirmation">
						<table width="100%" border="0" cellspacing="3" cellpadding="4" background="" id="ushahidi_loginbox">
							<tr>
								<td><strong><?php echo Kohana::lang('ui_main.registered_email');?></strong><br />
								<?php print form::input('confirmation_email', $form['confirmation_email'], ' class="login_text"'); ?></td>
							</tr>
							<tr>
								<td><input type="submit" id="submit" name="submit" value="<?php echo Kohana::lang('ui_main.send_confirmation'); ?>" class="login_btn" /></td>
							</tr>
						</table>
					<?php echo form::close(); ?>
				</div>
			<?php endif; ?>

			<h3><?php echo Kohana::lang('ui_main.login_with'); ?> <?php echo Kohana::lang('ui_main.login_userpass'); ?></h3>
			<div id="signin_userpass" class="">
				<?php echo form::open(NULL, array('id'=>"userpass_form",'class'=>"form-horizontal")); ?>
					<fieldset>
						<input type="hidden" name="action" value="signin">
						<div class="control-group">
							<label for="username"><?php echo Kohana::lang('ui_main.email');?></label>
							<input type="text" name="username" id="username">
						</div>
						<div class="control-group">
							<label><?php echo Kohana::lang('ui_main.password');?></label>
							<input name="password" type="password" class="" id="password" size="20" />
						</div>
						<div class="control-group">
							<label class="checkbox">
								<input type="checkbox" id="remember" name="remember" value="1" checked="checked" /> <?php echo Kohana::lang('ui_main.password_save');?>
							</label>
						</div>
						<div class="control-group">
							<input type="submit" id="submit" name="submit" value="<?php echo Kohana::lang('ui_main.login'); ?>" class="btn btn-primary" />
						</div>

						<?php if (Kohana::config('settings.require_email_confirmation')): ?>
						<a href="javascript:toggle('signin_forgot');"> <?php echo Kohana::lang('ui_main.forgot_password');?></a>
						<?php endif; ?>
					</fieldset>
				<?php echo form::close(); ?>
			</div>
			
			<?php if (Kohana::config('settings.require_email_confirmation')): ?>
			<div id="signin_forgot" class="signin_select ui-corner-all" style="margin-top:10px;">
				<?php echo form::open(NULL, array('id'=>"userforgot_form")); ?>
					<input type="hidden" name="action" value="forgot">
					<<label><?php echo Kohana::lang('ui_main.registered_email');?></label>
							<?php print form::input('resetemail', $form['resetemail'], ' class=""'); ?></td>
					<input type="submit" id="submit" name="submit" value="<?php echo Kohana::lang('ui_main.reset_password'); ?>" class="btn btn-primary" />
				<?php echo form::close() ?>
			</div>
			<?php endif; ?>

			<?php if (kohana::config('config.allow_openid') == TRUE): ?>
			<h2><a href="javascript:toggle('signin_openid');"><?php echo Kohana::lang('ui_main.login_openid'); ?></a></h2>
			<div id="signin_openid" class="">
				<?php echo form::open(NULL, array('id'=>"openid_form")); ?>
					<input type="hidden" name="action" value="openid">
					<div id="openid_choice">
						<p><?php echo Kohana::lang('ui_main.login_select_openid'); ?>:</p>
						<div id="openid_btns"></div>
					</div>

					<div id="openid_input_area">
						<input id="openid_identifier" name="openid_identifier" type="text" value="http://" />
						<input id="openid_submit" type="submit" value="Sign-In"/>
					</div>
					<noscript>
						<p>OpenID is service that allows you to log-on to many different websites using a single indentity.
						Find out <a href="http://openid.net/what/">more about OpenID</a> and <a href="http://openid.net/get/">how to get an OpenID enabled account</a>.</p>
					</noscript>
				<?php echo form::close(); ?>
			</div>
			<?php endif; ?>
			</div> <!-- /login -->
		</div>

		<div class="span6">
			<div id="account" class="well">
				<h3><a href="javascript:toggle('signin_new');"><?php echo Kohana::lang('ui_main.login_signup_click'); ?></a></h3>
				<?php echo Kohana::lang('ui_main.login_signup_text'); ?>
				<div id="signin_new" class="signin_select">
					<?php echo form::open(NULL,  array('id' => "usernew_form",'class'=>"form-horizontal")); ?>
						<input type="hidden" name="action" value="new">
						<div class="control-group">
							<label><?php echo Kohana::lang('ui_main.name'); ?></label>
							<?php print form::input('name', $form['name'], 'class=""'); ?>
							<span class="help-block"><?php echo Kohana::lang('ui_main.identify_you');?></span>
						</div>

						<div class="control-group">
							<label><?php echo Kohana::lang('ui_main.email'); ?></label>
							<?php print form::input('email', $form['email'], 'class=""'); ?>
							<div class="alert alert-info" style="display:none;">
								<span class="riverid_email_already_set_copy"></span>
							</div>
						</div>

						<div class="control-group">
							<label><?php echo Kohana::lang('ui_main.password'); ?></label>
							<?php print form::password('password', $form['password'], 'class=""'); ?>
						</div>

						<div class="control-group">
							<label><?php echo Kohana::lang('ui_main.password_again'); ?></label>
							<?php print form::password('password_again', $form['password_again'], 'class="login_text new_password_again"'); ?>
						</div>

						<div class="control-group">
							<input type="submit" id="submit" name="submit" value="<?php echo Kohana::lang('ui_main.login_signup');?>" class="btn btn-primary">
						</div>
					<?php echo form::close(); ?>
				</div>
			</div> <!-- /account -->
		</div>
	</div>

	<?php if (kohana::config('riverid.enable') == TRUE): ?>
	<div style="text-align:center;margin-top:20px;" id="openid_login" class="ui-corner-all">
		<small><?php echo $riverid_information; ?> 
			<a href="<?php echo $riverid_url; ?>"><?php echo Kohana::lang('ui_main.more_information'); ?></a>
		</small>
	</div>
	<?php endif; ?>

</div>
</body>
</html>
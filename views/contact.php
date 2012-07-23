<div id="content">
	<h2 class="page-title"><?php echo Kohana::lang('ui_main.contact'); ?></h2>
	<div id="contact_us">
		<?php if ($form_error) { ?>
			<div class="alert alert-error">
				<h4 class="alert-heading">Error!</h4>
				<ul>
					<?php
					foreach ($errors as $error_item => $error_description) {
						print (!$error_description) ? '' : "<li>" . $error_description . "</li>";
					}
					?>
				</ul>
			</div>
			<?php
		}

		if ($form_sent)
		{
			?>
			<!-- green-box -->
			<div class="alert alert-success">
				<?php echo Kohana::lang('ui_main.contact_message_has_send'); ?>
			</div>
			<?php
		}								
		?>
		<?php print form::open(NULL, array('id' => 'contactForm', 'name' => 'contactForm')); ?>
		<div class="control-group">
			<label for="contact_name"><?php echo Kohana::lang('ui_main.contact_name'); ?></label>
			<?php print form::input('contact_name', $form['contact_name'], ' class="span6"'); ?>
		</div>
		<div class="control-group">
			<label for="contact_email"><?php echo Kohana::lang('ui_main.contact_email'); ?></label>
			<?php print form::input('contact_email', $form['contact_email'], ' class="span6"'); ?>
		</div>
		<div class="control-group">
			<label for="control_phone"><?php echo Kohana::lang('ui_main.contact_phone'); ?></label>
			<?php print form::input('contact_phone', $form['contact_phone'], ' class="span6"'); ?>
		</div>
		<div class="control-group">
			<label for="contact_subject"><?php echo Kohana::lang('ui_main.contact_subject'); ?></label>
			<?php print form::input('contact_subject', $form['contact_subject'], ' class="span6"'); ?>
		</div>								
		<div class="control-group">
			<label for="contact_message"><?php echo Kohana::lang('ui_main.contact_message'); ?></strong><br />
			<?php print form::textarea('contact_message', $form['contact_message'], ' rows="4" cols="40" class="span6" ') ?>
		</div>		
		<div class="control-group">
			<strong><?php echo Kohana::lang('ui_main.contact_code'); ?></label>
			<?php print $captcha->render(); ?><br />
			<?php print form::input('captcha', $form['captcha'], ' class="span1"'); ?>
		</div>
		<div class="form-actions">
			<input name="submit" type="submit" value="<?php echo Kohana::lang('ui_main.contact_send'); ?>" class="btn btn-primary btn-large" />
		</div>
		<?php print form::close(); ?>
	</div>
</div>
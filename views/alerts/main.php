<div id="content">
	<h1><?php echo Kohana::lang('ui_main.alerts_get'); ?></h1>
	<?php if ($form_error): ?>
	<div class="alert alert-error">
		<h3>Error!</h3>
		<ul>
		<?php
			foreach ($errors as $error_item => $error_description)
			{
				// print "<li>" . $error_description . "</li>";
				print (!$error_description) ? '' : "<li>" . $error_description . "</li>";
			}
		?>
		</ul>
	</div>
	<?php endif; ?>

	<div class="row">
		<?php print form::open() ?>

		<div class="span6">
			<h2><?php echo Kohana::lang('ui_main.alerts_step1_select_city'); ?></h2>
			<?php echo $alert_radius_view; ?>
			<input type="hidden" id="alert_lat" name="alert_lat" value="<?php echo $form['alert_lat']; ?>">
			<input type="hidden" id="alert_lon" name="alert_lon" value="<?php echo $form['alert_lon']; ?>">
			<input type="hidden" id="alert_country" name="alert_country" value="<?php echo $form['alert_country']; ?>" />
			<input type="hidden" id="alert_confirmed" name="alert_confirmed" value="<?php echo $form['alert_confirmed']; ?>">
		</div>

		<div class="span6">
			<h2><?php echo Kohana::lang('ui_main.alerts_step2_send_alerts'); ?></h2>
			<?php if ($show_mobile == TRUE): ?>
			<div class="control-group">
				<?php $checked = ($form['alert_mobile_yes'] == 1); ?>
				<?php print form::checkbox('alert_mobile_yes', '1', $checked); ?>
				<label><?php echo Kohana::lang('ui_main.alerts_mobile_phone'); ?></label>
				<?php echo Kohana::lang('ui_main.alerts_enter_mobile'); ?>
				<?php print form::input('alert_mobile', $form['alert_mobile'], ' class="text long"'); ?>
			</div>
			<?php endif; ?>
			
			<div class="control-group">
				<label>
					<?php $checked = ($form['alert_email_yes'] == 1) ?> 
					<?php print form::checkbox('alert_email_yes', '1', $checked); ?>
					<?php echo Kohana::lang('ui_main.alerts_email'); ?>
					<?php echo Kohana::lang('ui_main.alerts_enter_email'); ?>
				</label>
				<?php print form::input('alert_email', $form['alert_email'], ' class="text long"'); ?></span>
			</div>

			<div class="control-group">
				<h2><?php echo Kohana::lang('ui_main.alerts_step3_select_catgories'); ?></h2>
				<div class="report_category" id="categories">
					<?php 
						$selected_categories = (!empty($form['alert_category']) AND is_array($form['alert_category']))
							? $selected_categories = $form['alert_category']
							: array();
						echo category::form_tree('alert_category', $selected_categories, 2, TRUE, FALSE);
					?>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="span12 form-actions">
			<input id="btn-send-alerts" class="btn btn-primary btn-large" type="submit" value="<?php echo Kohana::lang('ui_main.alerts_btn_send'); ?>" />
			<a class="btn btn-large" href="<?php echo url::site()."alerts/confirm";?>"><?php echo Kohana::lang('ui_main.alert_confirm_previous'); ?></a>
		</div>
	</div>
	<?php print form::close(); ?>
</div>

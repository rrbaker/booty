<div id="content">
	<?php if ($site_submit_report_message != ''): ?>
		<div class="alert alert-success">
			<p><?php echo $site_submit_report_message; ?></p>
		</div>
	<?php endif; ?>

	<!-- start report form block -->
	<?php print form::open(NULL, array('enctype' => 'multipart/form-data', 'id' => 'reportForm', 'name' => 'reportForm', 'class' => 'gen_forms')); ?>
	<fieldset>
	<input type="hidden" name="latitude" id="latitude" value="<?php echo $form['latitude']; ?>">
	<input type="hidden" name="longitude" id="longitude" value="<?php echo $form['longitude']; ?>">
	<input type="hidden" name="country_name" id="country_name" value="<?php echo $form['country_name']; ?>" />
	<input type="hidden" name="incident_zoom" id="incident_zoom" value="<?php echo $form['incident_zoom']; ?>" />
	<div class="row">
		<div id="report-header" class="span12">
			<h2 class="page-title"><?php echo Kohana::lang('ui_main.reports_submit_new'); ?></h2>

			<?php if ($form_error): ?>
			<!-- red-box -->
			<div class="alert alert-error">
				<h4 class="alert-heading">Error!</label>
				<ul>
					<?php
						foreach ($errors as $error_item => $error_description) {
							print (!$error_description) ? '' : "<li>" . $error_description . "</li>";
						}
					?>
				</ul>
			</div>
			<?php endif; ?>

			<input type="hidden" name="form_id" id="form_id" value="<?php echo $id?>">
		</div>

		<div id="report-details" class="span6">
			<div class="report_row">
				<?php if(count($forms) > 1): ?>
					<label><?php echo Kohana::lang('ui_main.select_form_type');?></label>
						<?php print form::dropdown('form_id', $forms, $form['form_id'],
					' onchange="formSwitch(this.options[this.selectedIndex].value, \''.$id.'\')"') ?>
					<div id="form_loader"></div>
					</label>
				<?php endif; ?>
				<label><?php echo Kohana::lang('ui_main.reports_title'); ?> <span class="required">*</span></label>
				<?php print form::input('incident_title', $form['incident_title'], ' class="span6"'); ?>
			</div>
			<div class="report_row">
				<label><?php echo Kohana::lang('ui_main.reports_description'); ?> <span class="required">*</span></label>
				<?php print form::textarea('incident_description', $form['incident_description'], 'rows="13" class="span6" '); ?>
			</div>
			<div class="report_row" id="datetime_default">
				<label for="incident_date_time"><?php echo Kohana::lang('ui_main.date_time'); ?></label>
				<?php print form::input('incident_date_time'); ?>
				<span class="help-inline"><?php echo Kohana::lang('ui_main.today_at')." "."<span id='current_time'>".$form['incident_hour']
					.":".$form['incident_minute']." ".$form['incident_ampm']."</span>"; ?></span>
				<a href="#" id="date_toggle" class="btn btn-info btn-small"><i class="icon-white icon-time"></i><?php echo Kohana::lang('ui_main.modify_date'); ?></a>
				<?php if($site_timezone): ?>
					<small>(<?php echo $site_timezone; ?>)</small>
				<?php endif; ?>
			</div>
			<div class="report_row hide" id="datetime_edit">
				<div class="date-box">
					<label><?php echo Kohana::lang('ui_main.reports_date'); ?></label>
					<?php print form::input('incident_date', $form['incident_date'], ' class="text short"'); ?>
					<script type="text/javascript">
						$().ready(function() {
							$("#incident_date").datepicker({ 
								showOn: "both", 
								buttonImage: "<?php echo url::file_loc('img'); ?>media/img/icon-calendar.gif", 
								buttonImageOnly: true 
							});
						});
					</script>
				</div>
				<div class="time">
					<label><?php echo Kohana::lang('ui_main.reports_time'); ?></label>
					<?php
						for ($i=1; $i <= 12 ; $i++)
						{
							// Add Leading Zero
							$hour_array[sprintf("%02d", $i)] = sprintf("%02d", $i);
						}
						for ($j=0; $j <= 59 ; $j++)
						{
							// Add Leading Zero
							$minute_array[sprintf("%02d", $j)] = sprintf("%02d", $j);
						}
						$ampm_array = array('pm'=>'pm','am'=>'am');
						print form::dropdown('incident_hour',$hour_array,$form['incident_hour'],'class="span1"');
						print '<span class="dots">:</span>';
						print form::dropdown('incident_minute',$minute_array,$form['incident_minute'],'class="span1"');
						print '<span class="dots">:</span>';
						print form::dropdown('incident_ampm',$ampm_array,$form['incident_ampm'],'class="span1"');
					?>
					<?php if ($site_timezone != NULL): ?>
						<small>(<?php echo $site_timezone; ?>)</small>
					<?php endif; ?>
				</div>
				<div style="display:block;" id="incident_date_time"></div>
			</div>

			<div class="report_row">
				<!-- Adding event for endtime plugin to hook into -->
			<?php Event::run('ushahidi_action.report_form_frontend_after_time'); ?>
			</div>

			<div class="report_row">
				<label><?php echo Kohana::lang('ui_main.reports_categories'); ?> <span class="required">*</span></label>
				<div class="report_category" id="categories">
				<?php
					$selected_categories = (!empty($form['incident_category']) AND is_array($form['incident_category']))
						? $selected_categories = $form['incident_category']
						: array();
					echo category::form_tree('incident_category', $selected_categories, 2);
					?>
				</div>
			</div>

			<?php
			// Action::report_form - Runs right after the report categories
			Event::run('ushahidi_action.report_form');
			?>

			<?php echo $custom_forms ?>

			<div id="report_optional" class="well">
				<h3><?php echo Kohana::lang('ui_main.reports_optional'); ?></h3>
				<div class="report_row">
					<label><?php echo Kohana::lang('ui_main.reports_first'); ?></label>
					<?php print form::input('person_first', $form['person_first'], ' class="span5"'); ?>
				</div>
				<div class="report_row">
					<label><?php echo Kohana::lang('ui_main.reports_last'); ?></label>
					<?php print form::input('person_last', $form['person_last'], ' class="span5"'); ?>
				</div>
				<div class="report_row">
					<label><?php echo Kohana::lang('ui_main.reports_email'); ?></label>
					<?php print form::input('person_email', $form['person_email'], ' class="span5"'); ?>
				</div>
				<?php
				// Action::report_form_optional - Runs in the optional information of the report form
				Event::run('ushahidi_action.report_form_optional');
				?>
			</div>
		</div>

		<div id="report-map" class="span6">
			<?php if (count($cities) > 1): ?>
			<div class="report_row">
				<label><?php echo Kohana::lang('ui_main.reports_find_location'); ?></label>
				<?php print form::dropdown('select_city',$cities,'', ' class="select" '); ?>
			</div>
			<?php endif; ?>
			<div class="report_row">
				<div id="divMap" class="report_map">
					<div id="geometryLabelerHolder" class="olControlNoSelect">
						<div id="geometryLabeler">
							<div id="geometryLabelComment">
								<span id="geometryLabel">
									<label><?php echo Kohana::lang('ui_main.geometry_label');?>:</label> 
									<?php print form::input('geometry_label', '', ' class="lbl_text"'); ?>
								</span>
								<span id="geometryComment">
									<label><?php echo Kohana::lang('ui_main.geometry_comments');?>:</label> 
									<?php print form::input('geometry_comment', '', ' class="lbl_text2"'); ?>
								</span>
							</div>
							<div>
								<span id="geometryColor">
									<label><?php echo Kohana::lang('ui_main.geometry_color');?>:</label> 
									<?php print form::input('geometry_color', '', ' class="lbl_text"'); ?>
								</span>
								<span id="geometryStrokewidth">
									<label><?php echo Kohana::lang('ui_main.geometry_strokewidth');?>:</label> 
									<?php print form::dropdown('geometry_strokewidth', $stroke_width_array, ''); ?>
								</span>
								<span id="geometryLat">
									<label><?php echo Kohana::lang('ui_main.latitude');?>:</label> 
									<?php print form::input('geometry_lat', '', ' class="lbl_text"'); ?>
								</span>
								<span id="geometryLon">
									<label><?php echo Kohana::lang('ui_main.longitude');?>:</label> 
									<?php print form::input('geometry_lon', '', ' class="lbl_text"'); ?>
								</span>
							</div>
						</div>
						<div id="geometryLabelerClose"></div>
					</div>
				</div>

				<div class="well">
					<div id="panel" class="olControlEditingToolbar"></div>
					<div class="map-btns">
						<ul class="unstyled">
							<li><a href="#" class="btn btn-info btn-mini"><?php echo utf8::strtoupper(Kohana::lang('ui_main.delete_last'));?></a></li>
							<li><a href="#" class="btn btn-info btn-mini"><?php echo utf8::strtoupper(Kohana::lang('ui_main.delete_selected'));?></a></li>
							<li><a href="#" class="btn btn-info btn-mini"><?php echo utf8::strtoupper(Kohana::lang('ui_main.clear_map'));?></a></li>
						</ul>
					</div>
					
					<div class="report_row">
						<div class="input-append">
							<?php print form::input('location_find', '', ' title="'.Kohana::lang('ui_main.location_example').'" class="findtext span3"'); ?>
							<input type="button" name="button" id="button" value="<?php echo Kohana::lang('ui_main.find_location'); ?>" class="btn btn-inverse">
						</div>
						<div id="find_loading" class="report-find-loading"></div>
					</div>
					
					<span class="help-block"><?php echo Kohana::lang('ui_main.pinpoint_location'); ?></span>
				</div>
			</div>
			<?php Event::run('ushahidi_action.report_form_location', $id); ?>
			<div class="report_row">
				<label><?php echo Kohana::lang('ui_main.reports_location_name'); ?><span class="required">*</span></label>
				<?php print form::input('location_name', $form['location_name'], ' class="span3"'); ?>
				<span class="help-block"><?php echo Kohana::lang('ui_main.detailed_location_example'); ?></span>
			</div>

			<!-- News Fields -->
			<div id="divNews" class="report_row">
				<label><?php echo Kohana::lang('ui_main.reports_news'); ?></label>
				
				<?php 
					// Initialize the counter
					$i = (empty($form['incident_news'])) ? 1 : 0;
				?>

				<?php if (empty($form['incident_news'])): ?>
					<div class="report_row">
						<?php print form::input('incident_news[]', '', ' class="span5"'); ?>
						<a href="#" class="add" onClick="addFormField('divNews','incident_news','news_id','text'); return false;">add</a>
					</div>
				<?php else: ?>
					<?php foreach ($form['incident_news'] as $value): ?>
					<div class="report_row" id="<?php echo $i; ?>">
						<?php echo form::input('incident_news[]', $value, ' class="span5"'); ?>
						<a href="#" class="add" onClick="addFormField('divNews','incident_news','news_id','text'); return false;">add</a>

						<?php if ($i != 0): ?>
							<?php $css_id = "#incident_news_".$i; ?>
							<a href="#" class="rem"	onClick="removeFormField('<?php echo $css_id; ?>'); return false;">remove</a>
						<?php endif; ?>

					</div>
					<?php $i++; ?>

					<?php endforeach; ?>
				<?php endif; ?>

				<?php print form::input(array('name'=>'news_id', 'type'=>'hidden', 'id'=>'news_id'), $i); ?>
			</div>


			<!-- Video Fields -->
			<div id="divVideos" class="control-group">
				<label><?php print Kohana::lang('ui_main.external_video_link'); ?></label>
				<?php $i = (empty($form['incident_video'])) ? 1 : 0; ?>
				<?php if (empty($form['incident_video'])): ?>
					<?php print form::input('incident_video[]', '', ' class="span5"'); ?>
					<a href="#" class="add" onClick="addFormField('divVideo','incident_video','video_id','text'); return false;">add</a>
				<?php else: ?>
					<?php foreach ($form['incident_video'] as $value): ?>
						<div class="control-group" id="<?php  echo $i; ?>">

						<?php print form::input('incident_video[]', $value, ' class="span5"'); ?>
						<a href="#" class="btn btn-mini" onClick="addFormField('divVideo','incident_video','video_id','text'); return false;">add</a>

						<?php if ($i != 0): ?>
							<?php $css_id = "#incident_video_".$i; ?>
							<a href="#" class="rem"	onClick="removeFormField('<?php echo $css_id; ?>'); return false;">remove</a>
						<?php endif; ?>

						</div>
						<?php $i++; ?>
					
					<?php endforeach; ?>
				<?php endif; ?>

				<?php print form::input(array('name'=>'video_id','type'=>'hidden','id'=>'video_id'), $i); ?>
			</div>
			
			<?php Event::run('ushahidi_action.report_form_after_video_link'); ?>
 
			<!-- Photo Fields -->
			<div id="report-photos" class="control-group">
				<label><?php echo Kohana::lang('ui_main.reports_photos'); ?></label>
				<?php $i = (empty($form['incident_photo']['name'][0])) ? 1 : 0; ?>
				<?php if (empty($form['incident_photo']['name'][0])): ?>
					<?php print form::upload('incident_photo[]', '', ' class="input-file"'); ?>
					<a href="#" class="btn btn-mini" onClick="addFormField('divPhoto','incident_photo','photo_id','file'); return false;">add</a>
				<?php else: ?>
					<?php foreach ($form['incident_photo']['name'] as $value): ?>
						<div id="<?php echo $i; ?>">
							<?php print form::upload('incident_photo[]', $value, ' class="span6"'); ?>
							<a href="#" class="add" onClick="addFormField('divPhoto','incident_photo','photo_id','file'); return false;">add</a>

							<?php if ($i != 0): ?>
								<?php $css_id = "#incident_photo_".$i; ?>
								<a href="#" class="rem"	onClick="removeFormField('<?php echo $css_id; ?>'); return false;">remove</a>
							<?php endif; ?>
						</div>

						<?php $i++; ?>
					<?php endforeach; ?>
				<?php endif; ?>

				<?php print form::input(array('name'=>'photo_id','type'=>'hidden','id'=>'photo_id'), $i); ?>
			</div> <!-- /report-photos -->

		</div>

		<div class="span12 form-actions">
					<input name="submit" type="submit" value="<?php echo Kohana::lang('ui_main.reports_btn_submit'); ?>" class="btn btn-primary btn-large">
		</div>
	</div>
	</fieldset>
	<?php print form::close(); ?>
	<!-- end report form block -->
</div>

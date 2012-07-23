<!DOCTYPE html>
<html lang="en">
<head>
	<title><?php echo html::specialchars($page_title.$site_name); ?></title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php echo $header_block; ?>
	<?php if (!Kohana::config('settings.enable_timeline')) { ?>
		<style>
			#graph{display:none;}
		</style>
	<?php } ?>
	<?php
	// Action::header_scripts - Additional Inline Scripts from Plugins
	Event::run('ushahidi_action.header_scripts');
	?>
</head>

<?php
	// Add a class to the body tag according to the page URI

	// we're on the home page
	if (count($uri_segments) == 0)
	{
		$body_class = "page-main";
	}
	// 1st tier pages
	elseif (count($uri_segments) == 1)
	{
		$body_class = "page-".$uri_segments[0];
	}
	// 2nd tier pages... ie "/reports/submit"
	elseif (count($uri_segments) >= 2)
	{
		$body_class = "page-".$uri_segments[0]."-".$uri_segments[1];
	}
?>

<body id="page" class="<?php echo $body_class; ?>">

	<div id="nav-main" class="navbar navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container">
				<ul class="nav">
					<?php nav::main_tabs($this_page); ?>
					<?php if ($allow_feed == 1) { ?>
					<li class="divider-vertical"></li>
					<li>
						<a href="<?php echo url::site(); ?>feed/">Reports RSS</a>
					</li>
					<?php } ?>
				</ul>
				<div class="btn-group pull-right">
					<a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#">
						<i class="icon-user"></i> Login
						<span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
						<li><a href="#">Profile</a></li>
						<li class="divider"></li>
						<li><a href="#">Sign Out</a></li>
					</ul>
				</div>
				<div class="pull-right">
					<?php echo $languages;?>
				</div>
			</div>
		</div>
	</div> <!-- /nav-main -->

	<div id="bento" class="container">
		<div id="masthead" class="row">
			<?php if ($banner == NULL): ?>
			<div id="sitename" class="span6">
				<h1><a href="<?php echo url::site();?>"><?php echo $site_name; ?></a></h1>
				<span><?php echo $site_tagline; ?></span>
			</div>
			<?php else: ?>
			<a href="<?php echo url::site();?>"><img src="<?php echo $banner; ?>" alt="<?php echo $site_name; ?>" /></a>
			<?php endif; ?>

			<div class="span2">
				<a href="/reports/submit" id="submit-report" class="btn btn-success btn-large">Submit a Report</a>
			</div>

			<div class="span4">
				<?php echo form::open("search", array('method' => 'get', 'id' => 'site-search','class'=>'form-inline')); ?>
					<div class="control-group">
						<div class="controls">
							<div class="input-prepend">
								<span class="add-on"><i class="icon-search"></i></span><input class="span3" id="inputIcon" type="text" name="k" value="<?php echo Kohana::lang('ui_main.search'); ?>">
							</div>
						</div>
					</div>
				<?php form::close(); ?>
			</div>
		</div> <!-- /masthead -->

		<?php
			// Action::header_item - Additional items to be added by plugins
			Event::run('ushahidi_action.header_item');
		?>

		<hr>

		
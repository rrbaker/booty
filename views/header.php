<!DOCTYPE html>
<html lang="en">
<head>
	<title><?php echo html::specialchars($page_title.$site_name); ?></title>
	<meta charset="utf-8">
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
				<a class="brand" href="/">HuffPo</a>
				<ul class="nav">
					<?php nav::main_tabs($this_page); ?>
					<?php if ($allow_feed == 1) { ?>
					<li class="divider-vertical"></li>
					<li>
						<a href="<?php echo url::site(); ?>feed/"><img src="<?php echo url::file_loc('img'); ?>media/img/icon-feed.png" alt="RSS feed icon"></a>
					</li>
					<?php } ?>
				</ul>
				<ul class="nav pull-right">
					<li class="divider-vertical"></li>
					<li><a href="#">Login</a></li>
				</ul>
				<form class="navbar-search pull-right">
					<?php echo $search; ?>
				</form>
			</div>
		</div>
	</div> <!-- /nav-main -->

	<div id="bento" class="container">
		<div id="masthead" class="row">

			<!-- logo -->
			<?php if ($banner == NULL): ?>
			<div id="sitename" class="span8">
				<h1><a href="<?php echo url::site();?>"><?php echo $site_name; ?></a></h1>
				<span><?php echo $site_tagline; ?></span>
			</div>
			<?php else: ?>
			<a href="<?php echo url::site();?>"><img src="<?php echo $banner; ?>" alt="<?php echo $site_name; ?>" /></a>
			<?php endif; ?>

			<div class="span4">
				<?php echo $languages;?>
				<?php echo $submit_btn; ?>
			</div>
		</div>

		<?php
			// Action::header_item - Additional items to be added by plugins
			Event::run('ushahidi_action.header_item');
		?>

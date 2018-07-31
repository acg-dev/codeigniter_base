<script type="text/javascript">
	<?php if(!empty($analytics->event)): ?>
		<?php foreach($analytics->event as $event): ?>
			dataLayer.push({'event':'event_activation','dl_category': '<?php echo $event->category; ?>','dl_action': '<?php echo $event->action; ?>','dl_label': '<?php echo $event->label; ?>','dl_value': '<?php echo $event->value; ?>'});
		<?php endforeach; ?>
	<?php endif; ?>
	<?php if(!empty($analytics->pageview)): ?>
		<?php foreach($analytics->pageview as $pageview): ?>
			dataLayer.push({'event':'pageview_activation','dl_category': '<?php echo $pageview->title; ?>','dl_action': '<?php echo $pageview->url; ?>'});
		<?php endforeach; ?>
	<?php endif; ?>
</script>
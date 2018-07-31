<?php if(!empty($notifications)): ?>
<div class="modal fade <?php if($level != 'CUSTOM') echo 'classic'; ?>" id="system-notification" tabindex="-1" role="dialog" aria-labelledby="system-notification">
  <div class="modal-dialog transparent-dialog " role="document">
    <div class="modal-content text-center">
      <?php foreach($notifications as $level => $notification): ?>
        <?php if(!empty($notification->messages)): ?>
          <div class="modal-body <?php echo $level; ?> text-center">
            <button type="button" class="close" style="position: absolute;top: 0; right: 7px;" data-dismiss="modal" aria-label="Close"><i class="fa fa-times"></i></button>
            <?php if($level != 'CUSTOM'): ?><i class="fa fa-exclamation-circle"></i><?php endif; ?>
            <?php foreach($notification->messages as $message): ?>
              <p><?php echo $message; ?></p>
            <?php endforeach; ?>
          </div>
	<script type="text/javascript">
	  $(document).ready(function(){
	    $('#system-notification').modal('show');
      if($('#system-notification .modal-body').hasClass("CUSTOM")){
        $('#system-notification .modal-header .close').removeClass('hidden');
      }
	    setTimeout(function(){$('#system-notification').modal('hide');}, <?php echo ($level == 'CUSTOM')? 20000 : 10000; ?>);
	  });
	</script>
        <?php endif; ?>
    <?php endforeach; ?>
    </div>
  </div>
</div>
<?php endif; ?>
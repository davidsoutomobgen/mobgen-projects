<h2>Logs</h2>
<div class="logs"><?php $this->renderPartial('_log', array('log' => $log, 'type' => 'logs')); ?> </div>
<div class="logs-script"><?php $this->renderPartial('_log', array('log' => $logScript, 'type' => 'logs-script')); ?></div>

<script>
    var refreshId = setInterval(function()
    {
        $('.logs').load("<?php echo _url('admin/loadLog'); ?>");
        $('.logs-script').load("<?php echo _url('admin/loadLog', array('type' => 'logs-script')); ?>");
    }, 10000);
</script>
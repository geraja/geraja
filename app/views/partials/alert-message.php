<?php

$alert_type = $this->session->userdata('alert_type');
$alert_message = $this->session->userdata('alert_message');

if($alert_type && $alert_message): ?>
<div class="alert <?php echo $alert_type; ?>">
  <?php echo $alert_message; ?>
</div>
<?php endif; ?>

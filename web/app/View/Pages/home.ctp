<?php

if (Configure::read('debug') == 0):
    throw new NotFoundException();
endif;
App::uses('Debugger', 'Utility');
?> 

<h2><?php echo __('Nerdery XBox Voting Site'); ?></h2>
<div class="actions">
    
    <ul>
	<li><?php echo $this->Html->link(__('Users'), array('controller' => 'users', 'action' => 'index')); ?></li>
	<?php if (isset($currentuser) && $currentuser['User']['role'] == 'admin') { ?>
    	<li><?php echo $this->Html->link(__('Games'), array('controller' => 'games', 'action' => 'index')); ?></li>
	<?php } else { ?>
    	<h3>Please create a user account, and login with an admin role to in order to vote.</h3>
	<?php } ?>
    </ul>
</div>
<?php if (!empty($games)) { ?>
    <div class="games index">
        <h2><?php echo __('Vote for the title you would the Nerdery to buy.'); ?></h2>

        <table cellpadding="0" cellspacing="0">
    	<tr>
    	    <th>Title</th>
    	    <th>Votes</th>
		<?php if ($allow_vote) { ?>
		    <th class="actions"><?php echo __('Actions'); ?></th>
		<?php } ?>
    	</tr>
	    <?php foreach ($games as $game): ?>
		<tr>

		    <td><?php echo h($game['title']); ?>&nbsp;</td>
		    <td><?php echo h($game['votes']); ?>&nbsp;</td>
		    <?php if ($allow_vote) { ?>
	    	    <td class="actions">
			    <?php echo $this->Form->postLink(__('Vote'), array('action' => 'vote', $game['id']), null, __('Yes, I\'m voting for %s?', $game['title'])); ?>
	    	    </td>
		    <?php } ?>
		</tr>
	    <?php endforeach; ?>
        </table>

    </div>
<?php } ?>
<?php if ($allow_vote) { ?>
    <div class="actions">
        <h3><?php echo __('Actions'); ?></h3>
        <ul>
    	<li><?php echo $this->Html->link(__('Add Title'), array('action' => 'add')); ?></li>
        </ul>
    </div>
<?php } ?>
<?php if (!empty($games)) { ?>
<div class="games index">
    <h2><?php echo __('Update the status of any of the wanted games.'); ?></h2>
    <table cellpadding="0" cellspacing="0">
	<tr>

	    <th>Title</th>
	    <th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($games as $game): ?>
    	<tr>

    	    <td><?php echo h($game['title']); ?>&nbsp;</td>
    	    <td class="actions">
		    <?php echo $this->Form->postLink(__('Got it!'), array('action' => 'update', $game['id']), null, __('The Nerdery has bought %s?', $game['title'])); ?>
    	    </td>
    	</tr>
	<?php endforeach; ?>
    </table>
</div>
<?php } ?>


<?php if (!empty($games)) { ?>
<div class="games index">
    <h2><?php echo __('Own'); ?></h2>
    <table cellpadding="0" cellspacing="0">
	<tr>

	    <th>Title</th>
	    <th>Status</th>

	</tr>
	<?php foreach ($games as $game): ?>
    	<tr>

    	    <td><?php echo h($game['title']); ?>&nbsp;</td>
    	    <td><?php echo h($game['status']); ?>&nbsp;</td>

    	</tr>
	<?php endforeach; ?>
    </table>
</div>
<?php } ?>
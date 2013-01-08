<div class="games form">
    <?php echo $this->Form->create('Game'); ?>
    <fieldset>
	<legend><?php echo __('Add Game'); ?></legend>
	<?php
	echo $this->Form->input('title', array('class'=>'ui-autocomplete-inupt', 'autocomplete'=>'false'));
	echo $this->Form->hidden('Game.title', array('id' => 'GameTitleName')); 
	?>
    </fieldset>
    <?php echo $this->Form->end(__('Submit')); ?>
</div>
<script type="text/javascript">
$(function () {	    
        $( "#GameTitle" ).autocomplete({
                source: "/games/names/",
                minLength: 2,
		select: function(event, ui) {
		    $("#GameTitleName").val(ui.item.GameTitle.name);
		    $("#GameAddForm").submit();
		}
        }).focus(function(){
	    $(this).val('');
	}).data("autocomplete")._renderItem = function (ul, item) {
                var spanHtml = '<a>' + item.GameTitle.name + '</a>';
                return $('<li></li>')
					.data("item.autocomplete", item)
					.append(spanHtml)
					.appendTo(ul);
            };
});    
</script>
<?php
	$row_index = 1;
	foreach(array_reverse($zone['seats']) AS $row_name=>$chair_list):
?>
	<div class="row row-<?= $row_name ?> row-index-<?= $row_index ?>">
<?php
		$row_index++;

		$position_index=1;
		foreach($chair_list AS $chair_key => $chair):
			if($chair['no']>0):
				$chair_id = $chair['id'];
				$chair_no = $row_name . $chair['no'];
				$chiar_position = $chair['position'];
				if(($chair['is_booked']==1 && $chair['is_own']==0) || $chair['is_soldout']==1):
					echo '<div class="booked pos pos-'.$chiar_position.'"></div>';
				else:
				?>
					<a href="#<?= $chair_no ?>" title="<?= strtoupper($chair_no) ?>" id="b-<?= $chair_no ?>" class="pos pos-<?= $chiar_position ?> <?= ($chair['is_own']==1)?'active':'' ?>"></a>
					<?= form_checkbox(array(
						'name'=>'seat[]', 'id'=>$chair_no, 'value'=>$chair_id,
						'checked'=>($chair['is_own']==1),
						'style'=>'left:'.(($chair['no'] * 15)+650).'px;'
					)) ?>
				<?php
				endif;
			else:
				?>
					<div class="pos pos-<?= $position_index ?>"></div>
				<?php
			endif;
			$position_index++;
		endforeach;
?>
	</div>
<?php
	endforeach;
?>
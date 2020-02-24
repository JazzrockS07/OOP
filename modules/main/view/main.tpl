<div class="main-page">
	<div class="bg">
		<div class="text">
			<div class="text1">WINTER</div><br>
			<div class="text2">2020</div><br>
			<div class="text3">CLOTHES COLLECTION IS ON OFFER</div>
		</div>
	</div>

	<?php if(!$res->num_rows) { ?>
		<div>Отсутствуют записи</div>
	<?php } else { ?>
		<ul style="width:150px; margin:auto;">
			<?php while($row = $res->fetch_assoc()) { ?>
				<li><?php echo $row['email']; ?></li>
			<?php } ?>
		</ul>
	<?php } ?>



	<div class="pag"><?=\FW\Pagination\Pagination::nav();?></div>

</div>

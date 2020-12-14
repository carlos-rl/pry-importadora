<ul class="breadcrumb">
	<?php for ($i = 0; $i < count($breadcrumb); $i++) { ?>
		<?php $ins = $breadcrumb[$i]; ?>
		<li>
			<a href="<?= $ins['url'] ?>">
				<font style="vertical-align: inherit;">
				<font style="vertical-align: inherit;">
				<?= $ins['name'] ?>
				</font>
				</font>
			</a>
		</li>
		<?php ?>
	<?php } ?>
</ul>
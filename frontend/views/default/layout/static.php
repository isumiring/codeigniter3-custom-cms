<div class="border-line">
	<div class="container">
		<div class="row">
			<div class="col-md-24">
				<h4><?php echo $page_title; ?></h4>
			</div>
			<!-- /.col-md-24 -->
		</div>
		<!-- /.row -->			
	</div>
	<!-- /.container -->	
</div>
<!-- /.border-line -->
<div id="static-layout">
	<div class="container">
		<div class="row form-message">
			<div class="col-md-20">
				<?php if (isset($tmp_message)) {
					echo $tmp_message;
				} ?>
			</div>
		</div>
	</div>
	<!-- /.container -->
</div>
<!-- /#shipment-form -->
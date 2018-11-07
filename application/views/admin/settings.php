<?php include('header.php')?>

<section class="content">

	<div class="row">
		<div class="col-md-9">
			<div class="box box-info">

				<ul class="nav nav-tabs">
					<li class="active"><a data-toggle="tab" href="#seo">Seo</a></li>
					<li><a data-toggle="tab" href="#menu1">Menu 1</a></li>
					<li><a data-toggle="tab" href="#menu2">Menu 2</a></li>
				</ul>

				<div class="tab-content">
					<div id="seo" class="tab-pane fade in active">
						<div class='row'>
							<div class="col-md-9">
								<div class="box-body">
                                <form role="form" method="POST" action='<?php echo site_url('admin/save_seo')?>'>
									<div class="form-group">
										<label for="exampleInputEmail1">Code</label>
										<input type="text" class="form-control" name='code' placeholder="" >
									</div>
									<div class="form-group">
										<label for="exampleInputPassword1">Value</label>
										<textarea class="form-control" rows="3" placeholder="" name='value'></textarea>
									</div>
								
                                    
                                    <div class="box-footer">
                <button type="submit" class="btn btn-primary">Save</button>
              </div>
            </form>
								</div>
							</div>
						</div>
					</div>
					<div id="menu1" class="tab-pane fade">
						<h3>Menu 1</h3>
						<p>Some content in menu 1.</p>
					</div>
					<div id="menu2" class="tab-pane fade">
						<h3>Menu 2</h3>
						<p>Some content in menu 2.</p>
					</div>
				</div>



			</div>
			<!-- /.box -->


		</div>
	</div>

</section>
<?php include('footer.php')?>

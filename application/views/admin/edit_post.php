<?php include('header.php')?>


<section class="content">
	<div class="row">
		<div class="col-md-9">
			<div class="box box-info">
				<div class="box-header">
					<h3 class="box-title">
						Edit
					</h3>
					<a role="button" id='btn-simpan' href='<?php echo site_url('admin/all_post')?>' class="btn btn-info pull-right">Back</a>
					<!-- tools box -->
					
					<!-- /. tools -->
				</div>
				<!-- /.box-header -->
				<form method="POST" action='<?php echo site_url('admin/save_new_post')?>'> <div class="box-body pad">
                    <input type="hidden" id="id-post" value='<?php echo $post[0]->id?>'>
					<input class="form-control" type="text" placeholder="Enter Title" id="title" value='<?php echo $post[0]->title?>'><br>
					<textarea id="editor1" name="editor1" rows="10" cols="80" style="visibility: hidden; display: none;"><?php echo $post[0]->content?>  </textarea> <br>
					<input class="form-control form-upload" type="text" placeholder="Enter Title" id="image" value='<?php echo $post[0]->image?>'>
					<button type="button" id='btn-upload' class="btn btn-primary">upload</button><br>
			</div>

			<div class="box-footer">
				<button type="button" id='btn-edit' class="btn btn-primary">Save</button>
			</div>
			
		</div>
		<!-- /.box -->


	</div>

	<div class="col-md-3">


		<!-- /.box -->

		<div class="box box-info">
			<div class="box-header">
				<h3 class="box-title">Catrgory</h3>
			</div>
			<div class="box-body">
				<!-- Color Picker -->
				<div class="form-group">
				<div id='list-category'>
				<?php 
						$i=0;

						foreach($data as $obj){
							$str=$obj->id;
							
							if (in_array($str, array_column($check_category, 'category_id'))) {
								echo"
								<div class='checkbox'>
									<label>
										<input value='$obj->id' class='id_category' type='checkbox' checked>
										$obj->name
									</label>
								</div>
								
								";
							}else{
								echo"
								<div class='checkbox'>
									<label>
										<input value='$obj->id' class='id_category' type='checkbox'>
										$obj->name
									</label>
								</div>
								
								";
							}
							$i++;								
						}

						?>
						</div>
					
				
						</form>
					<input type="text" class="form-control " placeholder="Add New Category" id="name_of_category">
				</div>

				<!-- /.form group -->


			</div>
			<!-- /.box-body -->
			<div class="box-footer">
				<button type="button" class="btn btn-primary" id="btn-kategori">Save</button>
			</div>
		</div>
		<!-- /.box -->

	</div>
	<!-- /.col-->
	</div>
	<!-- ./row -->
</section>
<?php include('footer.php')?>

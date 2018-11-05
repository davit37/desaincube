<?php include('header.php');
$this->load->helper('function');

?>

<section class="content">
	<div class="row">
		<div class="col-xs-12">
		
			<!-- /.box -->

			<div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">User</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-bordered">
                <thead><tr>
                  <th width='40%'>judul</th>
                  <th>Penulis</th>
                  <th>Kategori</th>
                  <td>Tanggal Terbit</td>                 
                </tr>
               
                </thead>
              <tbody>
                <?php 
                foreach($data as $obj){
                  $url=site_url('admin/edit_post/'.$obj->id);    
                  $waktu=konfersi_waktu($obj->post_date);            

                    echo"
                    <tr>
                        <td>$obj->title</td>
                        <td>$obj->display_name</td>
                        <td> </td>
                        <td>".$waktu." </td>
                    
                        <td>
					            	 <a title='edit Post' href='$url'  role='button' class='btn btn-warning btn-sm editBarang'><i class='fa fa-pencil'></i></a>
                         <button title='Delete Post' triger='delete_post' data-toggle='modal' data-target='#edit' id='$obj->id' type='button' class='btn btn-danger btn-sm delete'><i class='fa fa-trash'></i> </button>
	                    </td>

                        
                    </tr>
                    
                    ";
                        }

                ?>

              </tbody></table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
              <ul class="pagination pagination-sm no-margin pull-right">
                <li><a href="#">«</a></li>
                <li><a href="#">1</a></li>
                <li><a href="#">2</a></li>
                <li><a href="#">3</a></li>
                <li><a href="#">»</a></li>
              </ul>
            </div>
          </div>
			<!-- /.box -->
		</div>
		<!-- /.col -->
	</div>
	<!-- /.row -->
</section>


<?php include('footer.php')?>

<?php include('db_connect.php');?>

<div class="container-fluid">
	
	<div class="col-lg-12">
		<div class="row mb-4 mt-4">
			<div class="col-md-12">
				
			</div>
		</div>
		<div class="row">
			<!-- FORM Panel -->

			<!-- Table Panel -->
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">
						<b>Daftar Buku</b>
						<span class="float:right"><a class="btn btn-primary btn-block btn-sm col-sm-2 float-right" href="javascript:void(0)" id="new_book">
					<i class="fa fa-plus"></i> Tambah Data Baru
				</a></span>
					</div>
					<div class="card-body">
						<table class="table table-condensed table-bordered table-hover">
							<thead>
								<tr>
									<th class="text-center">#</th>
									<th class="">Peminjam</th>
									<th class="">Tanggal Pengambilan</th>
									<th class="">Tanggal Pengembalian</th>
									<th class="">Info Pelaminan</th>
									<th class="">Status</th>
									<th class="text-center">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$i = 1;
								$cat = array();
								$cat[] = '';
								$qry = $conn->query("SELECT * FROM categories ");
								while($row = $qry->fetch_assoc()){
									$cat[$row['id']] = $row['name'];
								}
								$tt = array();
								$tt[] = '';
								$qry = $conn->query("SELECT * FROM tipe_dekorasi ");
								while($row = $qry->fetch_assoc()){
									$tt[$row['id']] = $row['name'];
								}
								$et = array();
								$et[] = '';
								$qry = $conn->query("SELECT * FROM tipe_bajuadat ");
								while($row = $qry->fetch_assoc()){
									$et[$row['id']] = $row['name'];
								}
								$books = $conn->query("SELECT b.*,c.model,c.brand,c.transmission_id,c.engine_id FROM buku b inner join pelaminan c on c.id = b.car_id ");
								while($row=$books->fetch_assoc()):
									
								?>
								<tr>
									<td class="text-center"><?php echo $i++ ?></td>
									<td class="">
										 <p> <b><?php echo ucwords($row['name']) ?></b></p>
									</td>
									<td class="">
										 <p> <b><?php echo date("M d,Y h:i A",strtotime($row['pickup_datetime'])) ?></b></p>
									</td>
									<td class="">
										 <p> <b><?php echo date("M d,Y h:i A",strtotime($row['dropoff_datetime'])) ?></b></p>
									</td>
									<td>
										 <p>Brand: <b><?php echo ucwords($row['brand']) ?></b></p>
										 <p>Model: <b><?php echo ucwords($row['model']) ?></b></p>
									</td>
									<td>
										<?php if($row['status'] == 1): ?>
										<span class="badge badge-secondary">Tertunda</span>
										<?php elseif($row['status'] == 2): ?>
										<span class="badge badge-primary">Terkonfirmasi</span>
										<?php else: ?>
										<span class="badge badge-danger">Dibatalkan</span>
										<?php endif; ?>
									</td>
									<td class="text-center">
										<button class="btn btn-sm btn-outline-primary edit_book" type="button" data-id="<?php echo $row['id'] ?>" >Edit</button>
										<button class="btn btn-sm btn-outline-danger delete_book" type="button" data-id="<?php echo $row['id'] ?>">Delete</button>
									</td>
								</tr>
								<?php endwhile; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<!-- Table Panel -->
		</div>
	</div>	

</div>
<style>
	
	td{
		vertical-align: middle !important;
	}
	td p{
		margin: unset
	}
	img{
		max-width:100px;
		max-height: :150px;
	}
</style>
<script>
	$(document).ready(function(){
		$('table').dataTable()
	})
	
	$('.view_book').click(function(){
		window.open("../index.php?page=view_book&id="+$(this).attr('data-id'))
		
	})
	$('#new_book').click(function(){
		uni_modal("New Book","manage_booking.php","mid-large")
		
	})
	$('.edit_book').click(function(){
		uni_modal("Manage Book Details","manage_booking.php?id="+$(this).attr('data-id'),"mid-large")
		
	})
	$('.delete_book').click(function(){
		_conf("Are you sure to delete this book?","delete_book",[$(this).attr('data-id')])
	})
	
	function delete_book($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_book',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp==1){
					alert_toast("Data successfully deleted",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})
	}
</script>
<!DOCTYPE html>
<html>
<head>
	
	<title></title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				
				@if (session('status'))
				<h6 class="alert alert-success">{{session('status')}}</h6>
				@endif

				<div class="card">
					<div class="card-header">
						<h4>Laravel Image CRUD
							<a href="{{ url('add-product') }}" class="btn btn-primary btn-sm float-end">Add Product</a>
						</h4>
					</div>
					<div class="card-body">

						<table class="table table-bordered table-striped">
							<thead>
								<tr>
									<th>ID</th>
									<th>Name</th>
									<th>Price</th>
									<th>Image</th>
									<th>Edit</th>
									<th>Delete</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($products as $item)
								<tr>
									<td>{{ $item->id }}</td>
									<td>{{ $item->name }}</td>
									<td>{{ $item->price }}</td>

									
									<td>
										<img src="{{asset($item->image)}}" class="rounded-circle" width="50px" height="50px" alt="Image">
									<td>
										<a href="{{ url('edit-product/'.$item->id) }}"class="btn btn-success btn-sm">Edit</a>
									</td>
									<td>
										<form action="{{ url('delete-product/'.$item->id) }}" method="POST">
											@csrf
											@method('DELETE')
											<button type="submit" class="btn btn-danger btn-sm">Delete</button>
										</form>
									</td>		
								</tr>
								@endforeach
								<div class="form-group mb-3">
								<form action="{{url('products/importData')}}" method="POST" enctype="multipart/form-data">
								{{csrf_field()}}

								<button id="downloadButton">Download CSV</button>
    
    <script>
        document.getElementById("downloadButton").addEventListener("click", function() {
            downloadCSV();
        });
    </script>
							</tbody>
						</table>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
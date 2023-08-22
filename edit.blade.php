<!DOCTYPE html>
<html>
<head>
	
	<title></title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>
<body>
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-6">
				@if (session('status'))
					<h6 class="alert alert-success">{{session('status')}}</h6>
				@endif	
				<div class="card">
					<div class="card-header">
						<h4> Edit Product
							<a href="{{ url('products') }}" class="btn btn-danger btn-sm float-end">BACK</a>
						</h4>
					</div>
					<div class="card-body">

						<form action="{{ url('update-product/'.$product->id) }}"	method="POST" enctype="multipart/form-data">
							@csrf
							@method('PUT')

							<div class="form-group mb-3">
								<lable for="">Product Name</lable>
								<input type="text" name="name" value="{{$product->name}}" class="form-control">
							</div>

							<div class="form-group mb-3">
								<lable for="">Description</lable>
								<textarea name="description" class="form-control">{{$product->description}}</textarea>
							</div>

							<div class="form-group mb-3">
								<lable for="">Price</lable>
								<input type="text" name="price" value="{{$product->price}}"class="form-control">
							</div>

							<div class="form-group mb-3">
								<lable for="">Upload IMAGE</lable>
								<input type="file" name="image" class="form-control">
								<img src="{{ asset('uploads/product/'.$product->price) }}" width="70px" height="70px" alt="Img">
							</div>
							<div class="form-group mb-3">
								<button type="submit" class="btn btn-primary">Update </button>

							</div>
						</form>

				</div>
			</div>
		</div>
	</div>
</body>
</html>
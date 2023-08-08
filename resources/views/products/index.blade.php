<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title> how-to-insert-product-data-by-ajax-laravel </title>
</head>
<body>


<div class="container pt-5 ">
    <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#AddNewProductModal">
                Add New Product
            </button>
            <div class="card mt-5">
                <table class="table" id="table1">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">name</th>
                        <th scope="col">Price</th>
                        <th scope="col">Image</th>
                        <th scope="col">Action</th>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>

<!-- Add New Product  -->
<div class="modal fade" id="AddNewProductModal" tabindex="-1" aria-labelledby="AddNewProductModalLabel"
     aria-hidden="true">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="AddNewProductModalLabel"> Add New Product </h5>
                <button type="button" id="AddNewProductModalClose" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger d-none" id="save_errorList" role="alert"></div>

                <form class="AddNewProduct" id="AddNewProduct" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="name" class="form-label"> Name </label>
                        <input type="text" class="form-control" name="name">
                    </div>

                    <div class="mb-3">
                        <label for="price" class="form-label"> Price </label>
                        <input type="number" class="form-control" name="price">
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Image</label>
                        <input type="file" class="form-control" name="image">
                    </div>

                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Product  -->
<div class="modal fade" id="EditProductModal" tabindex="-1" aria-labelledby="EditProductModalLabel"
     aria-hidden="true">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="EditProductModalLabel"> Edit Product </h5>
                <button type="button" id="product_edit_modal_close" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger d-none" id="update_errorList" role="alert"></div>

                <form class="EditProductForm" id="EditProductForm" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="name" class="form-label"> Name </label>
                        <input type="text" class="form-control" id="name" name="name">
                        <input type="hidden" class="form-control" id="product_id" name="product_id">
                    </div>

                    <div class="mb-3">
                        <label for="price" class="form-label"> Price </label>
                        <input type="number" class="form-control" id="price" name="price">
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Image</label>
                        <input type="file" class="form-control" id="image" name="image">
                    </div>

                    <button type="submit" class="btn btn-primary"> Update</button>
                </form>
            </div>
        </div>
    </div>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ajaxy/1.6.1/scripts/jquery.ajaxy.min.js"
        integrity="sha512-bztGAvCE/3+a1Oh0gUro7BHukf6v7zpzrAb3ReWAVrt+bVNNphcl2tDTKCBr5zk7iEDmQ2Bv401fX3jeVXGIcA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>


<script>
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        getProducts();

        function getProducts() {

            $.ajax({
                type: "GET",
                url: "/products",
                dataType: 'json',
                success: function (response) {
                    // console.log(response.product);
                    var html = '';
                    var id = 1;
                    $.each(response.product, function (key,item) {
                        html += '<tr id=id>' +
                            '<th scope="row">' + id++ + '</th>' +
                            '<td>' + item.name + '</td>' +
                            ' <td>' + item.price + '</td>' +
                            '<td> <img width="100px" height="100px" src="' + item.image + '"/></td>' +
                            '<td><button type="button" class=" product_edit_btn btn btn-warning" value="' + item.id + '" >Edit</button>' +
                            '<button type="button" class=" product_delete_btn btn btn-danger" value="' + item.id + '" >Delete</button></td>' +
                            '</tr>'
                    })
                    $('tbody').html(html);
                }
            });
        }


        $(document).on('submit', '#AddNewProduct', function (e) {
            e.preventDefault();
            let productData = new FormData($('#AddNewProduct')[0]);
            //console.log(productData);
            $.ajax({
                url: "/products",
                type: "POST",
                data: productData,
                processData: false,
                contentType: false,
                success: function (response) {
                    //console.log(response.message)
                    if (response.status == 400) {
                        $('#save_errorList').html("");
                        $('#save_errorList').removeClass("d-none");
                        $.each(response.errors, function (key, err_value) {
                            $('#save_errorList').append(`<li>` + err_value + `</li>`);
                        });
                    } else if (response.status == 200) {
                        getProducts();
                        $('#save_errorList').html("");
                        $('#save_errorList').addClass("d-none");

                        document.getElementById("AddNewProduct").reset();
                        $('#AddNewProductModal').modal('hide');

                        // alert(response.message);
                    }
                }
            });
        })


        $(document).on("click", ".product_edit_btn", function () {
            var id = $(this).val();
            $('#EditProductModal').modal('show');
            $.ajax({
                url: "/product-edit/" + id,
                type: "GET",
                cache: false,
                success: function (respose) {
                    // console.log(respose.success)

                    if (respose.status == 404) {
                        $('#EditProductModal').modal('hide');
                        alert(respose.message)

                    } else {
                        $('#name').val(respose.product.name);
                        $('#price').val(respose.product.price);
                        $('#product_id').val(id);
                    }

                }
            });
        });


        $(document).on('submit', '#EditProductForm', function (e) {
            e.preventDefault();
            var id = $('#product_id').val();
            let productData = new FormData($('#EditProductForm')[0]);
            $.ajax({
                url: "/product-update/" + id,
                type: "POST",
                data: productData,
                processData: false,
                contentType: false,
                success: function (response) {
                    //console.log(response);

                    if (response.status == 400) {
                        $('#update_errorList').html("");
                        $('#update_errorList').removeClass("d-none");
                        $.each(response.errors, function (key, err_value) {
                            $('#update_errorList').append(`<li>` + err_value + `</li>`);
                        });
                    } else if (response.status == 200) {
                        getProducts();
                        $('#update_errorList').html("");
                        $('#update_errorList').addClass("d-none");
                        $('#product_edit_modal_close').click();
                        $('#EditProductModal').hide();
                        document.getElementById("EditProductForm").reset();

                        //alert(response.message);
                    }
                }
            });
        })


        // delete product data
        $(document).on("click", ".product_delete_btn", function () {
            var id = $(this).val();
            $.ajax({
                url: "/product-delete/" + id,
                type: "GET",
                cache: false,
                success: function (response) {
                    getProducts();
                }
            });
        });
    });


</script>


</body>
</html>

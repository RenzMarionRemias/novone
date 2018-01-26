@extends('admin.main') @include('admin.partials.sidebar')
<div class='col-xs-12 col-sm-10 col-md-10 pull-right' style='padding-left:100px;'>


    @if(Session::has('success'))
    <div class="alert alert-success">
        Category has been added! @php Session::forget('success'); @endphp
    </div>
    @endif
    <h2>Product Categories</h2>
    <a href='#' class='btn btn-primary pull-right' style="margin-top:24px;margin-bottom:24px;" data-toggle="modal" data-target="#addCategoryModal">Add Category</a>
    <br/>
    <table class="table list-data">
        <thead>
            <tr>
                <th>Category Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $category)
            <tr>
                <td>{{$category['name']}}</td>
                <td>
                    <a href='#' class='edit-product-category' data-toggle="modal" data-id="{{$category['id']}}" data-categoryname="{{$category['name']}}" data-target="#editCategoryModal">Edit</a> /
                    <a href="/novone/public/admin/category/delete/{{$category['id']}}">Delete</a>
                </td>
            </tr>
            @endforeach

        </tbody>
    </table>

</div>

<!-- ADD CATEGORY -->

<div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">×</span>
                    <span class="sr-only">Close</span>
                </button>
                <h3 class="modal-title" id="lineModalLabel">Add new category</h3>
            </div>

            <form class="form-inline" action='/novone/public/admin/category/add' method="POST" enctype="multipart/form-data">
                <div class='modal-body'>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <fieldset>
                        <div class="control-group">
                            <label class="control-label" for="product_name">Category Name</label>
                            <div class="controls">
                                <input type="text" id="category_name" required style="width:100% !important;" name="category_name" placeholder="" class="form-control">
                            </div>
                        </div>

                        <br>
                        <div class="control-group">
                            <!-- Button -->
                            <div class="controls">
                                <button class="btn btn-success">Save</button>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </form>

        </div>
    </div>
</div>

<!-- EDIT CATEGORY -->


<div class="modal fade" id="editCategoryModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">×</span>
                        <span class="sr-only">Close</span>
                    </button>
                    <h3 class="modal-title" id="lineModalLabel">Update category</h3>
                </div>
    
                <form class="form-inline" action='/novone/public/admin/category/update' method="POST">
                    <div class='modal-body'>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <fieldset>
                            <div class="control-group">
                                <label class="control-label" for="product_name">Category Name</label>
                                <div class="controls">
                                    <input type='hidden' id='editCategoryId' name="category_id"/>
                                    <input type="text" id="editCategoryName" style="width:100% !important;" required name="category_name" placeholder="" class="form-control">
                                </div>
                            </div>
    
                            <br>
                            <div class="control-group">
                                <!-- Button -->
                                <div class="controls">
                                    <button type='submit' class="btn btn-success">Save</button>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </form>
    
            </div>
        </div>
    </div>
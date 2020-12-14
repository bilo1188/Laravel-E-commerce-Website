@extends('admin.layouts.master')
@section('content')

<div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
               <div class="header-icon">
                  <i class="fa fa-users"></i>
               </div>
               <div class="header-title">
                  <h1>Edit Products</h1>
                  <small>Edit Products</small>
               </div>
            </section>
            
            @if(Session::has('flash_message_error'))
    <div class="alert alert-danger alert-block" role="alert">
       <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
       </button>
       <strong>{!! session('flash_message_error') !!}</strong>
    </div>
    @endif
    
    @if(Session::has('flash_mesaage_success'))
    <div class="alert alert-success alert-block" role="alert">
       <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
       </button>
       <strong>{!! session('flash_message_success') !!}</strong>
    </div>
    @endif
            <!-- Main content -->
            <section class="content">
               <div class="row">
                  <!-- Form controls -->
                  <div class="col-sm-12">
                     <div class="panel panel-bd lobidrag">
                        <div class="panel-heading">
                           <div class="btn-group" id="buttonlist"> 
                              <a class="btn btn-add " href="{{url('/admin/view-product')}}"> 
                              <i class="fa fa-eye"></i>  View Products  </a>  
                           </div>
                        </div>
                        <div class="panel-body">
                           <form class="col-sm-6" enctype="multipart/form-data" action="{{url('/admin/edit-product/'.$productDetails->id)}}" method="post">{{csrf_field()}}
                           <div class="form-group">
                                 <label>under category</label>
                                <select name="category_id" id="category_id" class="form-control">
                                 <?php echo  $categories_dropdown; ?>
                                 </select>
                              </div>
                              <div class="form-group">
                                 <label>Product Name</label>
                                 <input type="text" class="form-control" value="{{$productDetails->name}}" name="product_name" id="product_name" required>
                              </div>
                              <div class="form-group">
                                 <label>Product Code</label>
                                 <input type="text" class="form-control" value="{{$productDetails->code}}" name="product_code" id="product_code" required>
                                 
                              </div>
                              <div class="form-group">
                                 <label>Product Color</label>
                                 <input type="text" class="form-control" value="{{$productDetails->color}}" name="product_color" id="product_color" required>
                                 
                              </div>
                              <div class="form-group">
                                 <label>Product Description</label>
                                
                               <textarea name="product_description" id="product_description" class="form-control">
                               {{$productDetails->discription}}
                               </textarea>
                              
                                 <div class="form-group">
                                 <label>Product Price</label>
                                 <input type="text" class="form-control"  name="product_price" id="product_price" value="{{$productDetails->price}}"required>
                                 
                              </div>
                              </div>
                              <div class="form-group">
                                 <label>Picture upload</label>
                                 
                                 <input type="file" name="image">
                                 <input type="hidden" name="current_image" value="{{$productDetails->image}}">
                                 @if(!empty($productDetails->image))
                                 <img src="{{asset('uploads/product/'.$productDetails->image)}}" alt="" style="width:100px;margin-top:10px;">
                                       </td>
                                       @endif
                            
                              </div>
                            
                              
                              <div class="reset-button">
                                 
                                 <input type="submit" class="btn btn-success" value="Edit Product">
                              </div> 
                           </form>
                        </div>
                     </div>
                  </div>
               </div>
            </section>
         
@endsection
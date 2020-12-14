<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Products;
use App\Category;
use App\ProductsAttributes;
use App\ProductsImages;

use Image;



class ProductController extends Controller
{
    public function addProducts(Request $request){

        if($request->ismethod('post')){
            $data = $request->all();
            //echo " <pre>";print_r($data);die;
            $products=new Products;
            //$products->category_id=$data['category_id'];
            $products->category_id=$data['category_id'];
            $products->name= $data['product_name'];
            $products->code= $data['product_code'];
            $products->color= $data['product_color'];
            if(!empty($data['product_discription'])){
                $products->discription =$data['product_discription'];

            }else{
                $products->discription='';
            }
            $products->price=$data['product_price'];
            //upload imgae
          if($request->hasfile('image')){
                echo $img_temp = $request->file('image');
                if($img_temp->isValid()){

                
                //image path codde
                $extension = $img_temp->getClientOriginalExtension();
                $filename= rand(111,999999).'.'.$extension;
               $img_path = 'uploads/product/'.$filename;

                //img resize
                Image::make($img_temp)->resize(500,500)->save($img_path);
                $products->image = $filename;
           }
        }
     

            $products->save();
            return redirect('/admin/add-product')->with('flash_message_success','Product has been added ');
        }

        //Category drop down menu code

        $categories=Category::where(['parent_id'=>0])->get();
        $categories_dropdown="<option value=''selected disabled>Select</option>";
        foreach($categories as $cat){
            $categories_dropdown .="<option value='".$cat->id."'>".$cat->name."</option>";
            $sub_categories = Category::where(['parent_id'=>$cat->id])->get();
            foreach($sub_categories as $sub_cat)
            $categories_dropdown .="<option value='".$sub_cat->id."'>&nbsp;--&nbsp".$sub_cat->name."</option>";

        }
        return view('admin.products.add_product')->with(compact('categories_dropdown'));

    }
    public function viewProducts(){
        $products = Products::get();
        return view('admin.products.view_products')->with(compact('products'));

    }
    public function editProduct(Request $request,$id=null){
        if($request->isMethod('post')){
           $data = $request->all();
             //upload imgae
          if($request->hasfile('image')){
            echo $img_temp = $request->file('image');
            if($img_temp->isValid()){

            
            //image path codde
            $extension = $img_temp->getClientOriginalExtension();
            $filename= rand(111,999999).'.'.$extension;
           $img_path = 'uploads/product/'.$filename;

            //img resize
            Image::make($img_temp)->resize(500,500)->save($img_path);
            }    
       }else{
           $filename = $data['current_image'];
       }
       if(empty($data['product_discription'])){
           $data['product_discription']='';
       }
       Products::where(['id'=>$id])->update([
            'name'=>$data['product_name'],
            'category_id'=>$data['category_id'],
            'code'=>$data['product_code'],
            'color'=>$data['product_color'],
            'discription'=>$data['product_discription'],
            'price'=>$data['product_price'],
            'image'=>$filename]);
            return redirect('/admin/view-products')->with('flash_message_success','Product has been Updated Successfully!!!');
    }
    $productDetails = Products::where(['id'=>$id])->first();
    //categories drop down starts

    $categories = Category::where(['parent_id'=>0])->get();
    $categories_dropdown = "<option value='' selected disabled>Select</option>";
    foreach($categories as $cat){
        if($cat->id==$productDetails->category_id){
            $selected = "selected";
        }else{
            $selected = "";
        }
        $categories_dropdown .= "<option value='".$cat->id."' ".$selected.">".$cat->name."</option>";
    //code for showing subcategories in main category
    $sub_categories = Category::where(['parent_id'=>$cat->id])->get();
    foreach($sub_categories as $sub_cat){
        if($sub_cat->id==$productDetails->category_id){
            $selected = "selected";
        }else{
            $selected = "";
        }
    $categories_dropdown .= "<option value = '".$sub_cat->id."' ".$selected.">&nbsp;--&nbsp;".$sub_cat->name."</option>";
    }
} 
//categories drop down end
    return view('admin.products.edit_product')->with(compact('productDetails','categories_dropdown')); 

   

        
}
public function deleteProduct($id=null){
    Products::where(['id'=>$id])->delete();
    return redirect()->back()->with('flash_error_message','Product deleted');

}
public function products($id=null){
    $productDetails = Products::with('attributes')->where('id',$id)->first();
    $ProductAltImages = ProductsImages::where('product_id',$id)->get();
    //echo $productDetails;die;
    return view('wayshop.details')->with(compact('productDetails','ProductAltImages'));
}
public function addAttributes(Request $request,$id=null){
    $productDetails = Products::with('attributes')->where(['id'=>$id])->first();
    if($request->isMethod('post')){
        $data=$request->all();
        // echo "<pre>";print_r($data);die;
        foreach($data['sku'] as $key =>$val){
            if(!empty($val)){
                //prevent duplicate sku record
                $attrCountSKU = ProductsAttributes::where('sku',$val)->count();
                if($attrCountSKU>0){
                    return redirect('/admin/add-attributes/'.$id)->with('flash_message_error','sku is alredy exist please select another sku');
                }
                //prevent duplicate size record
                $attrCountSizes = ProductsAttributes::where(['product_id'=>$id,'size'=>$data['size']
                [$key]])->count();
                if($attrCountSizes>0){
                    return redirect('/admin/add-attributes/'.$id)->with('flash_message_error',''.$data['size'][$key].'size is alreyexist please elect another');
            }
              $attributes = new ProductsAttributes;
              $attributes->product_id = $id;
              $attributes->sku = $val;
              $attributes->size = $data['size'][$key];
              $attributes->price = $data['price'][$key];
              $attributes->stock = $data['stock'][$key];
              $attributes->save();
        }
                       
        }
        return redirect('/admin/add-attributes/'.$id)->with('flash_message_success','product attribuess succesfully ADDED');
    }
    return view('admin.products.add_attributes')->with(compact('productDetails'));
}
public function deleteAttributes($id=null){
    ProductsAttributes::where(['id'=>$id])->delete();
    return redirect()->back()->with('flash_message_error','product attribuess is deleted');
}
public function editAttributes(Request $request,$id=null){
    if($request->isMethod('post')){
        $data = $request->all();
        foreach($data['attr'] as $key=>$attr){
            ProductsAttributes::where(['id'=>$data['attr'][$key]])->update(['sku'=>$data['sku'][$key],
            'size'=>$data['size'][$key],'price'=>$data['price'][$key],'stock'=>$data['stock'][$key]]);
        }
        return redirect()->back()->with('flash_message_success','Products Attributes Updated!!!');
} 
}

public function addImages(Request $request,$id=null){
    $productDetails = Products::where(['id'=>$id])->first();
    if($request->isMethod('post')){
        $data = $request->all();
        if($request->hasfile('image')){
            $files = $request->file('image');
            foreach($files as $file){
                $image = new ProductsImages;
                $extension = $file->getClientOriginalExtension();
                $filename = rand(111,9999).'.'.$extension;
                $image_path = 'uploads/product/'.$filename;
                Image::make($file)->save($image_path);
                $image->image = $filename;
                $image->product_id = $data['product_id'];
                $image->save();
            }
        }
        return redirect('/admin/add-images/'.$id)->with('flash_message_success','Image has been updated');
    }
    $productImages = ProductsImages::where(['product_id'=>$id])->get();
    return view('admin.products.add_images')->with(compact('productDetails','productImages'));
}
public function deleteAltImage($id=null){
    $productImage = ProductsImages::where(['id'=>$id])->first();
    
    $image_path = 'uploads/product/';
    if(file_exists($image_path.$productImage->image)){
        unlink($image_path.$productImage->image);
    }
    
    ProductsImages::where(['id'=>$id])->delete();
    return redirect()->back();

}
}
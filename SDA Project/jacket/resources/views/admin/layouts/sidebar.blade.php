 <!-- =============================================== -->
         <!-- Left side column. contains the sidebar -->
         <aside class="main-sidebar">
            <!-- sidebar -->
            <div class="sidebar">
               <!-- sidebar menu -->
               <ul class="sidebar-menu">
                  <li class="active">
                     <a href="index.html"><i class="fa fa-tachometer"></i><span>Dashboard</span>
                     <span class="pull-right-container">
                     </span>
                     </a>
                  </li>
                  <li class="treeview">
                     <a href="#">
                     <i class="fa fa-list"></i><span>Categories</span>
                     <span class="pull-right-container">
                     <i class="fa fa-angle-left pull-right"></i>
                     </span>
                     </a>
                     <ul class="treeview-menu">
                        <li><a href="{{url('admin/add-category')}}">Add category</a></li>
                        <li><a href="{{url('admin/view-categories')}}">View categories</a></li>
                        
                     </ul>
                  </li>
                  <li class="treeview">
                     <a href="#">
                     <i class="fa fa-product-hunt"></i><span>Products</span>
                     <span class="pull-right-container">
                     <i class="fa fa-angle-left pull-right"></i>
                     </span>
                     </a>
                     <ul class="treeview-menu">
                        <li><a href="{{url('admin/add-product')}}">Add Products</a></li>
                        <li><a href="{{url('admin/view-products')}}">View Products</a></li>
                        
                     </ul>
                  </li>
                  
                  </li>
               </ul>
            </div>
            <!-- /.sidebar -->
         </aside>
         <!-- =============================================== -->
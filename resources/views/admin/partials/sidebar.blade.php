    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          {{-- <img src="{{ asset('admin_res/dist/img/user2-160x160.jpg') }}" class="img-circle" alt="User Image"> --}}
          <div class="user_letter">
            {{ Auth::user()->user_letter }}
          </div>
        </div>
        <div class="pull-left info">
          <p>{{ Auth::user()->name }}</p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- search form -->
      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
          <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="treeview">
          <a href="{{ route('admin.home') }}">
            <i class="fa fa-dashboard"></i> 
            <span>Dashboard</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ route('admin.home') }}"><i class="fa fa-circle-o"></i>Home</a></li>  
          </ul>
        </li>

        @can('department_show')
          <li class="treeview">
            <a href="#">
              <i class="fa fa-th"></i>
              <span>Department</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              @can('department_create')
                <li><a href="{{ route('departments.create') }}"><i class="fa fa-circle-o"></i>Add</a></li>          
              @endcan
              <li><a href="{{ route('departments.index') }}"><i class="fa fa-circle-o"></i>List</a></li>          
            </ul>
          </li>
        @endcan
        
        @can('level_term_show')
          <li class="treeview">
            <a href="#">
              <i class="fa fa-sliders"></i>
              <span>Level term</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              @can('level_term_create')
                <li><a href="{{ route('levelterms.create') }}"><i class="fa fa-circle-o"></i>Add</a></li> 
              @endcan         
              <li><a href="{{ route('levelterms.index') }}"><i class="fa fa-circle-o"></i>List</a></li>          
            </ul>
          </li>
        @endcan
        
        @can('course_show')
          <li class="treeview">
            <a href="#">
              <i class="fa fa-indent"></i>
              <span>Courses</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              @can('course_create')
                <li><a href="{{ route('courses.create') }}"><i class="fa fa-circle-o"></i>Add</a></li>          
              @endcan
              <li><a href="{{ route('courses.index') }}"><i class="fa fa-circle-o"></i>List</a></li>          
            </ul>
          </li>
        @endcan
        
        @can('post_show')
          <li class="treeview">
            <a href="#">
              <i class="fa fa-file-text"></i>
              <span>Posts</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              @can('post_create')
                <li><a href="{{ route('posts.create') }}"><i class="fa fa-circle-o"></i>Add</a></li>          
              @endcan
              <li><a href="{{ route('posts.index') }}"><i class="fa fa-circle-o"></i>List</a></li>          
            </ul>
          </li>
        @endcan

        @can('software_show')
          <li class="treeview">
            <a href="#">
              <i class="fa fa-laptop"></i>
              <span>Softwares</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              @can('software_create')
                <li><a href="{{ route('softwares.create') }}"><i class="fa fa-circle-o"></i>Add</a></li>          
              @endcan
              <li><a href="{{ route('softwares.index') }}"><i class="fa fa-circle-o"></i>List</a></li>          
            </ul>
          </li>
        @endcan

        @can('book_show')
          <li class="treeview">
            <a href="#">
              <i class="fa fa-book"></i>
              <span>Books</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              @can('book_create')
                <li><a href="{{ route('books.create') }}"><i class="fa fa-circle-o"></i>Add</a></li>          
              @endcan
              <li><a href="{{ route('books.index') }}"><i class="fa fa-circle-o"></i>List</a></li>          
            </ul>
          </li>
        @endcan
        
        @can('faq_show')
          <li class="treeview">
            <a href="#">
              <i class="fa fa-question"></i>
              <span>FAQ</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              @can('faq_create')
                <li><a href="{{ route('faqs.create') }}"><i class="fa fa-circle-o"></i>Add</a></li>          
              @endcan
              <li><a href="{{ route('faqs.index') }}"><i class="fa fa-circle-o"></i>List</a></li>          
            </ul>
          </li>
        @endcan
        
        @can('testimonial_show')
          <li class="treeview">
            <a href="#">
              <i class="fa  fa-comments-o"></i>
              <span>Testimonials</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              @can('testimonial_create')
                <li><a href="{{ route('testimonials.create') }}"><i class="fa fa-circle-o"></i>Add</a></li>          
              @endcan
              <li><a href="{{ route('testimonials.index') }}"><i class="fa fa-circle-o"></i>List</a></li>          
            </ul>
          </li>
        @endcan
        
        @can('contact_view')
          <li class="treeview">
            <a href="#">
              <i class="fa fa-share-alt"></i>
              <span>Contact</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">         
              <li><a href="{{ route('contacts.index') }}"><i class="fa fa-circle-o"></i>List</a></li>          
            </ul>
          </li>
        @endcan

        @can('user_show')
          <li class="treeview">
            <a href="#">
              <i class="fa fa-users"></i>
              <span>Users</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              @can('user_create')
                <li><a href="{{ route('users.create') }}"><i class="fa fa-circle-o"></i>Add</a></li>          
              @endcan
              <li><a href="{{ route('users.index') }}"><i class="fa fa-circle-o"></i>List</a></li>          
            </ul>
          </li>
        @endcan

        @can('userdata_show')
          <li class="treeview">
            <a href="#">
              <i class="fa fa-file-text-o"></i>
              <span>Userdata</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              @can('userdata_import')
               <li><a href="{{ route('userdata.create') }}"><i class="fa fa-circle-o"></i>Import</a></li>          
              @endcan
              <li><a href="{{ route('userdata.index') }}"><i class="fa fa-circle-o"></i>List</a></li>          
            </ul>
          </li>
        @endcan
        
        @can('admin_show')
          <li class="treeview">
            <a href="#">
              <i class="fa fa-user"></i>
              <span>Admins</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              @can('admin_create')
                <li><a href="{{ route('admins.create') }}"><i class="fa fa-circle-o"></i>Add</a></li>          
              @endcan
              <li><a href="{{ route('admins.index') }}"><i class="fa fa-circle-o"></i>List</a></li>          
            </ul>
          </li>
        @endcan

        @can('role_show')
          <li class="treeview">
            <a href="#">
              <i class="fa fa-line-chart"></i>
              <span>Roles</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              @can('role_create')
                <li><a href="{{ route('roles.create') }}"><i class="fa fa-circle-o"></i>Add</a></li>          
              @endcan
              <li><a href="{{ route('roles.index') }}"><i class="fa fa-circle-o"></i>List</a></li>          
            </ul>
          </li>
        @endcan

        @can('permission_show')
          <li class="treeview">
            <a href="#">
              <i class="fa fa-key"></i>
              <span>Permissions</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              @can('permission_create')
                <li><a href="{{ route('permissions.create') }}"><i class="fa fa-circle-o"></i>Add</a></li>          
              @endcan
              <li><a href="{{ route('permissions.index') }}"><i class="fa fa-circle-o"></i>List</a></li>          
            </ul>
          </li>
        @endcan
        
        @can('utilities_show')
          <li class="treeview">
            <a href="#">
              <i class="fa fa-align-left"></i>
              <span>Utilities</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">          
              <li><a href="{{ route('utilities.index') }}"><i class="fa fa-circle-o"></i>List</a></li>          
            </ul>
          </li>
        @endcan
        
        @can('activities_show')
          <li class="treeview">
            <a href="#">
              <i class="fa  fa-area-chart"></i>
              <span>Activities</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">          
              <li><a href="{{ route('activities.index') }}"><i class="fa fa-circle-o"></i>List</a></li>          
              <li><a href="{{ route('users.location') }}"><i class="fa fa-circle-o"></i>Location</a></li>          
            </ul>
          </li>
        @endcan

          <li class="treeview">
            <a href="#">
              <i class="fa  fa-eye"></i>
              <span>Watchlist</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">          
              <li><a href="{{ route('watchlist.list') }}"><i class="fa fa-circle-o"></i>List</a></li>                   
            </ul>
          </li>


      </ul>
    </section>
    <!-- /.sidebar -->
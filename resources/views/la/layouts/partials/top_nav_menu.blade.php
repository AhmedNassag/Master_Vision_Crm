<?php
            $module =!empty($module)?$module:null;
			$menuItems = Dwij\Laraadmin\Models\Menu::where("parent", 0)->orderBy('hierarchy', 'asc')->get();
		?>
<!-- Collect the nav links, forms, and other content for toggling -->
<div class="collapse navbar-collapse pull-right" id="navbar-collapse">

	<form class="navbar-form navbar-left" role="search" action="{{ route('admin.contacts.go') }}">
		<div class="form-group">
			<input type="text" name="searchMobile" autocomplete="off" class="form-control" id="navbar-search-input" placeholder="{{ trans('admin.Search') }}">
		</div>
	</form>

</div><!-- /.navbar-collapse -->

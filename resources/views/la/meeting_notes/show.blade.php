@extends('la.layouts.app')

@section('htmlheader_title')
	Meeting note View
@endsection


@section('main-content')
<div id="page-content" class="profile2">
	<div class="bg-primary clearfix">
		<div class="col-md-4">
			<div class="row">
				<div class="col-md-3">
					<!--<img class="profile-image" src="{{ asset('la-assets/img/avatar5.png') }}" alt="">-->
					<div class="profile-icon text-primary"><i class="fa {{ $module->fa_icon }}"></i></div>
				</div>
				<div class="col-md-9">
					<h4 class="name">{{ $meeting_note->$view_col }}</h4>
				</div>
			</div>
		</div>
		
		<div class="col-md-1 actions">
			@can("Meeting_notes-edit")
				<a href="{{ url(config('laraadmin.adminRoute') . '/meeting_notes/'.$meeting_note->id.'/edit') }}" class="btn btn-xs btn-edit btn-default"><i class="fa fa-pencil"></i></a><br>
			@endcan
			
			@can("Meeting_notes-delete")
				{{ Form::open(['route' => [config('laraadmin.adminRoute') . '.meeting_notes.destroy', $meeting_note->id], 'method' => 'delete', 'style'=>'display:inline']) }}
					<button class="btn btn-default btn-delete btn-xs" type="submit"><i class="fa fa-times"></i></button>
				{{ Form::close() }}
			@endcan
		</div>
	</div>

	<ul data-toggle="ajax-tab" class="nav nav-tabs profile" role="tablist">
		<li class=""><a href="{{ url(config('laraadmin.adminRoute') . '/meeting_notes') }}" data-toggle="tooltip" data-placement="right" title="Back to Meeting notes"><i class="fa fa-chevron-left"></i></a></li>
		<li class="active"><a role="tab" data-toggle="tab" class="active" href="#tab-general-info" data-target="#tab-info"><i class="fa fa-bars"></i> {{ trans('admin.General info') }}</a></li>
	</ul>

	<div class="tab-content">
		<div role="tabpanel" class="tab-pane active fade in" id="tab-info">
			<div class="tab-content">
				<div class="panel infolist">
					<div class="panel-default panel-heading">
						<h4>{{ trans('admin.General info') }}</h4>
					</div>
					<div class="panel-body">
						@la_display($module, 'meeting_id')
						@la_display($module, 'notes')
						@la_display($module, 'follow_date')
						@la_display($module, 'created_by')
					</div>
				</div>
			</div>
		</div>
		
	</div>
	</div>
	</div>
</div>
@endsection

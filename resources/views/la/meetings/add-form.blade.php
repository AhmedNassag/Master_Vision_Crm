{!! Form::open([
    'route' => config('laraadmin.adminRoute') . '.meetings.store',
    'id' => 'meeting-add-form',
    'files' => true,
]) !!}
   
        @if(!isset($contact))
            @la_input($meetingModule, 'contact_id')
        @else
            <input type="hidden" name="contact_id" value="{{$contact->id}}" />
        @endif
        
        @la_input($meetingModule, 'interests_ids')
        @la_input($meetingModule, 'type')
        @la_input($meetingModule, 'meeting_place')
        @la_input($meetingModule, 'meeting_date')
        @la_input($meetingModule, 'revenue')
      
        @la_input($meetingModule, 'reply_id')
        @la_input($notes_module, 'notes')
        @la_input($notes_module, 'follow_date')
   
    <br>
    <div class="form-group">
        {!! Form::submit(trans('admin.Submit'), ['class' => 'btn btn-success']) !!} <button class="btn btn-default pull-right"><a
                href="{{ url(config('laraadmin.adminRoute') . '/meetings') }}">{{ trans('admin.Cancel') }}</a></button>
    </div>
{!! Form::close() !!}

@extends('layouts.layout')
@section('title', 'Edit Announcement | UP Visayas Health Services Unit')
@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" id="editAnnouncement">
			<form method="POST" action="/announcement/update">
				{{ csrf_field() }}
        <div class="col-md-9">
          <div class="panel panel-info">
            <div class="panel-heading">Announcement</div>
              <div class="panel-body">
                <input type="hidden" value="{{$id}}" name="announcementId">
                <label for="announcement_title">Announcement title</label>
                <input type="text" class="form-control" value="{{$announcement_title}}" name="announcement_title" id="announcement_title"/><br/><br/>
                <label for="announcement_body">Announcement body</label>
                <textarea class="form-control" rows="10" value="{{$announcement_body}}" name="announcement_body" id="announcement_body">{{$announcement_body}}</textarea>
              </div>
            </div>
          </div>
          <div class="col-md-10">
            <div class="clearfix">
              <div class="pull-left">
                <button type="submit" class="btn btn-success">Save Changes</button>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection
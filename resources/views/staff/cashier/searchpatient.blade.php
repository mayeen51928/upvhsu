@extends('layouts.layout')
@section('title', 'Search Patient | UP Visayas Health Services Unit')
@section('content')
<div class="container-fluid">
	<div class="row">
		@include('layouts.sidebar')
		<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" id="cashierSearchPatient">
			<div class="col-md-4 col-md-offset-4" style="text-align: center;">
				<h4>Search Patient Record</h4>
				<input class="form-control" type="text" name="searchPatient" id="searchPatient"/>
				<table id="searchTable" class="table" style="display: none">
					<tr><th>Search Results</th></tr>
					<tbody id="searchResults" >
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@endsection
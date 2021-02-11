@extends('layouts.app')

@section('content')

<div class="col-lg-6 offset-lg-3 p-0">
	<div class="card">
		<div class="card-body">
			<form action="{{ route('menu.update', $menu->id) }}" method="POST">
				@csrf
				@method('PUT')
				<div class="form-group">
					<label>Parent Menu <span>(Optional)</span></label>
					<div>
						<select class="form-control" name="parent">
							<option value="">Select parent</option>
						@if($parent_menus)
							@foreach($parent_menus as $p_menu)
								<option value="{{ $p_menu->id }}" {{ $p_menu->id == $menu->parent_id ? 'selected' : '' }}>{{ $p_menu->title }}</option>
							@endforeach
						@endif
						</select>
					</div>
				</div>

				<div class="form-group">
					<label>Menu Title<span class="required">*</span></label>
					<div>
						<input type="text" name="title" id="ic_title" class="form-control {{ $errors->has('title') ? 'parsley-error' : '' }}" placeholder="Menu name(English)" value="{{ $menu->title ?? ''}}" required/>
					</div>
					@if($errors->has('title'))
						<ul class="parsley-errors-list filled">
							<li class="parsley-required">{{ $errors->first('title') }}</li>
						</ul>
					@endif
				</div>

				<div class="form-group" id="link-box">
					<label>Link URL</label>
					<div>
						<input type="text" name="link_url" class="form-control" placeholder="Custom link" value="{{ $menu->link_url ?? '#' }}"/>
					</div>
				</div>

				<div class="form-group mb-0">
					<div>
						<button type="submit" class="btn btn-primary waves-effect waves-light mr-1">
							Submit
						</button>

						<a href="{{ route('menu.index') }}" class="btn btn-secondary waves-effect">Cancel</a>
					
					</div>
				</div>
			</form>

		</div>
	</div>
</div> <!-- end col -->
</div> <!-- end row --> 
@endsection

@push('script')
<script>
	function editMenu() {
		console.log('menu-called');
	}
</script>
@endpush
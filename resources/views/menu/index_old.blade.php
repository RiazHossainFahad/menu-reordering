@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-lg-6 offset-lg-3 p-0">
			<div class="card">
				<div class="card-body">

					@if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

					@if($menus)
						<ol class="serialization">
							@foreach($menus as $menu)
								<li 
								class="sortable-menu-list" 
								data-id="{{ $menu->id }}" 
								data-title="{{ $menu->title }}"
								data-link_url="{{ $menu->link_url }}"
								data-status="{{ $menu->status }}"
								>
									<span>{{ $menu->title }}</span>
									{{-- <span class="sortable-menu-action">
										<a href="{{ route('menu.edit', $menu->id) }}"><i class="fa fa-edit text-info mr-2"></i></a>
										
										<a href="javascript:;" class="sa-delete" data-form-id="menu-delete-form-{{ $menu->id }}">
											<i class="fa fa-trash text-danger"></i>
										</a>
										<form 
										id="menu-delete-form-{{ $menu->id }}" 
										action="{{ route('menu.destroy', $menu->id) }}" 
										method="POST" 
										style="display: none;"
										>
											@csrf
											@method('DELETE')
										</form>
									</span> --}}
									
									
									<ol>
										@if($menu->childs && count($menu->childs))
											@foreach($menu->childs as $child)
												<li
												class="sortable-menu-list" 
												data-id="{{ $child->id }}" 
												data-title="{{ $child->title }}"
												data-link_url="{{ $child->link_url }}"
												data-status="{{ $child->status }}"
												>
													<span>{{ $child->title }}</span> 
													{{-- <span class="sortable-menu-action">
														<a href="{{ route('menu.edit', $child->id) }}"><i class="fa fa-edit text-info mr-2"></i></a>
														<a href="javascript:;" class="sa-delete" data-form-id="menu-delete-form-{{ $child->id }}">
															<i class="fa fa-trash text-danger"></i>
														</a>
														<form 
														id="menu-delete-form-{{ $child->id }}" 
														action="{{ route('menu.destroy', $child->id) }}" 
														method="POST" 
														style="display: none;"
														>
															@csrf
															@method('DELETE')
														</form>
													</span> --}}
													
												</li>
											@endforeach
										@endif
									</ol>
								</li>
							@endforeach
						</ol>
					@endif
	
					<form action="{{ route('menu.sortable') }}" method="post">
						@csrf
						<input type="hidden" id="sortable_menu" value="" name="sortable_menu">
						<div class="form-group mb-0 mt-5">
							<hr>
							<div>
								<button type="submit" class="btn btn-primary waves-effect waves-light mr-1">
									Order Menu
								</button>
								<a href="{{ route('menu.create') }}" class="btn btn-secondary text-white">Create Menu</a>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div> <!-- end col -->
	</div> <!-- end row --> 
</div>
@endsection


@push('style')
<style type="text/css">
	.serialization:hover{
		cursor: pointer;
	}
</style>
@endpush

@push('script')
{{-- Jquery sortable --}}
<script type="text/javascript" src="/sortable/jquery-sortable.js"></script>

<script>
	var group = $("ol.serialization").sortable({
		group: 'serialization',
		delay: 500,
		onDrop: function ($item, container, _super) {
			var data = group.sortable("serialize").get();

			var jsonString = JSON.stringify(data, null, ' ');

			$('#sortable_menu').val(jsonString);
		}
	});
</script>
@endpush
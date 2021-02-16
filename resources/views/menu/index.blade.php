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

					<div class="cf">
						<div class="dd" id="nestable">
							<ol class="dd-list">
								@foreach ($menus as $menu)
									@if($menu->childs && count($menu->childs))
										<li class="dd-item" data-id="{{ $menu->id }}" data-title="{{ $menu->title }}"
											data-link_url="{{ $menu->link_url }}"
											data-status="{{ $menu->status }}">
											<div class="dd-handle">{{ $menu->title }}</div>
											<span class="position-absolute action">
												<a href="javascript:void(0)" data-id="{{ $menu->id }}" class="text-info kf_menu_edit"><i class="fa fa-edit"></i></a>
												<a href="javascript:void(0)" class="sa-delete text-danger" data-form-id="{{ 'delete-form_'.$menu->id }}"><i class="fa fa-trash"></i></a>

												<form method="POST" id="{{ 'delete-form_'.$menu->id }}" action="{{ route('menu.destroy', $menu->id) }}">
													@csrf
													@method('DELETE')
												</form>
											</span>
											<ol class="dd-list">
												@foreach($menu->childs as $child)
													<li class="dd-item" data-id="{{ $child->id }}" data-title="{{ $child->title }}"
														data-link_url="{{ $child->link_url }}"
														data-status="{{ $child->status }}">
														<div class="dd-handle position-relative">
															{{ $child->title }}
														</div>
														<span class="position-absolute action">
															<a href="javascript:void(0)" data-id="{{ $child->id }}" class="text-info kf_menu_edit"><i class="fa fa-edit"></i></a>
															<a href="javascript:void(0)" class="sa-delete text-danger" data-form-id="{{ 'delete-form_'.$child->id }}"><i class="fa fa-trash"></i></a>

															<form method="POST" id="{{ 'delete-form_'.$child->id }}" action="{{ route('menu.destroy', $child->id) }}">
																@csrf
																@method('DELETE')
															</form>
														</span>
													</li>
												@endforeach
											</ol>
										</li>
									@else
										<li class="dd-item" data-id="{{ $menu->id }}" data-title="{{ $menu->title }}"
											data-link_url="{{ $menu->link_url }}"
											data-status="{{ $menu->status }}">
											<div class="dd-handle position-relative">
												{{ $menu->title }}
											</div>
											<span class="position-absolute action">
												<a href="javascript:void(0)" data-id="{{ $menu->id }}" class="text-info kf_menu_edit"><i class="fa fa-edit"></i></a>
												<a href="javascript:void(0)" class="sa-delete text-danger" data-form-id="{{ 'delete-form_'.$menu->id }}"><i class="fa fa-trash"></i></a>

												<form method="POST" id="{{ 'delete-form_'.$menu->id }}" action="{{ route('menu.destroy', $menu->id) }}">
													@csrf
													@method('DELETE')
												</form>
											</span>
										</li>
									@endif
								@endforeach
							</ol>
						</div>
					</div>

					<form action="{{ route('menu.sortable') }}" method="post">
						@csrf
						<input type="hidden" id="nestable-output" value="" name="sortable_menu">
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

	<!-- Modal -->
<div class="modal fade" id="menuEditModal" tabindex="-1" role="dialog" aria-labelledby="menuEditModalTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
	  <div class="modal-content">
		<div class="modal-header">
		  <h5 class="modal-title" id="exampleModalLongTitle">Edit Menu</h5>
		  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		  </button>
		</div>
		<div class="modal-body">
			<form action="" method="POST">
				<div class="d-none alert alert-danger">
					<ul class="kf_error">

					</ul>
				</div>
				<div class="form-group">
					<label>Parent Menu <span>(Optional)</span></label>
					<div>
						<select class="form-control" name="parent" id="kf_parent">
							{{-- <option value="">Select parent</option> --}}
						{{-- @if($parent_menus)
							@foreach($parent_menus as $p_menu)
								<option value="{{ $p_menu->id }}" {{ $p_menu->id == $menu->parent_id ? 'selected' : '' }}>{{ $p_menu->title }}</option>
							@endforeach
						@endif --}}
						</select>
					</div>
				</div>

				<div class="form-group d-none">
					<label>Menu ID<span class="required">*</span></label>
					<div>
						<input type="hidden" name="menu_id" id="kf_menu_id" class="form-control" placeholder="Menu id" required/>
					</div>
				</div>

				<div class="form-group">
					<label>Menu Title<span class="required">*</span></label>
					<div>
						<input type="text" name="title" id="kf_title" class="form-control" placeholder="Menu name" required/>
					</div>
				</div>

				<div class="form-group" id="link-box">
					<label>Link URL</label>
					<div>
						<input type="text" name="link_url" id="kf_link_url" class="form-control" placeholder="Custom link"/>
					</div>
				</div>

				<div class="form-group mb-0">
					<div>
						<button type="button" id="kf_submit" class="btn btn-primary waves-effect waves-light mr-1">
							Submit
						</button>

						<button data-dismiss="modal" aria-label="Close" class="btn btn-secondary waves-effect">
							Cancel
						</button>
					</div>
				</div>
			</form>
		</div>
	  </div>
	</div>
  </div>
</div>
@endsection


@push('style')
<style type="text/css">
	.action {
		top: 5px;
		right: 10px;
	}
	.cf:after {
		visibility: hidden;
		display: block;
		font-size: 0;
		content: " ";
		clear: both;
		height: 0;
	}

	* html .cf {
		zoom: 1;
	}

	*:first-child+html .cf {
		zoom: 1;
	}
	.dd {
		position: relative;
		display: block;
		margin: 0;
		padding: 0;
		max-width: 600px;
		list-style: none;
		font-size: 13px;
		line-height: 20px;
	}

	.dd-list {
		display: block;
		position: relative;
		margin: 0;
		padding: 0;
		list-style: none;
	}

	.dd-list .dd-list {
		padding-left: 30px;
	}

	.dd-collapsed .dd-list {
		display: none;
	}

	.dd-item,
	.dd-empty,
	.dd-placeholder {
		display: block;
		position: relative;
		margin: 0;
		padding: 0;
		min-height: 20px;
		font-size: 13px;
		line-height: 20px;
	}

	.dd-handle {
		display: block;
		height: 30px;
		margin: 5px 0;
		padding: 5px 10px;
		color: #333;
		text-decoration: none;
		font-weight: bold;
		border: 1px solid #ccc;
		background: #fafafa;
		background: -webkit-linear-gradient(top, #fafafa 0%, #eee 100%);
		background: -moz-linear-gradient(top, #fafafa 0%, #eee 100%);
		background: linear-gradient(top, #fafafa 0%, #eee 100%);
		-webkit-border-radius: 3px;
		border-radius: 3px;
		box-sizing: border-box;
		-moz-box-sizing: border-box;
	}

	.dd-handle:hover {
		color: #2ea8e5;
		background: #fff;
	}
	.dd-item>button {
		display: none;
	}
	/* .dd-item>button {
		display: block;
		position: relative;
		cursor: pointer;
		float: left;
		width: 25px;
		height: 20px;
		margin: 5px 0;
		padding: 0;
		text-indent: 100%;
		white-space: nowrap;
		overflow: hidden;
		border: 0;
		background: transparent;
		font-size: 12px;
		line-height: 1;
		text-align: center;
		font-weight: bold;
	}

	.dd-item>button:before {
		content: '+';
		display: block;
		position: absolute;
		width: 100%;
		text-align: center;
		text-indent: 0;
	}

	.dd-item>button[data-action="collapse"]:before {
		content: '-';
	} */

	.dd-placeholder,
	.dd-empty {
		margin: 5px 0;
		padding: 0;
		min-height: 30px;
		background: #f2fbff;
		border: 1px dashed #b6bcbf;
		box-sizing: border-box;
		-moz-box-sizing: border-box;
	}

	.dd-empty {
		border: 1px dashed #bbb;
		min-height: 100px;
		background-color: #e5e5e5;
		background-image: -webkit-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff),
			-webkit-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff);
		background-image: -moz-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff),
			-moz-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff);
		background-image: linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff),
			linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff);
		background-size: 60px 60px;
		background-position: 0 0, 30px 30px;
	}

	.dd-dragel {
		position: absolute;
		pointer-events: none;
		z-index: 9999;
	}

	.dd-dragel>.dd-item .dd-handle {
		margin-top: 0;
	}

	.dd-dragel .dd-handle {
		-webkit-box-shadow: 2px 4px 6px 0 rgba(0, 0, 0, .1);
		box-shadow: 2px 4px 6px 0 rgba(0, 0, 0, .1);
	}

	.dd-hover>.dd-handle {
		background: #2ea8e5 !important;
	}
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w==" crossorigin="anonymous" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.14.0/sweetalert2.min.css" integrity="sha512-A374yR9LJTApGsMhH1Mn4e9yh0ngysmlMwt/uKPpudcFwLNDgN3E9S/ZeHcWTbyhb5bVHCtvqWey9DLXB4MmZg==" crossorigin="anonymous" />
@endpush

@push('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.14.0/sweetalert2.min.js" integrity="sha512-tiZ8585M9G8gIdInZMGGXgEyFdu8JJnQbIcZYHaQxq+MP4+T8bkvA+TfF9BjPmiePjhBhev3bQ6nloOB1zF9EA==" crossorigin="anonymous"></script>
{{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script type="text/javascript">
	var jQuery_1_11_1 = $.noConflict(true);
</script> --}}
<script type="text/javascript" src="/sortable/jquery-nestable.js"></script>
<script>

	$(document).ready(function () {

		var updateOutput = function (e) {
			var list = e.length ? e : $(e.target),
				output = list.data('output');
			if (window.JSON) {
				output.val(window.JSON.stringify(list.nestable('serialize')));//, null, 2));
			} else {
				output.val('JSON browser support required for this demo.');
			}
		};
		// activate Nestable for list 1
		$('#nestable').nestable({
			group: 1
		}).on('change', updateOutput);

		// output initial serialised data
		updateOutput($('#nestable').data('output', $('#nestable-output')));

		$(document).on('click', '.sa-delete', function () {
            let form_id = $(this).data("form-id");

            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#02a499",
                cancelButtonColor: "#ec4561",
                confirmButtonText: "Yes, delete it!"
            }).then(function (result) {
                if (result.value) {
                    Swal.fire('Deleted!', '', 'success')
                    $('#' + form_id).submit();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Cancelled!',
                        showConfirmButton: false,
                        timer: 1500
                    })
                }
            });
        });
	});
</script>

<script>
	$(document).ready(function () {
		let all_parents = @json($menus);
		
		$(document).on('click', '.kf_menu_edit', function () {
			$('.kf_error').parent().addClass('d-none');

			let menu_id = $(this).data('id');

			axios.get(`/menu/${menu_id}`).then((res) => {
				let data = res.data.menu;
				$('#kf_menu_id').val(data.id);
				$('#kf_title').val(data.title);
				$('#kf_link_url').val(data.link_url);
				
				let select_option = '<option value="">Select parent</option>';

				for (let index = 0; index < all_parents.length; index++) {
					const element = all_parents[index];
					if (data.parent_id == element.id) {
						select_option += `<option value="${element.id}" selected>${element.title}</option>`;
					} else {
						select_option += `<option value="${element.id}">${element.title}</option>`;
					}
				}

				$('#kf_parent').html(select_option);

				$("#menuEditModal").modal('show');
			})
		})
		
		$(document).on('click', '#kf_submit', function () {
			let menu_id = $('#kf_menu_id').val();
			let data = {
				'parent': $('#kf_parent').val(),			
				'title': $('#kf_title').val(),			
				'link_url': $('#kf_link_url').val(),			
			};

			axios.put(`/menu/${menu_id}`, data).then((res) => {
				Swal.fire({
					title: "Updated?",
					text: "Manu updated successfully!",
					type: "warning",
					showCancelButton: false,
					confirmButtonColor: "#02a499",
					confirmButtonText: "Ok!"
				}).then(function (result) {
					window.location.reload();
				});
			}).catch((err)=>{
				let li = '';
				let errors = err.response.data.errors;
				for (const key in errors) {
					if (Object.hasOwnProperty.call(errors, key)) {
						const element = errors[key];
						li += `<li>${element[0]}</li>`;
					}
				}
				$('.kf_error').parent().removeClass('d-none').html(li);
			});
		});
	});
</script>
@endpush
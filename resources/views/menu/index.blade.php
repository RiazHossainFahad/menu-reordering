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
											<div class="dd-handle">{{ $menu->title }}
												<span class="float-right">
													<a href="#" class="text-info"><i class="fa fa-edit"></i></a>
													<a href="#" class="text-danger"><i class="fa fa-trash"></i></a>
												</span>
											</div>
											<ol class="dd-list">
												@foreach($menu->childs as $child)
													<li class="dd-item" data-id="{{ $child->id }}" data-title="{{ $child->title }}"
														data-link_url="{{ $child->link_url }}"
														data-status="{{ $child->status }}">
														<div class="dd-handle">
															{{ $child->title }}
															<span class="float-right">
																<a href="#" class="text-info"><i class="fa fa-edit"></i></a>
																<a href="#" class="text-danger"><i class="fa fa-trash"></i></a>
															</span>
														</div>
													</li>
												@endforeach
											</ol>
										</li>
									@else
										<li class="dd-item" data-id="{{ $menu->id }}" data-title="{{ $menu->title }}"
											data-link_url="{{ $menu->link_url }}"
											data-status="{{ $menu->status }}">
											<div class="dd-handle">
												{{ $menu->title }}
												<span class="float-right">
													<a href="#" class="text-info"><i class="fa fa-edit"></i></a>
													<a href="#" class="text-danger"><i class="fa fa-trash"></i></a>
												</span>
											</div>
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
</div>
@endsection


@push('style')
<style type="text/css">
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
	}

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
@endpush

@push('script')
{{-- Jquery sortable --}}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script type="text/javascript">
	var jQuery_1_11_1 = $.noConflict(true);
</script>
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
	}(jQuery_1_11_1));
</script>
@endpush
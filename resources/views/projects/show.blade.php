@extends('layouts.app')

@push('datatable-styles')
	@include('sections.datatable_css')
@endpush

@php
$viewProjectMemberPermission = user()->permission('view_project_members');
$viewProjectMilestonePermission = ($project->project_admin == user()->id) ? 'all' : user()->permission('view_project_milestones');
$viewTasksPermission = ($project->project_admin == user()->id) ? 'all' : user()->permission('view_project_tasks');
$viewGanttPermission = ($project->project_admin == user()->id) ? 'all' : user()->permission('view_project_gantt_chart');
$viewInvoicePermission = user()->permission('view_project_invoices');
$viewDiscussionPermission = user()->permission('view_project_discussions');
$viewNotePermission = user()->permission('view_project_note');
$viewFilesPermission = user()->permission('view_project_files');
$viewRatingPermission = user()->permission('view_project_rating');
$viewOrderPermission = user()->permission('view_project_orders');

$projectArchived = $project->trashed();
@endphp


@section('filter-section')
	<!-- FILTER START -->
	<!-- PROJECT HEADER START -->

	<div class="d-flex d-lg-block filter-box project-header bg-white">
		<div class="mobile-close-overlay w-100 h-100" id="close-client-overlay"></div>

		<div class="project-menu" id="mob-client-detail">
			<a class="d-none close-it" href="javascript:;" id="close-client-detail">
				<i class="fa fa-times"></i>
			</a>

			<nav class="tabs">
				<ul class="-primary">
					<li>
						<x-tab :href="route('projects.show', $project->id)" :text="__('modules.projects.overview')" class="overview" />
					</li>

					@if (
						!$project->public && $viewProjectMemberPermission == 'all'
					)
						<li>
							<x-tab :href="route('projects.show', $project->id).'?tab=members'" :text="__('modules.projects.members')"
							class="members" />
						</li>
					@endif

					@if ($viewFilesPermission == 'all' || ($viewFilesPermission == 'added' && user()->id == $project->added_by) || ($viewFilesPermission == 'owned' && user()->id == $project->client_id))
						<li>
							<x-tab :href="route('projects.show', $project->id).'?tab=files'" :text="__('modules.projects.files')"
							class="files" />
						</li>
					@endif

					@if ($viewProjectMilestonePermission == 'all' || $viewProjectMilestonePermission == 'added' || ($viewProjectMilestonePermission == 'owned' && user()->id == $project->client_id))
						<li>
							<x-tab :href="route('projects.show', $project->id).'?tab=milestones'"
							:text="__('modules.projects.milestones')" class="milestones" />
						</li>
					@endif

					@if (in_array('tasks', user_modules()) && ($viewTasksPermission == 'all' || ($viewTasksPermission == 'added' && user()->id == $project->added_by) || ($viewTasksPermission == 'owned' && user()->id == $project->client_id)))
						<li>
							<x-tab :href="route('projects.show', $project->id).'?tab=tasks'" :text="__('app.menu.tasks')" class="tasks"
							ajax="false" />
						</li>

						@if (!$projectArchived)
							<li>
								<x-tab :href="route('projects.show', $project->id).'?tab=taskboard'" :text="__('modules.tasks.taskBoard')" class="taskboard" ajax="false" />
							</li>

							@if ($viewGanttPermission == 'all' || ($viewGanttPermission == 'added' && user()->id == $project->added_by) || ($viewGanttPermission == 'owned' && user()->id == $project->client_id))
								<li>
									<x-tab :href="route('projects.show', $project->id).'?tab=gantt'" ajax="false" :text="__('modules.projects.viewGanttChart')" class="gantt" />
								</li>
							@endif
						@endif
					@endif

					@if (in_array('invoices', user_modules()) && !is_null($project->client_id) && ($viewInvoicePermission == 'all' || ($viewInvoicePermission == 'added' && user()->id == $project->added_by) || ($viewInvoicePermission == 'owned' && user()->id == $project->client_id)))
						<li>
							<x-tab :href="route('projects.show', $project->id).'?tab=invoices'" :text="__('app.menu.invoices')" class="invoices" ajax="false" />
						</li>
					@endif

					@if (in_array('orders', user_modules()) && !is_null($project->client_id) && ($viewOrderPermission == 'all' || ($viewOrderPermission == 'added' && user()->id == $project->added_by) || ($viewOrderPermission == 'owned' && user()->id == $project->client_id)))
						<li>
							<x-tab :href="route('projects.show', $project->id).'?tab=orders'" :text="__('app.menu.orders')" class="orders" ajax="false" />
						</li>
					@endif

					@if (in_array('timelogs', user_modules()) && ($viewProjectTimelogPermission == 'all' || ($viewProjectTimelogPermission == 'added' && user()->id == $project->added_by) || ($viewProjectTimelogPermission == 'owned' && user()->id == $project->client_id)))
						<li>
							<x-tab :href="route('projects.show', $project->id).'?tab=timelogs'" :text="__('app.menu.timeLogs')" class="timelogs" ajax="false" />
						</li>
					@endif

					@if (in_array('expenses', user_modules()) && ($viewExpensePermission == 'all' || ($viewExpensePermission == 'added' && user()->id == $project->added_by) || ($viewExpensePermission == 'owned' && user()->id == $project->client_id)))
						<li>
							<x-tab :href="route('projects.show', $project->id).'?tab=expenses'" :text="__('app.menu.expenses')" class="expenses" ajax="false" />
						</li>
					@endif

					@if ($viewMiroboardPermission == 'all' && $project->enable_miroboard &&
					((in_array('client', user_roles()) && $project->client_access && $project->client_id == user()->id)
					|| !in_array('client', user_roles()))
					)
						<li>
							<x-tab :href="route('projects.show', $project->id).'?tab=miroboard'" :text="__('app.menu.miroboard')" class="miroboard" ajax="false" />
						</li>
					@endif

					@if (in_array('payments', user_modules()) && !is_null($project->client_id) && ($viewPaymentPermission == 'all' || ($viewPaymentPermission == 'added' && user()->id == $project->added_by) || ($viewPaymentPermission == 'owned' && user()->id == $project->client_id)))
						<li>
							<x-tab :href="route('projects.show', $project->id).'?tab=payments'" :text="__('app.menu.payments')" class="payments" ajax="false" />
						</li>
					@endif

					@if ($viewDiscussionPermission == 'all' || ($viewDiscussionPermission == 'added' && user()->id == $project->added_by) || ($viewDiscussionPermission == 'owned' && user()->id == $project->client_id))
						<li>
							<x-tab :href="route('projects.show', $project->id).'?tab=discussion'" :text="__('modules.projects.discussion')" class="discussion" ajax="false" />
						</li>
					@endif

					@if ($viewNotePermission != 'none' )
						<li>
							<x-tab :href="route('projects.show', $project->id).'?tab=notes'" :text="__('modules.projects.note')" class="notes" ajax="false" />
						</li>
					@endif

					@if ($viewRatingPermission != 'none' && !is_null($project->client_id))
						<li>
							<x-tab :href="route('projects.show', $project->id).'?tab=rating'" :text="__('modules.projects.rating')" class="rating" ajax="false" />
						</li>
					@endif

					@if($viewBurndownChartPermission != 'none' || $project->project_admin == user()->id)
						<li>
							<x-tab :href="route('projects.show', $project->id).'?tab=burndown-chart'"
								:text="__('modules.projects.burndownChart')" class="burndown-chart" ajax="false" />
						</li>
					@endif

					@if (!in_array('client', user_roles()))
						<li>
							<x-tab :href="route('projects.show', $project->id).'?tab=activity'"
								:text="__('modules.employees.activity')" class="activity" />
						</li>
					@endif

					@if ($viewNotePermission != 'none' )
						<li>
							<x-tab :href="route('projects.show', $project->id).'?tab=tickets'" :text="__('app.menu.tickets')" class="tickets" ajax="false" />
						</li>
					@endif
				</ul>
			</nav>
		</div>

		<a class="mb-0 d-block d-lg-none text-dark-grey ml-auto mr-2 border-left-grey" onclick="openClientDetailSidebar()"><i class="fa fa-ellipsis-v "></i></a>
	</div>



	<!-- PROJECT HEADER END -->

@endsection

@section('content')

	<div class="content-wrapper pt-0 border-top-0 client-detail-wrapper">
		@include($view)
	</div>

@endsection

@push('scripts')
	@if($activeTab == 'timelogs')
        @include('sections.datatable_js')

		<script>
			var deadLineStartDate = '';
			var deadLineEndDate = '';

			$(document).on('show.bs.dropdown', '.table-responsive', function() {
				$('.table-responsive').css( "overflow", "inherit" );
			});

			$('#timelogs-table').on('preXhr.dt', function(e, settings, data) {
				const dateRangePicker = $('#datatableRange').data('daterangepicker');

				let startDate = $('#datatableRange').val();
				let endDate;

				if (startDate === '') {
					startDate = null;
					endDate = null;
				} else {
					startDate = dateRangePicker.startDate.format('DD-MM-YYYY');
					endDate = dateRangePicker.endDate.format('DD-MM-YYYY');
				}

				var projectID = "{{ $project->id }}";
				var approved = $('#status').val();
				var invoice = $('#invoice_generate').val();
				var employee = $('#employee').val();
				var searchText = $('#search-text-field').val();

				data['projectId'] = projectID;
				data['approved'] = approved;
				data['invoice'] = invoice;
				data['employee'] = employee;
				data['searchText'] = searchText;
				data['startDate'] = startDate;
				data['endDate'] = endDate;

				data['searchText'] = searchText;
				data['project_admin'] = "{{ ($project->project_admin == user()->id) ? 1 : 0 }}";
			});
			const showTable = () => {
				window.LaravelDataTables["timelogs-table"].draw(true);
			}

			$('#project_id, #employee, #status, #invoice_generate').on('change keyup', function() {
				if ($('#status').val() != "all") {
					$('#reset-filters').removeClass('d-none');
					showTable();
				}  else if ($('#employee').val() != "all") {
					$('#reset-filters').removeClass('d-none');
					showTable();
				} else if ($('#invoice_generate').val() != "all") {
					$('#reset-filters').removeClass('d-none');
					showTable();
				} else {
					$('#reset-filters').addClass('d-none');
					showTable();
				}
			});

			$('#search-text-field').on('keyup', function() {
				if ($('#search-text-field').val() != "") {
					$('#reset-filters').removeClass('d-none');
					showTable();
				}
			});

			$( document ).ready(function() {
				@if (!is_null(request('start')) && !is_null(request('end')))
				$('#datatableRange').val('{{ request('start') }}' +
				' @lang("app.to") ' + '{{ request('end') }}');
				$('#datatableRange').data('daterangepicker').setStartDate("{{ request('start') }}");
				$('#datatableRange').data('daterangepicker').setEndDate("{{ request('end') }}");
					showTable();
				@endif
			});

			$('#reset-filters,#reset-filters-2').click(function() {
				$('#filter-form')[0].reset();

				$('#filter-form .select-picker').selectpicker("refresh");
				$('#reset-filters').addClass('d-none');
				showTable();
			});

			$('#quick-action-type').change(function() {
				const actionValue = $(this).val();
				if (actionValue != '') {
					$('#quick-action-apply').removeAttr('disabled');

					if (actionValue == 'change-status') {
						$('.quick-action-field').addClass('d-none');
						$('#change-status-action').removeClass('d-none');
					} else {
						$('.quick-action-field').addClass('d-none');
					}
				} else {
					$('#quick-action-apply').attr('disabled', true);
					$('.quick-action-field').addClass('d-none');
				}
			});

			$('#quick-action-apply').click(function() {
				const actionValue = $('#quick-action-type').val();
				if (actionValue == 'delete') {
					Swal.fire({
						title: "@lang('messages.sweetAlertTitle')",
						text: "@lang('messages.recoverRecord')",
						icon: 'warning',
						showCancelButton: true,
						focusConfirm: false,
						confirmButtonText: "@lang('messages.confirmDelete')",
						cancelButtonText: "@lang('app.cancel')",
						customClass: {
							confirmButton: 'btn btn-primary mr-3',
							cancelButton: 'btn btn-secondary'
						},
						showClass: {
							popup: 'swal2-noanimation',
							backdrop: 'swal2-noanimation'
						},
						buttonsStyling: false
					}).then((result) => {
						if (result.isConfirmed) {
							applyQuickAction();
						}
					});

				} else {
					applyQuickAction();
				}
			});

			$('body').on('click', '.delete-table-row', function() {
				var id = $(this).data('time-id');
				Swal.fire({
					title: "@lang('messages.sweetAlertTitle')",
					text: "@lang('messages.recoverRecord')",
					icon: 'warning',
					showCancelButton: true,
					focusConfirm: false,
					confirmButtonText: "@lang('messages.confirmDelete')",
					cancelButtonText: "@lang('app.cancel')",
					customClass: {
						confirmButton: 'btn btn-primary mr-3',
						cancelButton: 'btn btn-secondary'
					},
					showClass: {
						popup: 'swal2-noanimation',
						backdrop: 'swal2-noanimation'
					},
					buttonsStyling: false
				}).then((result) => {
					if (result.isConfirmed) {
						var url = "{{ route('timelogs.destroy', ':id') }}";
						url = url.replace(':id', id);

						var token = "{{ csrf_token() }}";

						$.easyAjax({
							type: 'POST',
							url: url,
							blockUI: true,
							data: {
								'_token': token,
								'_method': 'DELETE'
							},
							success: function(response) {
								if (response.status == "success") {
									showTable();
								}
							}
						});
					}
				});
			});

			$('body').on('click', '.stop-active-timer', function() {
				var id = $(this).data('time-id');
				var url = "{{ route('timelogs.stop_timer', ':id') }}";
				url = url.replace(':id', id);
				var token = '{{ csrf_token() }}';
				$.easyAjax({
					url: url,
					type: "POST",
					data: {
						timeId: id,
						_token: token
					},
					success: function(data) {
						showTable();
					}
				})
			});

			$('body').on('click', '.approve-timelog', function() {
				var id = $(this).data('time-id');
				var url = "{{ route('timelogs.approve_timelog', ':id') }}";
				url = url.replace(':id', id);
				var token = '{{ csrf_token() }}';
				$.easyAjax({
					url: url,
					type: "POST",
					data: {
						id: id,
						_token: token
					},
					success: function(data) {
						showTable();
					}
				})
			});

			const applyQuickAction = () => {
				var rowdIds = $("#timelogs-table input:checkbox:checked").map(function() {
					return $(this).val();
				}).get();

				var url = "{{ route('timelogs.apply_quick_action') }}?row_ids=" + rowdIds;

				$.easyAjax({
					url: url,
					container: '#quick-action-form',
					type: "POST",
					disableButton: true,
					buttonSelector: "#quick-action-apply",
					data: $('#quick-action-form').serialize(),
					blockUI: true,
					success: function(response) {
						if (response.status == 'success') {
							showTable();
							resetActionButtons();
							deSelectAll();
						}
					}
				})
			};
		</script>

    @endif

	<script>
		$("body").on("click", ".project-menu .ajax-tab", function(event) {
			event.preventDefault();

			$('.project-menu .p-sub-menu').removeClass('active');
			$(this).addClass('active');

			const requestUrl = this.href;

			$.easyAjax({
				url: requestUrl,
				blockUI: true,
				container: ".content-wrapper",
				historyPush: true,
				success: function(response) {
					if (response.status == "success") {
						$('.content-wrapper').html(response.html);
						init('.content-wrapper');
					}
				}
			});
		});

	</script>
	<script>
		const activeTab = "{{ $activeTab }}";
		$('.project-menu .' + activeTab).addClass('active');

	</script>
	<script>
		/*******************************************************
				 More btn in projects menu Start
		*******************************************************/

		const container = document.querySelector('.tabs');
		const primary = container.querySelector('.-primary');
		const primaryItems = container.querySelectorAll('.-primary > li:not(.-more)');
		container.classList.add('--jsfied'); // insert "more" button and duplicate the list

		primary.insertAdjacentHTML('beforeend', `
		<li class="-more">
			<button type="button" class="px-4 h-100 bg-grey d-none d-lg-flex align-items-center" aria-haspopup="true" aria-expanded="false">
			{{__('app.more')}} <span>&darr;</span>
			</button>
			<ul class="-secondary" id="hide-project-menues">
			${primary.innerHTML}
			</ul>
		</li>
		`);
		const secondary = container.querySelector('.-secondary');
		const secondaryItems = secondary.querySelectorAll('li');
		const allItems = container.querySelectorAll('li');
		const moreLi = primary.querySelector('.-more');
		const moreBtn = moreLi.querySelector('button');
		moreBtn.addEventListener('click', e => {
			e.preventDefault();
			container.classList.toggle('--show-secondary');
			moreBtn.setAttribute('aria-expanded', container.classList.contains('--show-secondary'));
		}); // adapt tabs

		const doAdapt = () => {
			// reveal all items for the calculation
			allItems.forEach(item => {
				item.classList.remove('--hidden');
			}); // hide items that won't fit in the Primary

			let stopWidth = moreBtn.offsetWidth;
			let hiddenItems = [];
			const primaryWidth = primary.offsetWidth;
			primaryItems.forEach((item, i) => {
				if (primaryWidth >= stopWidth + item.offsetWidth) {
					stopWidth += item.offsetWidth;
				} else {
					item.classList.add('--hidden');
					hiddenItems.push(i);
				}
			}); // toggle the visibility of More button and items in Secondary

			if (!hiddenItems.length) {
				moreLi.classList.add('--hidden');
				container.classList.remove('--show-secondary');
				moreBtn.setAttribute('aria-expanded', false);
			} else {
				secondaryItems.forEach((item, i) => {
					if (!hiddenItems.includes(i)) {
						item.classList.add('--hidden');
					}
				});
			}
		};

		doAdapt(); // adapt immediately on load

		window.addEventListener('resize', doAdapt); // adapt on window resize
		// hide Secondary on the outside click

		document.addEventListener('click', e => {
			let el = e.target;

			while (el) {
				if (el === secondary || el === moreBtn) {
					return;
				}

				el = el.parentNode;
			}

			container.classList.remove('--show-secondary');
			moreBtn.setAttribute('aria-expanded', false);
		});
		/*******************************************************
				 More btn in projects menu End
		*******************************************************/
	</script>
@endpush
@php
	$addTimelogPermission = user()->permission('add_timelogs');
@endphp

<!-- ROW START -->
<div class="row py-3 py-lg-5 py-md-5">
	<div class="col-lg-12 col-md-12 mb-4 mb-xl-0 mb-lg-4">
		<!-- Add Task Export Buttons Start -->
		<div class="d-flex" id="table-actions">
			@if (($addTimelogPermission == 'all' || $addTimelogPermission == 'added') && !$project->trashed())
				<x-forms.link-primary :link="route('timelogs.create').'?default_project='.$project->id"
					class="mr-3 openRightModal float-left" icon="plus">
					@lang('modules.timeLogs.logTime')
				</x-forms.link-primary>
			@endif
		</div>

		<div class="d-flex justify-content-between">

            <form action="" class="flex-grow-1 " id="filter-form">
                <div class="d-block d-lg-flex d-md-flex my-3">
                    <!-- Employees START -->
                    <div class="select-box py-2 px-0 mr-3">
                        <x-forms.label :fieldLabel="__('app.employee')" fieldId="employee" />
                            <select class="form-control select-picker" name="employee" id="employee" data-live-search="true"
                                    data-size="8">
                                @if ($employees->count() > 1 || in_array('admin', user_roles()))
                                    <option value="all">@lang('app.all')</option>
                                @endif
                                <!-- @foreach ($employees as $employee)
                                        <x-user-option :user="$employee" :selected="request('assignee') == 'me' && $employee->id == user()->id"/>
                                @endforeach -->
                                
                                @forelse($project->members as $key => $member)
                                    <x-user-option 
                                        :user="$member->user" 
                                        :selected="request('assignee') == 'me' && $member->id == user()->id" 
                                    />
                                @endforeach

                            </select>
                    </div>
                    <!-- Employees END -->

					<!-- STATUS START -->
					<div class="select-box py-2 px-0 mr-3">
						<x-forms.label :fieldLabel="__('app.status')" fieldId="status" />
						<select class="form-control select-picker" name="status" id="status" data-live-search="true"
							data-size="8">
							<option value="all">@lang('app.all')</option>
							<option value="1">@lang('app.approved')</option>
							<option value="0">@lang('app.pending')</option>
							<option value="2">@lang('app.active')</option>
						</select>
					</div>
					<!-- STATUS END -->
					<!-- STATUS START -->
					<div class="select-box py-2 px-0 mr-3">
						<x-forms.label :fieldLabel="__('app.invoiceGenerate')" fieldId="leave_type" />
						<select class="form-control select-picker" name="invoice_generate" id="invoice_generate"
							data-live-search="true" data-size="8">
							<option value="all">@lang('app.all')</option>
							<option value="1">@lang('app.yes')</option>
							<option value="0">@lang('app.no')</option>
						</select>
					</div>
					<!-- STATUS END -->

					<!-- SEARCH BY TASK START -->
					<div class="select-box py-2 px-lg-2 px-md-2 px-0 mr-3">
						<x-forms.label fieldId="status" class="d-none d-lg-block d-md-block" />
						<div class="input-group bg-grey rounded">
							<div class="input-group-prepend">
								<span class="input-group-text bg-additional-grey">
									<i class="fa fa-search f-13 text-dark-grey"></i>
								</span>
							</div>
							<input type="text" class="form-control f-14 p-1 height-35 border" id="search-text-field" placeholder="@lang('app.startTyping')">
						</div>
					</div>
					<!-- SEARCH BY TASK END -->

					<!-- SEARCH BY DATE -->
					<div class="select-box py-2 px-lg-2 px-md-2 px-0 mr-3">
						<x-forms.label fieldId="datepicker2" class="d-none d-lg-block d-md-block" />
						<div class="input-group bg-grey rounded">
							<div class="input-group-prepend">
								<span class="input-group-text bg-additional-grey">
									<i class="fa fa-calendar f-13 text-dark-grey"></i>
								</span>
							</div>
							<input type="text" class="form-control f-14 p-1 height-35 border" id="datatableRange" placeholder="@lang('placeholders.dateRange')" style="width: 1%;">
						</div>
					</div>
					<!-- SEARCH BY TASK END -->

					<!-- RESET START -->
					<div class="select-box d-flex py-2 px-lg-2 px-md-2 px-0 mt-4">
						<x-forms.button-secondary class="btn-xs d-none height-35 mt-2" id="reset-filters" icon="times-circle">
							@lang('app.clearFilters')
						</x-forms.button-secondary>
					</div>
					<!-- RESET END -->
				</div>
			</form>

			<x-datatable.actions class="mt-5">
				<div class="select-status mr-3 pl-3">
					<select name="action_type" class="form-control select-picker" id="quick-action-type" disabled>
						<option value="">@lang('app.selectAction')</option>
						<option value="change-status">@lang('modules.tasks.changeStatus')</option>
						<option value="delete">@lang('app.delete')</option>
					</select>
				</div>
				<div class="select-status mr-3 d-none quick-action-field" id="change-status-action">
					<select name="status" class="form-control select-picker">
						<option value="0">@lang('app.pending')</option>
						<option value="1">@lang('app.approve')</option>
					</select>
				</div>
			</x-datatable.actions>

		</div>

		<!-- Task Box Start -->
		<div class="d-flex flex-column w-tables rounded mt-3 bg-white">

			{!! $dataTable->table(['class' => 'table table-hover border-0 w-100']) !!}

		</div>
		<!-- Task Box End -->
	</div>
</div>
<div class="row">
    <div class="col-sm-12">
        <x-form id="save-timelog-data-form">

            <div class="add-client bg-white rounded">
                <h4 class="mb-0 p-20 f-21 font-weight-normal  border-bottom-grey">
                    @lang('app.timeLogDetails')</h4>
                <div class="row p-20">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6 col-lg-4">
                                <x-forms.select fieldId="project_id2" fieldName="project_id"
                                    :fieldLabel="__('app.project')" search="true">
                                    <option value="">--</option>
                                    @foreach ($projects as $project)
                                        <option {{ request()->default_project == $project->id ? 'selected' : '' }}
                                            value="{{ $project->id }}">
                                            {{ $project->project_name }}
                                        </option>
                                    @endforeach
                                </x-forms.select>
                            </div>

                            <div class="col-md-6 col-lg-4">
                                <x-forms.select fieldId="task_id2" fieldName="task_id" :fieldLabel="__('app.task')"
                                    fieldRequired="true" search="true">
                                    <option value="">--</option>
                                    @foreach ($tasks as $field)
                                        <option value="{{ $field->id }}">
                                            {{ $field->heading }}
                                        </option>
                                    @endforeach
                                </x-forms.select>
                            </div>

                            @if ($addTimelogPermission == 'all')
                                <div class="col-md-6 col-lg-4">
                                    <x-forms.label class="mt-3" fieldId="user_id2"
                                        :fieldLabel="__('app.employee')" fieldRequired="true">
                                    </x-forms.label>
                                    <x-forms.input-group>
                                        <select class="form-control select-picker" name="user_id" id="user_id2"
                                            data-live-search="true" data-size="8">
                                            <option value="">--</option>
                                        </select>
                                    </x-forms.input-group>
                                </div>
                            @else
                                <input type="hidden" name="user_id" value="{{ user()->id }}">
                                <div class="col-md-6 col-lg-4">
                                    <x-forms.label class="mt-3" fieldId="user_id2" fieldLabel="&nbsp;" />
                                    <x-employee :user="user()" />
                                </div>
                            @endif

                        </div>

                        <div class="row">
                            <div class="col-md-3 col-lg-3">
                                <x-forms.datepicker fieldId="start_date" fieldRequired="true"
                                    :fieldLabel="__('modules.timeLogs.startDate')" fieldName="start_date"
                                    :fieldValue="now(company()->timezone)->format(company()->date_format)"
                                    :fieldPlaceholder="__('placeholders.date')" />
                            </div>

                            <div class="col-md-3 col-lg-3">
                                <x-forms.text :fieldLabel="__('modules.timeLogs.totalHours')"
                                    :fieldPlaceholder="__('placeholders.total_hours')" fieldName="total_hours"
                                    fieldId="total_hours" fieldRequired="true" />
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <x-forms.textarea :fieldLabel="__('modules.timeLogs.memo')" fieldName="memo" fieldRequired="true"
                            fieldId="memo" :fieldPlaceholder="__('placeholders.timelog.memo')" />
                    </div>

                    <!-- <div class="col-md-6">
                        <x-forms.label fieldId="total_time" class="my-3"
                            :fieldLabel="__('modules.timeLogs.totalHours')" />
                        <p id="total_time" class="f-w-500 text-primary f-21">0 @lang('app.hrs')</p>
                    </div> -->
                </div>
                <x-forms.custom-field :fields="$fields"></x-forms.custom-field>

                <x-form-actions>
                    <x-forms.button-primary id="save-timelog-form" class="mr-3" icon="check">@lang('app.save')
                    </x-forms.button-primary>
                    <x-forms.button-cancel :link="route('timelogs.index')" class="border-0">@lang('app.cancel')
                    </x-forms.button-cancel>
                </x-form-actions>
            </div>
        </x-form>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Initialize datepickers
        const dp1 = datepicker('#start_date', {
            position: 'bl',
            ...datepickerConfig
        });

        // Form submission handler
        $('#save-timelog-form').on('click', function(e) {
            e.preventDefault();
            
            // Validate required fields
            if ($('#project_id2').val() === '' || 
                $('#task_id2').val() === '' || 
                $('#total_hours').val() === '' || 
                $('#memo').val() === '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Please fill all required fields',
                    customClass: {
                        confirmButton: 'btn btn-primary',
                    },
                    buttonsStyling: false
                });
                return false;
            }

            // Submit form via AJAX
            $.easyAjax({
                url: "{{ route('timelogs.store') }}",
                container: '#save-timelog-data-form',
                type: "POST",
                disableButton: true,
                blockUI: true,
                buttonSelector: "#save-timelog-form",
                data: $('#save-timelog-data-form').serialize(),
                success: function(response) {
                    if (response.status == 'success') {
                        if ($(RIGHT_MODAL).hasClass('in')) {
                            document.getElementById('close-task-detail').click();
                            if (typeof window.LaravelDataTables["timelogs-table"] !== 'undefined') {
                                window.LaravelDataTables["timelogs-table"].draw(true);
                            }
                        } else {
                            window.location.href = response.redirectUrl;
                        }
                    }
                },
                error: function(xhr) {
                    console.error('Error:', xhr.responseText);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred while saving',
                        customClass: {
                            confirmButton: 'btn btn-primary',
                        },
                        buttonsStyling: false
                    });
                }
            });
        });

        // Project change handler
        $('#project_id2').change(function() {
            var id = $(this).val() || 0;
            var url = "{{ route('tasks.project_tasks', ':id').'?for_timelogs=true' }}";
            
            $.easyAjax({
                url: url.replace(':id', id),
                type: "GET",
                container: '#save-timelog-data-form',
                blockUI: true,
                success: function(data) {
                    $('#task_id2').html(data.data);
                    $('#task_id2').selectpicker('refresh');
                }
            });
        });

        // Task change handler
        $('#task_id2').change(function() {
            var id = $(this).val() || 0;
            var url = "{{ route('tasks.members', ':id') }}";
            
            $.easyAjax({
                url: url.replace(':id', id),
                type: "GET",
                container: '#save-timelog-data-form',
                blockUI: true,
                success: function(data) {
                    $('#user_id2').html(data.data);
                    $('#user_id2').selectpicker('refresh');
                }
            });
        });

        init(RIGHT_MODAL);
    });
</script>
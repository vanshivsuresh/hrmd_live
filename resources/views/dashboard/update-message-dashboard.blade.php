@if (global_setting()->system_update == 1 &&  (in_array('admin', user_roles())|| user()->is_superadmin))
   
    @if (isset($updateVersionInfo['lastVersion']))
        <div class="col-md-12">
            <x-alert type="info">
                <div class="d-flex justify-content-between align-items-center">
                   
                    <div>
                       
                    </div>

                </div>
            </x-alert>
        </div>
    @endif

@endif

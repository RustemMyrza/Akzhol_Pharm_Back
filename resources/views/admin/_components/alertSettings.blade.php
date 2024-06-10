@if(session('success_command') || session('error_command'))
    @if(session('success_command'))
        <div class="alert alert-secondary alert-dismissible border-0">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <p class="m-0">
                <pre>
                     {{ session('success_command') }}
                </pre>
            </p>
        </div>
    @endif
    @if(session('error_command'))
        <div class="alert alert-danger alert-dismissible border-0">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <p class="m-0">
                <pre>
                     {{ session('error_command') }}
                </pre>
            </p>
        </div>
    @endif
@endif

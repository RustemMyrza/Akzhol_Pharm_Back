<div class="col-12">
    @if($errors->any() || session('success') || session('error'))
        @if(session('success'))
            <div class="alert alert-success alert-dismissible border-0">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <p class="m-0"><i class="icon fas fa-check"></i> {{ session('success') }}</p>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible border-0">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <p class="m-0"><i class="icon fas fa-ban"></i>{{ session('error') }}</p>
            </div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible border-0">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <p class="m-0"><i class="icon fas fa-ban"></i>Произошла ошибка!</p>
                <ul style="margin: 0">
                    @foreach($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    @endif

    @if(session('success_import'))
        <div class="alert alert-success alert-dismissible border-0">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <p class="m-0">
                <i class="icon fas fa-check"></i>
                {{ session('success_import') }} <br> <br>
                Все: {{ session('lineCount') ?? 0 }} <br>
                Загружено: {{ session('creatingCount') ?? 0 }} <br>
                Обновлено: {{ session('updatingCount') ?? 0 }} <br>
                Не загужено:  {{ session('errorsCount') ?? 0 }} <br>
                {{ session('errorLine') ?? '' }}
            </p>
        </div>
    @endif

    @include('notify::components.notify')
</div>


<div class="col-12 col-sm-6 col-md-6 col-lg-3">
    <div class="small-box bg-white" @if(isset($link)) style="cursor: pointer"  onclick="location.href = '{{ $link }}'" @endif>
        <div class="inner">
            <p  class="m-0">{{ $text ?? ''}}</p>
            <h3 class="m-0">{{ $count ?? 0 }}</h3>
        </div>
    </div>
</div>

<div
    class="Masthead {{ $isclasses }}"
    style="
        background-image: linear-gradient(
            rgba(0, 0, 0, 0.5),
            rgba(0, 0, 0, 0.5)
        ),
    url({{ $image }});"
>    
    <div class="container">
    
        <div class="Masthead__header">

            <div class="Masthead__search">

                {!! $search !!}

            </div>

            <div class="Masthead__smalllogo">

                {!! $smalllogo !!}

            </div>

            <div class="Masthead__navbar">

                {!! $navbar !!}

            </div>

        </div>

        <div class="Masthead__wrapper">

            <div class="Masthead__content">
            
            <div class="Masthead__logo">

            {!! $logo !!}

            </div>

            <div class="Masthead__title">

            {!! $title !!}

            </div>

            </div>

        </div>

    </div>

</div>
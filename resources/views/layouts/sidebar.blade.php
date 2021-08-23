
<div class="sidebar" data-color="azure" data-image="../assets/img/full-screen-image-3.jpg">
    <!--

        Tip 1: you can change the color of the sidebar using: data-color="blue | azure | green | orange | red | purple"
        Tip 2: you can also add an image using data-image tag

    -->

    <div class="logo">
        {{-- <a href="/" class="simple-text logo-mini">
            
        </a> --}}

        <a href="/" class="simple-text logo-normal">
            <img id='bkacad' style='width: 125px; width: 163px;margin-left: 47px;'
             src="../assets/img/logo_1591255072.png">
        </a>
    </div>

    <div class="sidebar-wrapper">
        <div class="user">
            <div class="info">
                <div class="photo">
                    <img src="../assets/img/default-avatar.png" />
                </div>

                <a data-toggle="collapse" href="#collapseExample" class="collapsed">
                    <span>
                        {{ Session::get('name') }}
                    </span>
                </a>

            </div>
        </div>

        <ul class="nav">

            <li>

                <a href="{{route('fee.index')}}">
                    <i class="pe-7s-note2"></i>
                    <p>Học phí</p>
                </a>
            </li>
            <li>
                <a href="{{route('subfee.index')}}">
                    <i class="pe-7s-plugin"></i>

                    <p>Phụ phí</p>

                </a>
            </li>
            <li>
                <a href="{{route('compensation.index')}}">
                    <i class="pe-7s-note2"></i>
                    <p>Đóng bù
                       
                    </p>
                </a>
            </li>
           
            

            
        </ul>
    </div>
</div>
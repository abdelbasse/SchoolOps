<!DOCTYPE html>
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<style>
    #alertsContainer {
        z-index: 999;
        max-height: 300px;
        overflow: hidden;
        position: fixed;
        top: 80px;
        right: 10px;
        display: flex;
        flex-direction: column-reverse;
        align-items: flex-end;
    }
</style>
<style>
    .sidebar_2 {
        position: fixed;
        left: 0;
        top: 0;
        height: 100%;
        width: 78px;
        background: #11101D;
        padding: 6px 14px;
        z-index: 10;
        transition: all 0.5s ease;
    }

    .fade {
        background-color: rgba(0, 0, 0, 0.405);
        backdrop-filter: blur(5px);
    }


    .modal-backdrop {
        display: none !important;
    }

    .sidebar_2.open2 {
        width: 250px;
    }

    .sidebar_2 .logo-details2 {
        height: 60px;
        display: flex;
        align-items: center;
        position: relative;
    }

    .sidebar_2 .logo-details2 .icon2 {
        opacity: 0;
        transition: all 0.5s ease;
    }

    .sidebar_2 .logo-details2 .logo_name2 {
        color: #fff;
        font-size: 20px;
        font-weight: 600;
        opacity: 0;
        transition: all 0.5s ease;
    }

    .sidebar_2.open2 .logo-details2 .icon2,
    .sidebar_2.open2 .logo-details2 .logo_name2 {
        opacity: 1;
    }

    .sidebar_2 .logo-details2 #btn1 {
        position: absolute;
        top: 50%;
        right: 0;
        transform: translateY(-50%);
        font-size: 22px;
        transition: all 0.4s ease;
        font-size: 23px;
        text-align: center;
        cursor: pointer;
        transition: all 0.5s ease;
    }

    .sidebar_2.open2 .logo-details2 #btn1 {
        text-align: right;
    }

    .sidebar_2 i {
        color: #fff;
        height: 60px;
        min-width: 50px;
        font-size: 28px;
        text-align: center;
        line-height: 60px;
    }

    .sidebar_2 .nav-list2 {
        margin-top: 20px;
        height: 100%;
    }

    .sidebar_2 li {
        position: relative;
        margin: 8px 0;
        list-style: none;
    }

    .sidebar_2 li .tooltip2 {
        position: absolute;
        top: -20px;
        left: calc(100% + 15px);
        z-index: 2;
        background: #fff;
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.3);
        padding: 6px 12px;
        border-radius: 4px;
        font-size: 15px;
        font-weight: 400;
        opacity: 0;
        white-space: nowrap;
        pointer-events: none;
        transition: 0s;
    }

    .sidebar_2 li:hover .tooltip2 {
        opacity: 1;
        pointer-events: auto;
        transition: all 0.4s ease;
        top: 50%;
        transform: translateY(-50%);
    }

    .sidebar_2.open2 li .tooltip2 {
        display: none;
    }

    .sidebar_2 input {
        font-size: 15px;
        color: #FFF;
        font-weight: 400;
        outline: none;
        height: 50px;
        width: 100%;
        width: 50px;
        border: none;
        border-radius: 12px;
        transition: all 0.5s ease;
        background: #1d1b31;
    }

    .sidebar_2.open2 input {
        padding: 0 20px 0 50px;
        width: 100%;
    }

    .sidebar_2 .bx-search {
        position: absolute;
        top: 50%;
        left: 0;
        transform: translateY(-50%);
        font-size: 22px;
        background: #1d1b31;
        color: #FFF;
    }

    .sidebar_2.open2 .bx-search:hover {
        background: #1d1b31;
        color: #FFF;
    }

    .sidebar_2 .bx-search:hover {
        background: #FFF;
        color: #11101d;
    }

    .sidebar_2 li a {
        display: flex;
        height: 100%;
        width: 100%;
        border-radius: 12px;
        align-items: center;
        text-decoration: none;
        transition: all 0.4s ease;
        background: #11101D;
    }

    .sidebar_2 li a:hover {
        background: #FFF;
    }

    .sidebar_2 li a .links_name2 {
        color: #fff;
        font-size: 15px;
        font-weight: 400;
        white-space: nowrap;
        opacity: 0;
        pointer-events: none;
        transition: 0.4s;
    }

    .sidebar_2.open2 li a .links_name2 {
        opacity: 1;
        pointer-events: auto;
    }

    .sidebar_2 li a:hover .links_name2,
    .sidebar_2 li a:hover i {
        transition: all 0.5s ease;
        color: #11101D;
    }

    .sidebar_2 li i {
        height: 50px;
        line-height: 50px;
        font-size: 18px;
        border-radius: 12px;
    }

    .sidebar_2 li.profile2 {
        position: fixed;
        height: 60px;
        width: 78px;
        left: 0;
        bottom: -8px;
        padding: 10px 14px;
        background: #1d1b31;
        transition: all 0.5s ease;
        overflow: hidden;
    }

    .sidebar_2.open2 li.profile2 {
        width: 250px;
    }

    .sidebar_2 li .profile2-details {
        display: flex;
        align-items: center;
        flex-wrap: nowrap;
    }

    .sidebar_2 li img {
        height: 45px;
        width: 45px;
        object-fit: cover;
        border-radius: 6px;
        margin-right: 10px;
    }

    .sidebar_2 li.profile2 .name,
    .sidebar_2 li.profile2 .job {
        font-size: 15px;
        font-weight: 400;
        color: #fff;
        white-space: nowrap;
    }

    .sidebar_2 li.profile2 .job {
        font-size: 12px;
    }

    .sidebar_2 .profile2 #log_out {
        position: absolute;
        top: 50%;
        right: 0;
        transform: translateY(-50%);
        background: #1d1b31;
        width: 100%;
        height: 60px;
        line-height: 60px;
        border-radius: 0px;
        transition: all 0.5s ease;
    }

    .sidebar_2.open2 .profile2 #log_out {
        width: 50px;
        background: none;
    }



    .home-section2 {
        position: relative;
        background: #E4E9F7;
        min-height: 100vh;
        top: 0;
        left: 78px;
        width: calc(100% - 78px);
        transition: all 0.5s ease;
        z-index: 2;
    }

    .sidebar_2.open2~.home-section2 {
        left: 250px;
        width: calc(100% - 250px);
    }

    .home-section2 .text2 {
        display: inline-block;
        color: #11101d;
        font-size: 25px;
        font-weight: 500;
        margin: 18px
    }

    ul {
        padding: 0px !important;
    }

    @media (max-width: 420px) {
        .sidebar_2 li .tooltip2 {
            display: none;
        }

        .sidebar_2 ul {
            display: none;
            min-width: 0px;
        }
    }

    @media (max-width:780px) {
        .sidebar_2 {
            left: -400px;
        }

        .sidebar_2.open2~.home-section2 {
            left: 0px;
            width: calc(100%);
        }

        .sidebar_2.open2 {
            left: 0px;
            width: calc(100%);
        }

        .home-section2 {
            left: 0px;
            width: calc(100%);
        }



    }

    @media (min-width:780px) {

        #elementMenuBtnPhone {
            display: none;
        }

    }
</style>
@yield('style')

<body>
    <div class="sidebar_2">
        <div class="logo-details2">
            <i class='bx bxl-c-plus-plus icon2 bx-sm'></i>
            <div class="logo_name2 ">CodingLab</div>
            <i class='bx bx-menu bx-md' id="btn1"></i>
        </div>
        <ul class="nav-list2">
            <li>
                <a href="{{ route('home') }}">
                    <i class='bx bx-grid-alt bx-sm'></i>
                    <span class="links_name2">Dashboard</span>
                </a>
                <span class="tooltip2">Dashboard</span>
            </li>
            <li>
                <a href="{{ route('music.timer') }}">
                    <i class='bx bx-music bx-sm'></i>
                    <span class="links_name2">Music & Timer</span>
                </a>
                <span class="tooltip2">Music & Timer</span>
            </li>
        </ul>
    </div>
    <section class="home-section2">
        <div
            style="width:100%; height: 60px; display:flex; justify-content:start; align-items:center; margin-bottom:30px; box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.15);">
            <div id="elementMenuBtnPhone">
                <i class='bx bx-menu bx-lg btn' style="margin: 30px; margin-left:5px;" id="btn2"></i>
            </div>
        </div>
        <div id="alertsContainer">

        </div>
        <script>
            setInterval(clearAlertsContainer, 10000);

            function clearAlertsContainer() {
                // Find the alerts container element
                var alertsContainer = document.getElementById('alertsContainer');

                // Clear the content of the alerts container
                alertsContainer.innerHTML = '';
            }
        </script>
        <script>
            var alertsContainer = document.getElementById('alertsContainer');

            function showAlertS(message) {
                alertsContainer.innerHTML += `<div class="alert d-flex justify-content-between alert-success bg-success text-white alert-dismissible" style="opacity:0.65;" role="alert">
                                                        <svg class="bi flex-shrink-0 me-2" role="img" style="width:20px; height:20px;" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
                                                <div>${message}</div>
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>`;

            }

            function showAlertD(message) {
                alertsContainer.innerHTML += `<div class="alert d-flex justify-content-between alert-danger bg-danger text-white  alert-dismissible" style="opacity:0.65;" role="alert">
                    <svg class="bi flex-shrink-0 me-1" role="img" style="width:20px; height:20px;" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
            <div>
            <div>${message}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>`;
            }
        </script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
        @yield('script_1')
        <div class="container p-2">
            @yield('body')
        </div>
        @yield('script_2')
    </section>
</body>

</html>



<script>
    let sidebar = document.querySelector(".sidebar_2");
    let closeBtn = document.querySelector("#btn1");
    let closeBtn2 = document.querySelector("#btn2");
    let searchBtn = document.querySelector(".bx-search");

    closeBtn.addEventListener("click", () => {
        sidebar.classList.toggle("open2");
        menuBtnChange(); //calling the function(optional)
    });

    closeBtn2.addEventListener("click", () => {
        sidebar.classList.toggle("open2");
        menuBtnChange(); //calling the function(optional)
    });

    searchBtn.addEventListener("click", () => { // Sidebar open2 when you click on the search iocn
        sidebar.classList.toggle("open2");
        menuBtnChange(); //calling the function(optional)
    });

    // following are the code to change sidebar button(optional)
    function menuBtnChange() {
        if (sidebar.classList.contains("open2")) {
            closeBtn.classList.replace("bx-menu", "bx-x-circle"); //replacing the iocns class
        } else {
            closeBtn.classList.replace("bx-x-circle", "bx-menu"); //replacing the iocns class
        }
    }
</script>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

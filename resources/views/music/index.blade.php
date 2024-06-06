@extends('layouts.app')
@section('body')
    <style>
        .drop_box {
            margin: 10px 0;
            padding: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            border: 3px dotted #a3a3a3;
            border-radius: 5px;
        }

        .drop_box h4 {
            font-size: 16px;
            font-weight: 400;
            color: #2e2e2e;
        }

        .drop_box p {
            margin-top: 10px;
            margin-bottom: 20px;
            font-size: 12px;
            color: #a3a3a3;
        }

        .custom-file-input input[type="file"] {
            opacity: 0;
            position: absolute;
            pointer-events: none;
        }

        /* Style the custom button */
        .custom-file-input label {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            display: inline-block;
        }

        .theNumberContainer {
            background-color: rgb(56, 56, 56);
            color: rgb(221, 221, 221);
            width: 30px;
            height: 40px;
            text-align: center;
        }

        .counterText {
            font-weight: bold;
            font-size: 25px;
        }

        .MusicCardElement {
            border-radius: 14px;
            padding: 20px;
            background-color: rgba(57, 194, 57);
            background-image: url("{{ asset('images/leafs.png') }}");
            background-repeat: no-repeat;
            background-size: 35%;
            background-position: 0 0;
            transition: all 0.3s ease-in;

        }

        /* .MusicCardElement[data-statu="0"] {
                                                                                                                                                                                    padding: 20px;
                                                                                                                                                                                    background-position: -500px -500px;
                                                                                                                                                                                    background-color: rgb(134, 134, 134);
                                                                                                                                                                                    background-image: linear-gradient(to bottom right, rgb(220, 220, 220), rgb(60, 60, 60));
                                                                                                                                                                                    transition: all 0.3s ease-in;
                                                                                                                                                                                } */

        .elementMusicIcon {
            width: 50px;
            height: 50px;
            border-radius: 8px;
            background-color: #362FD9;
            background-image: url("{{ asset('icons/wave.png') }}");
            background-repeat: no-repeat;
            background-position: center;
            background-size: 80%;
        }

        .MusictextTitles {
            width: 100px;
        }

        .musiciconContaner {
            width: 50px;
        }

        .contentTable {
            padding: 20px;
            backdrop-filter: blur(10px);
            /* Blur effect */
            box-shadow: 0 2px 4px rgba(200, 200, 200, 0.3);
            /* Optional shadow */
        }


        ul {
            list-style: none;
        }

        li {
            cursor: pointer;
        }

        li:hover {
            box-shadow: 0 3px 8px rgba(28, 1, 79, 0.5);
        }

        .theBtmConttrolleTheMusicStartOrNot {
            cursor: pointer;
            border-radius: 1000px;
            height: 40px;
            width: 40px;
            background-image: url("{{ asset('icons/pause.png') }}");
            background-position: 50% 50%;
            background-size: 45%;
            background-repeat: no-repeat;
            background-color: #53873e;
        }

        .theBtmConttrolleTheMusicStartOrNot[data-statu='0'] {
            background-image: url("{{ asset('icons/play.png') }}");
            background-position: 55% 50%;
            background-size: 50%;
            background-color: #573e87;
        }
    </style>
    <div class="container-xl p-0 m-0 container-md container-lg container-sm ">
        <div class="row row-cols-1 row-cols-xl-2 row-cols-md-2 row-cols-sm-1">
            <div class="col">
                <h1>Music List</h1>
            </div>
            <div class="col d-flex justify-content-end">
                <div class=" d-flex align-items-center">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <i class='bx bx-message-square-add mt-0 mb-0 bx-sm m-2'></i>
                            </div>
                            <div class="m-2 text-bold mt-0 mb-0">
                                New List
                            </div>
                        </div>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="alertsContainer">

    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function parseTimeString(timeString) {
            var parts = timeString.split(":");
            var hours = parseInt(parts[0], 10);
            var minutes = parseInt(parts[1], 10);
            var date = new Date();
            date.setHours(hours);
            date.setMinutes(minutes);
            return date;
        }
        $('body').on('click', '.btnDeleteCard', function() {
            var dataIdValue = $(this).data('idcard');
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('music.timer') }}",
                        method: 'POST',
                        data: {
                            id: dataIdValue,
                            statu: "deleteCard",
                            _token: '{{ csrf_token() }}',
                        },
                        success: function(response) {
                            showAlertS("Card Deleted Successfuly!");
                            location.reload();
                        },
                        error: function(xhr, status, error) {
                            showAlertD(
                                "Ereure Somthing went wrong while Deleting data!"
                            );
                        },
                    });
                    Swal.fire(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                    )
                }
            })
        });

        $(document).ready(function() {
            $("#submitBtn").click(function() {
                var timeEnd = $("#musicCardTimeEnd").val();
                var timeStart = $("#musicCardTimeStart").val();
                if ((timeEnd !== "" && timeStart !== "") && (timeEnd > timeStart)) {
                    // Make the AJAX request
                    console.log("sending Ajax...");
                    $.ajax({
                        url: "{{ route('music.timer') }}",
                        method: 'POST',
                        data: {
                            timeEnd: timeEnd,
                            timeStart: timeStart,
                            statu: "creatCard",
                            _token: '{{ csrf_token() }}',
                        },
                        success: function(response) {
                            showAlertS("Card created with Success");
                            var containerElement = document.getElementById(
                                "MusicCardContainer");
                            var innerHTMLMusicContent = containerElement.innerHTML;
                            var statu = 1;

                            var cardTimeStart = parseTimeString(response.timeStart);
                            var currentTime = new Date();
                            console.log("heey  " + cardTimeStart);
                            console.log(currentTime);
                            if (currentTime > cardTimeStart) {
                                statu = 0;
                            }

                            var str = innerHTMLMusicContent;
                            str += `<div class="MusicCardElement mb-5 shadow " data-statu="${statu}">
                                <div class="theCardStatu" hidden>${statu}</div>
                                <div class="row m-0 p-0 row-cols-2 pt-2 mb-3" style="min-height: 90px;">
                                    <div class="col col-9 m-0 p-0 ">
                                        <h2 class="p-3 pb-0  pt-0 text-white ">Timer at : "${response.timeStart}:00"  to  "${response.timeEnd}:00"</h2>
                                        <div class="counterText d-flex counterElement" style="max-width: 350px;">
                                            <input type="time" class="theTimerValue" value="${response.timeStart}" hidden>
                                            <input type="time" class="theTimerValueFinal" value="${response.timeEnd}" hidden>
                                            <div class="container d-flex justify-content-center ElementsContainer1">
                                                <div class="rounded theNumberContainer m-1 mb-0 mt-0 Element2">0</div>
                                                <div class="rounded theNumberContainer m-1 mb-0 mt-0 Element1">0</div>
                                            </div>
                                            :<div class="container d-flex justify-content-center ElementsContainer2">
                                                <div class="rounded theNumberContainer m-1 mb-0 mt-0 Element2">0</div>
                                                <div class="rounded theNumberContainer m-1 mb-0 mt-0 Element1">0</div>
                                            </div>
                                            :<div class="container d-flex justify-content-center ElementsContainer3">
                                                <div class="rounded theNumberContainer m-1 mb-0 mt-0 Element2">0</div>
                                                <div class="rounded theNumberContainer m-1 mb-0 mt-0 Element1">0</div>
                                            </div>
                                        </div>
                                        <div class=" d-flex " style="max-width: 350px;">
                                            <div class="container d-flex justify-content-end ">
                                                <div style="font-weight:bold ; color: #f4f4f4;">
                                                    Her
                                                </div>
                                            </div>
                                            <div class="container d-flex justify-content-end ">
                                                <div style="font-weight:bold ; color: #f4f4f4;">
                                                    Min
                                                </div>
                                            </div>
                                            <div class="container d-flex justify-content-end ">
                                                <div style="font-weight:bold ; color: #f4f4f4;">
                                                    Sec
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col m-0 p-0 col-3 d-flex justify-content-end p-3 pt-0 pb-0">
                                        <div>
                                            <button class="btn btn-danger text-bold btnDeleteCard" data-idcard="${response.id}">
                                                Remove
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="row m-0 p-0 row-cols-1 p-3 pt-0 pb-0">
                                    <div class="col p-4 pt-0 pb-1 contentTable" style="">
                                        <div class="container d-flex justify-content-between " style="font-size: 18px; color:white;">
                                            <div class="musiciconContaner"></div>
                                            <div style="min-width: 50px;">Pause/Paly</div>
                                            <div class="MusictextTitles">Name</div>
                                            <div class="MusictextTitles">Time</div>
                                            <div class="MusictextTitles">Option</div>
                                        </div>
                                    </div>
                                    <div class="col  bg-gray-300 h-100"
                                        style="border-bottom-right-radius:8px; border-bottom-left-radius:8px; min-height: 90px; background-color:rgb(208, 208, 208); ">
                                        <div class="musicListContainer m-0 p-3"
                                            style="border-top-right-radius:0px; border-top-left-radius:0px;">
                                            <ul class="sortable-container">
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <div class="row p-1 m-0 pb-0 pt-2">
                                    <div class="col d-flex justify-content-end">
                                        <div>
                                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAddMusic${response.id}">
                                                Add Music
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal fade  " id="modalAddMusic${response.id}" data-bs-backdrop="static" data-bs-keyboard="false"
                                tabindex="-2" aria-labelledby="modalAddMusicLabel" aria-hidden="true">
                                <div class="modal-dialog  d-flex align-items-center">
                                    <div class="modal-content" style="margin-top:25%;">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="modalAddMusicLabel">ADD New Music</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('music.timer.Post') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class=" modal-body">
                                                <div>
                                                    <div class="alert alert-warning d-flex mb-1 align-items-center" role="alert">
                                                        <i class='bx bxs-error bx-sm ' style="margin-right: 20px;"></i>
                                                        <div>
                                                            Once you add music, this page will be refreshed, causing the currently playing
                                                            music to
                                                            stop.
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="drop_box">

                                                    <header>
                                                        <h4>Select File here</h4>
                                                    </header>
                                                    <p>Files Supported: WAV, MP3, OGG, AAC</p>
                                                    <div class="custom-file-input">
                                                        <label for="fileInput">Select File</label>
                                                        <input type="file" id="fileInput" name="theMusic"
                                                            accept=".mp3,.wav,.ogg,.aac">
                                                        <input type="text" name="statu" value="AddMusic" hidden>
                                                        <input type="text" name="idCard" value="${response.id}" hidden>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <input type="submit" class="btn btn-primary" value="ADD">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            `;
                            containerElement.innerHTML = str;
                        },
                        error: function(xhr, status, error) {
                            showAlertD("Ereure Somthing went wrong while saving data!");
                        },
                    });
                } else {
                    showAlertD("the Inuts fields are wrong!!");
                }
            });
        });
    </script>
    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-2"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Create New Card</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        @csrf
                        <div class="row row-cols-2 m-1 p-1">
                            <div class="col p-2 col-4 p-2">Start Time</div>
                            <div class="col p-2 col-8">
                                <div class="input-group mb-3">
                                    <input type="time" class="form-control" id="musicCardTimeStart">
                                </div>
                            </div>
                            <div class="col p-2 col-4 p-2">End Time</div>
                            <div class="col p-2 col-8">
                                <div class="input-group mb-3">
                                    <input type="time" class="form-control" id="musicCardTimeEnd">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="submitBtn">Create</button>
                </div>
            </div>
        </div>
    </div>

    <div class="container-xl p-0 m-0 container-md container-lg pt-5 container-sm  " id="MusicCardContainer">

        @php
            $i = 0;
        @endphp
        @foreach ($cards as $card)
            @php
                $currentTime = time();
                $cardTime = strtotime($card->from);
                $cardTimeArray = explode(':', $card->from);
                $cardHours = intval($cardTimeArray[0]);
                $cardMinutes = intval($cardTimeArray[1]);

                if ($currentTime < $cardTime) {
                    $variable = 1;
                } else {
                    $currentHours = date('H', $currentTime);
                    $currentMinutes = date('i', $currentTime);

                    if ($currentHours > $cardHours || ($currentHours === $cardHours && $currentMinutes >= $cardMinutes)) {
                        $variable = 0;
                    } else {
                        $variable = 1;
                    }
                }

            @endphp
            <div class="MusicCardElement mb-5 shadow " data-statu="{{ $variable }}">
                <div class="theCardStatu" hidden>{{ $variable }}</div>
                <div class="row m-0 p-0 row-cols-2 pt-2 mb-3" style="min-height: 90px;">
                    <div class="col col-9 m-0 p-0 ">
                        <h2 class="p-3 pb-0  pt-0 text-white ">Timer at : "{{ $card->from }}" to "{{ $card->to }}"
                        </h2>
                        <div class="counterText d-flex counterElement" style="max-width: 350px;">
                            <input type="time" class="theTimerValue" value="{{ $card->from }}" hidden>
                            <input type="time" class="theTimerValueFinal" value="{{ $card->to }}" hidden>
                            <div class="container d-flex justify-content-center ElementsContainer1">
                                <div class="rounded theNumberContainer m-1 mb-0 mt-0 Element2">0</div>
                                <div class="rounded theNumberContainer m-1 mb-0 mt-0 Element1">0</div>
                            </div>
                            :<div class="container d-flex justify-content-center ElementsContainer2">
                                <div class="rounded theNumberContainer m-1 mb-0 mt-0 Element2">0</div>
                                <div class="rounded theNumberContainer m-1 mb-0 mt-0 Element1">0</div>
                            </div>
                            :<div class="container d-flex justify-content-center ElementsContainer3">
                                <div class="rounded theNumberContainer m-1 mb-0 mt-0 Element2">0</div>
                                <div class="rounded theNumberContainer m-1 mb-0 mt-0 Element1">0</div>
                            </div>
                        </div>
                        <div class=" d-flex " style="max-width: 350px;">
                            <div class="container d-flex justify-content-end ">
                                <div style="font-weight:bold ; color: #f4f4f4;">
                                    Her
                                </div>
                            </div>
                            <div class="container d-flex justify-content-end ">
                                <div style="font-weight:bold ; color: #f4f4f4;">
                                    Min
                                </div>
                            </div>
                            <div class="container d-flex justify-content-end ">
                                <div style="font-weight:bold ; color: #f4f4f4;">
                                    Sec
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col m-0 p-0 col-3 d-flex justify-content-end p-3 pt-0 pb-0">
                        <div>
                            <button class="btn btn-danger text-bold btnDeleteCard" data-idcard="{{ $card->id }}">
                                Remove
                            </button>
                        </div>
                    </div>
                </div>

                <div class="row m-0 p-0 row-cols-1 p-3 pt-0 pb-0">
                    <div class="col p-4 pt-0 pb-1 contentTable" style="">
                        <div class="container d-flex justify-content-between " style="font-size: 18px; color:white;">
                            <div class="musiciconContaner"></div>
                            <div style="min-width: 50px;">Pause/Play</div>
                            <div class="MusictextTitles">Name</div>
                            <div class="MusictextTitles">Time</div>
                            <div class="MusictextTitles">Option</div>
                        </div>
                    </div>
                    <div class="col  bg-gray-300 h-100"
                        style="border-bottom-right-radius:8px; border-bottom-left-radius:8px; min-height: 90px; background-color:rgb(208, 208, 208); ">
                        <div class="musicListContainer m-0 p-3"
                            style="border-top-right-radius:0px; border-top-left-radius:0px;">
                            <ul class="sortable-container">

                                {!! $musicList[$i++] !!}

                            </ul>
                        </div>
                    </div>
                </div>

                <div class="row p-1 m-0 pb-0 pt-2">
                    <div class="col d-flex justify-content-end">
                        <div>
                            <button class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#modalAddMusic{{ $card->id }}">
                                Add Music
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            {{-- the modal for each caard --}}
            <div class="modal fade  " id="modalAddMusic{{ $card->id }}" data-bs-backdrop="static"
                data-bs-keyboard="false" tabindex="-2" aria-labelledby="modalAddMusicLabel" aria-hidden="true">
                <div class="modal-dialog  d-flex align-items-center">
                    <div class="modal-content" style="margin-top:25%;">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="modalAddMusicLabel">ADD New Music</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <form action="{{ route('music.timer.Post') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class=" modal-body">
                                <div>
                                    <div class="alert alert-warning d-flex mb-1 align-items-center" role="alert">
                                        <i class='bx bxs-error bx-sm ' style="margin-right: 20px;"></i>
                                        <div>
                                            Once you add music, this page will be refreshed, causing the currently playing
                                            music to
                                            stop.
                                        </div>
                                    </div>
                                </div>
                                <div class="drop_box">

                                    <header>
                                        <h4>Select File here</h4>
                                    </header>
                                    <p>Files Supported: WAV, MP3, OGG, AAC</p>
                                    <div class="custom-file-input">
                                        <label for="fileInput">Select File</label>
                                        <input type="file" id="fileInput" name="theMusic"
                                            accept=".mp3,.wav,.ogg,.aac">
                                        <input type="text" name="statu" value="AddMusic" hidden>
                                        <input type="text" name="idCard" value="{{ $card->id }}" hidden>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <input type="submit" class="btn btn-primary" value="ADD">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach

    </div>
@endsection


@section('script_1')
    <script>
        $(function() {
            $(".sortable-container").sortable();
        });
    </script>
@endsection
@section('script_2')
    <script>
        function updateDataStatuAttribute(audioElement, status) {
            const divElement = audioElement.parentElement.querySelector('.theBtmConttrolleTheMusicStartOrNot');
            divElement.setAttribute('data-statu', status);
        }

        function funcPlayOrPausetheMusicList(element) {
            const liElement = element.closest('li');
            const audioElement = liElement.querySelector('.theMusic');
            if (audioElement.paused) {
                audioElement.play();
                element.setAttribute('data-statu', '1');
            } else {
                audioElement.pause();
                element.setAttribute('data-statu', '0');
            }
        }
        document.querySelectorAll('.theMusic').forEach(audioElement => {
            audioElement.addEventListener('play', () => {
                updateDataStatuAttribute(audioElement, '1'); // Update to playing status
            });

            audioElement.addEventListener('pause', () => {
                updateDataStatuAttribute(audioElement, '0'); // Update to paused status
            });
        });
    </script>
    <script>
        $(document).ready(function(){

        });
        function setupDeleteButtons() {
            // Get all the delete buttons
            const deleteButtons = document.querySelectorAll('.btn-outline-danger');

            // Attach click event listeners to each delete button
            deleteButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const listItem = button.closest('li');
                    if (listItem) {
                        const dataIdValue = button.getAttribute('data-id');
                        $.ajax({
                            url: "{{ route('music.timer') }}",
                            method: 'POST',
                            data: {
                                id: dataIdValue,
                                statu: "deleteMusic",
                                _token: '{{ csrf_token() }}',
                            },
                            success: function(response) {
                                showAlertS("Music removed");
                                listItem.remove();
                            },
                            error: function(xhr, status, error) {
                                showAlertD(
                                    "Ereure Somthing went wrong while Deleting data!"
                                );
                            },
                        });
                    }
                });
            });
        }

        // Call the function to set up delete button functionality
        setupDeleteButtons();
    </script>
    <script>
        function play(parent, currentIndex = 0) {
            var musicContainer = parent.querySelector('.musicListContainer');
            var musicArray = musicContainer.querySelectorAll('.theMusic');
            if (currentIndex >= musicArray.length) {
                return;
            }
            var musicAudioController = musicArray[currentIndex];
            musicAudioController.onended = function() {
                play(parent, currentIndex + 1);
            };
            musicAudioController.play();
        }

        function getTimeLeft(targetTime, parent) {
            const target = new Date();
            const [hours, minutes] = targetTime.split(':');
            target.setHours(hours, minutes, 0, 0);
            const now = new Date();
            var theTime = target - now;

            if (theTime <= 0) {
                // here the function that will play all the music of this music card
                // and it must happen one time so add a condition or somthing
                console.log(parent.querySelector('.theCardStatu'));
                parent.querySelector('.theCardStatu').innerHTML = "0";
                console.log(parent.querySelector('.theCardStatu'));
                parent.setAttribute('data-statu', '0');
                play(parent);
                // return 0 cause it negative
                return {
                    s: 0,
                    m: 0,
                    h: 0
                };
            }

            const timeLeftInHours = Math.floor((theTime) / (60 * 60 * 1000));
            theTime -= (timeLeftInHours * 60 * 60 * 1000);
            const timeLeftInMinutes = Math.floor((theTime) / (60 * 1000));
            theTime -= (timeLeftInMinutes * 60 * 1000);
            const timeLeftInSeconds = Math.floor((theTime) / (1000));

            return {
                s: timeLeftInSeconds,
                m: timeLeftInMinutes,
                h: timeLeftInHours
            };
        }

        function slpitTheNumber(input) {
            let firstNumber = input % 10;
            let secondNumber = Math.floor(input / 10);
            return {
                firstNumber: firstNumber,
                secondNumber: secondNumber,
            };
        }

        function counter() {
            var tab = document.getElementsByClassName("MusicCardElement");
            for (var i = 0; i < tab.length; i++) {
                var parent = tab[i];


                // Check if the music should be stopped based on the remaining time and stop time.
                var stopTimeInput = document.querySelector('.theTimerValueFinal');
                var stopTime = stopTimeInput.value;
                var now = new Date();
                var currentTime = now.getHours() + ':' + now.getMinutes();

                if (currentTime >= stopTime) {
                    stopMusicForCard(parent);
                }

                if (parent.querySelector('.theCardStatu').innerHTML === "0") {
                    parent.setAttribute('data-statu', '0');
                    continue;
                }

                var element = parent.querySelector('.counterElement');
                var time = element.querySelector('.theTimerValue');
                var timeLeft = getTimeLeft(time.value, parent);

                var subelement = element.querySelector('.ElementsContainer1');
                subelement.querySelector('.Element1').innerHTML = slpitTheNumber(timeLeft.h).firstNumber;
                subelement.querySelector('.Element2').innerHTML = slpitTheNumber(timeLeft.h).secondNumber;

                var subelement = element.querySelector('.ElementsContainer2');
                subelement.querySelector('.Element1').innerHTML = slpitTheNumber(timeLeft.m).firstNumber;
                subelement.querySelector('.Element2').innerHTML = slpitTheNumber(timeLeft.m).secondNumber;

                var subelement = element.querySelector('.ElementsContainer3');
                subelement.querySelector('.Element1').innerHTML = slpitTheNumber(timeLeft.s).firstNumber;
                subelement.querySelector('.Element2').innerHTML = slpitTheNumber(timeLeft.s).secondNumber;
            }
        }

        function stopMusicForCard(parent) {
            var musicContainer = parent.querySelector('.musicListContainer');
            var musicArray = musicContainer.querySelectorAll('.theMusic');
            for (let index = 0; index < musicArray.length; index++) {
                var musicAudioController = musicArray[index];
                musicAudioController.pause();
            }
        }
    </script>
    <script>
        setInterval(counter, 1000);
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            function updateIconColor(parent, status) {
                const elementMusicIcon = parent.querySelector('.elementMusicIcon');
                if (status === 'playing') {
                    elementMusicIcon.style.backgroundColor = 'rgba(57, 194, 57)';
                } else if (status === 'paused') {
                    elementMusicIcon.style.backgroundColor = 'rgba(57, 194, 57)';
                } else if (status === 'ended') {
                    elementMusicIcon.style.backgroundColor = '#362FD9';
                }
            }

            const musicContainers = document.querySelectorAll('.sortable-container li');
            musicContainers.forEach(container => {
                const audio = container.querySelector('.theMusic');

                audio.addEventListener('play', () => {
                    updateIconColor(container, 'playing');
                });

                audio.addEventListener('pause', () => {
                    updateIconColor(container, 'paused');
                });

                audio.addEventListener('ended', () => {
                    updateIconColor(container, 'ended');
                });
            });
        });
    </script>
@endsection

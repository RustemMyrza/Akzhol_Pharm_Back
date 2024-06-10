<!DOCTYPE html>
<html lang="en">
<head>
    <title>Certificate</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        * {
            font-family: "DejaVu Sans", sans-serif;
        }

        body {
            padding: 0;
            margin: 0;

            @if($language == 'ru')
                 background-image: url("https://back-lms.mydev.kz/1.png");
            @else
             background-image: url("https://back-lms.mydev.kz/2.png");
            @endif

             background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        html {
            padding: 0;
            margin: 0;
        }

        .certificate {
            top: 50%;
            height: 100vh;
        }

        .name {
            position: absolute;
            top: 365px;
            left: 160px;
            font-size: 30px;
        }

        .course-name {
            position: absolute;
            top: 438px;
            @if($language == 'ru')
             left: 379px;
            @else
             left: 319px;
            @endif
         font-size: 18px;
        }

        .date {
            position: absolute;
            top: 595px;
            left: 120px;
            font-size: 20px;
        }
    </style>
</head>
<body>

<div class="certificate">
    <div class="name">
        {{ $name }}
    </div>

    <div class="course-name">
        {{ $courseName }}
    </div>

    <div class="date">
        {{ $date }}
    </div>
</div>

</body>
</html>

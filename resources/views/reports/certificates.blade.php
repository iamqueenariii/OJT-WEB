<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        .monotype {
            font-family: "Monotype Corsiva", cursive;
        }

        .container {
            position: relative;
            width: 100%;
        }

        .applicant-name {
            position: absolute;
            top: 385px;
            left: 25px;
            color: rgb(49, 44, 44);
            width: 100%;
            text-align: center;
        }

        .text-center {
            text-align: center;
        }

        .text-100 {
            font-size: 100px;
        }

        .text-40 {
            font-size: 34px;
            font-family: 'Times New Roman', Times, serif;
            color: rgb(49, 44, 44);
        }

        .day {
            position: absolute;
            top: 305px;
            left: 314px;
        }

        .type {
            position: absolute;
            top: 130px;
            left: 593px;
            color: rgb(49, 44, 44);
        }

        .text-20 {
            font-size: 35px;
            font-family: 'Times New Roman', Times, serif;
            color: rgb(49, 44, 44);
        }
    </style>
</head>

<body style="width: 13in; height: 8.5in">
    @foreach ($certificates as $certificate)
        <div class="container">
            <img style="width: 100%;" src="{{ asset('storage/template/template1.jpg') }}" alt="">
            <div class="text-center applicant-name">
                <span class="monotype text-100"> {{ $certificate->fullname }}</span>
                <p class="text-40 " style="padding-left: 10%; width: 80%;">
                    for successfully completing the {{ $certificate->type }} at the Local
                    Government Unit of Manolo Fortich under {{ $certificate->office_name }} for {{ $certificate->hrs }}
                    hours
                    from
                    @if ($certificate->applicant)
                        @if (date('FY', strtotime($certificate->applicant->started_date)) == date('FY', strtotime($certificate->dateFinished)))
                            {{ date('F j', strtotime($certificate->applicant->started_date)) }}-{{ date('j, Y', strtotime($certificate->dateFinished)) }}.
                        @elseif (date('Y', strtotime($certificate->applicant->started_date)) == date('Y', strtotime($certificate->dateFinished)))
                            {{ date('F j', strtotime($certificate->applicant->started_date)) }} -
                            {{ date('F j, Y', strtotime($certificate->dateFinished)) }}.
                        @endif
                    @endif

                </p>
                <p class="text-40">
                    Given this {{ Carbon\Carbon::parse($certificate->dateIssued)->format('jS') }} of
                    {{ ucwords(date('F Y', strtotime($certificate->dateIssued))) }} at Manolo Fortich, Bukidnon.
                </p>
            </div>
        </div>
    @endforeach
</body>

</html>

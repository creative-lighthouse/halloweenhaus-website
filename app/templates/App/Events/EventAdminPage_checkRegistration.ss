<head>
    <% base_tag %>
    $MetaTags(false)
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta charset="utf-8">
    <title>$Title - $SiteConfig.Title</title>
    $ViteClient.RAW
    <link rel="stylesheet" href="$Vite('app/client/src/scss/main.scss')">

    <link rel="apple-touch-icon" sizes="180x180" href="../apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../favicon-16x16.png">
    <link rel="mask-icon" href="../mask_icon.svg" color="#ffffff">

    <meta property="og:title" content="$Title - $SiteConfig.Title" />
    <meta property="og:site_name" content="$Title" />
    <meta property="og:type" content="article" />
    <meta property="og:description" content="$Description">
    <meta property="og:url" content="$Link" />
    <% if $Image %>
    <meta property="og:image" content="$Image.Link" />
    <% else %>
    <meta property="og:image" content="../_resources/app/client/images/socialmedia.png" />
    <meta property="og:image:alt" content="Otto Woodmann vor einem dunklem Wald" />
    <% end_if %>
    <meta property="og:image:type" content="image/jpeg" />
    <meta property="og:image:width" content="1200" />
    <meta property="og:image:height" content="630" />
    <meta property="og:locale" content="de_DE" />
    <meta name="twitter:card" content="summary_large_image">

    <meta name="msapplication-TileColor" content="#151515">
    <meta name="theme-color" content="#151515">

    $ViteClient.RAW
    <link rel="stylesheet" href="$Vite('app/client/src/scss/main.scss')">
    <link rel="manifest" href="site.webmanifest" />
</head>
<body class="ticket">
    <div class="section section--EventsAdmin">
        <div class="section_content">
            <div class="section_title" data-behaviour="ticketData" data-time="$TimeSlot.SlotTimeFormatted" data-date="$Event.DateFormatted" data-slotlength="$Event.SlotDuration" data-status="$Registration.Status">
                <h1>$Registration.Title</h1>
                <h2>$Event.Title</h2>
                <h3 class="section_title_ticketcheck" data-behaviour="ticketCheck"></h3>
            </div>
            <div class="section_data">
                <div class="section_data_tile">
                    <p class="tile_value">$Event.DateFormatted</p>
                    <p class="tile_title">Datum</p>
                </div>
                <div class="section_data_tile">
                    <p class="tile_value">$TimeSlot.SlotTimeFormatted</p>
                    <p class="tile_title">Slot Start</p>
                </div>
                <div class="section_data_tile">
                    <p class="tile_value">$TimeSlot.SlotTimeEndFormatted</p>
                    <p class="tile_title">Slot Ende</p>
                </div>
            </div>
            <div class="section_data">
                <div class="section_data_tile">
                    <p class="tile_value">$Registration.GroupSize</p>
                    <p class="tile_title">Gruppengröße</p>
                </div>
                <div class="section_data_tile">
                    <p class="tile_value">$Registration.Status</p>
                    <p class="tile_title">Status</p>
                </div>
                <div class="section_data_tile">
                    <p class="tile_value" data-behaviour="currentTime">00:00</p>
                    <p class="tile_title">Aktuelle Zeit</p>
                </div>
            </div>
            <div class="section_buttons">
                <a href="$Top.Link('cancel')/$Registration.Hash" class="button button--secondary">Entfernen</a>
                <a href="$Top.Link('checkIn')/$Registration.Hash" class="button button--primary">Check In!</a>
            </div>
        </div>
    </div>
    <script src="$Mix("/js/main.js")"></script>
</body>

<% with $Registration %>
    <head>
        <% base_tag %>
        $MetaTags(false)
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta charset="utf-8">
        <title>$Title - $SiteConfig.Title</title>
        <link rel="apple-touch-icon" sizes="180x180" href="../apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="../favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="../favicon-16x16.png">
        <link rel="manifest" href="../site.webmanifest">
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
        <link rel="stylesheet" href="$Mix("/css/styles.min.css")">
    </head>
    <body class="ticket">
        <div class="section section--Ticket">
            <div class="section_ticket">
                <div class="section_headline">
                    <% include MovingLogo %>
                </div>
                <div class="section_data">
                    <h1>Virtual Queue Ticket</h1>
                    <h2>Name: $Title</h2>
                    <h2>Gruppengröße: $GroupSize Personen</h2>
                    <h2>Veranstaltung: $Event.Title</h2>
                    <h2>Datum: $Event.DateFormatted</h2>
                    <h3>Ort: $Event.Place</h3>
                    <h3>Gebuchter Slot: $TimeSlot.SlotTimeFormatted</h3>
                </div>
                <div class="section_scancode">
                    <img src="$QRCode" alt="QR-Code">
                </div>
            </div>
        </div>
    </body>
<% end_with %>

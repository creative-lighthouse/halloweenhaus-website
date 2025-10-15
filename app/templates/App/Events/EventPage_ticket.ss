<% with $Registration %>
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
    <body class="ticket <% if $UsedCoupon %>$UsedCoupon.Type<% end_if %>">
        <div class="section section--Ticket">
            <div class="section_ticket">
                <div class="section_headline">
                    <% include MovingLogo %>
                </div>
                <div class="section_scancode" data-behaviour="scancode">
                    <img src="$QRCode" alt="QR-Code">
                </div>
                <div class="section_data">
                    <% if $UsedCoupon %><h1>$UsedCoupon.Type</h1><% end_if %>
                    <h2>$Title</h2>
                    <h3>$GroupSize Personen</h3>
                    <hr>
                    <h2>$Event.Title</h2>
                    <h3>$Event.DateFormatted | $TimeSlot.SlotTimeFormatted - $TimeSlot.SlotTimeEndFormatted</h3>
                    <h4>Ort: $Event.Place</h4>
                </div>
                <% if $Status == "CheckedIn" %>
                    <div class="section_status_wrap">
                        <div class="section_status" data-behaviour="sectionStatus">
                            <h2 class="status_title">Check-In erfolgreich</h2>
                            <h3 class="status_subline">Vielen Dank für deinen Besuch</h3>
                            <a href="$Top.FeedbackPageLink" class="status_button">Feedback abgeben</a>
                        </div>
                    </div>
                <% else_if $Status == "Cancelled" %>
                    <div class="section_status_wrap">
                        <div class="section_status" data-behaviour="sectionStatus">
                            <h2 class="status_title">Buchung deaktiviert</h2>
                            <a href="$Top.FeedbackPageLink" class="status_button">Feedback abgeben</a>
                        </div>
                    </div>
                <% end_if %>
                <div class="section_gear">
                    <img src="./_resources/app/client/images/Zahnrad.png" alt="Gear">
                </div>
                <div class="section_gear2">
                    <img src="./_resources/app/client/images/Zahnrad.png" alt="Gear">
                </div>
            </div>
        </div>
        <script src="$Mix("/js/main.js")"></script>
        <script>
            function autoRefresh() {
                const OutOfWay = document.querySelector('.outofway');
                if(!OutOfWay) {
                    window.location = window.location.href;
                } else {
                    console.log('Out of way active');
                }
            }
            setInterval('autoRefresh()', 10000);
        </script>
    </body>
<% end_with %>

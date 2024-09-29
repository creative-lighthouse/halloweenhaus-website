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
    <% if $CurrentUser %>
        <div class="section section--EventsAdmin">
            <div class="section_content">
                <div class="section_qrcodescan">
                    <video id="qrcode-video"></video>
                    <div class="scan-region-highlight" style="position: absolute; pointer-events: none; transform: scaleX(-1);">
                        <svg class="scan-region-highlight-svg" viewBox="0 0 238 238" preserveAspectRatio="none" style="position:absolute;width:100%;left:0;top:0;fill:none;stroke:#e9b213;stroke-width:4;stroke-linecap:round;stroke-linejoin:round"><path d="M31 2H10a8 8 0 0 0-8 8v21M207 2h21a8 8 0 0 1 8 8v21m0 176v21a8 8 0 0 1-8 8h-21m-176 0H10a8 8 0 0 1-8-8v-21"></path></svg><svg class="code-outline-highlight" preserveAspectRatio="none" style="display:none;width:100%;fill:none;stroke:#e9b213;stroke-width:5;stroke-dasharray:25;stroke-linecap:round;stroke-linejoin:round"><polygon></polygon></svg>
                    </div>
                    <div class="logo">
                        <% include MovingLogo %>
                    </div>
                </div>
                <div class="section_counter">
                    <a class="section_counter_button button_increaseSQ">+</a>
                    <a class="section_counter_button button_decreaseSQ">-</a>
                    <a class="section_counter_button button_enterShow">→</a>
                </div>
                <div class="section_numbers">
                    <p class="section_numbers_entry numbers_vq">VQ: 0</p>
                    <p class="section_numbers_entry numbers_sq">SQ: 0</p>
                    <p class="section_numbers_entry numbers_tt">TT: 0</p>
                </div>
                <div class="section_popup">
                    <a class="section_popup_text section_popup_close">X</a>
                    <p class="section_popup_text section_popup_client_message">Message</p>
                    <p class="section_popup_text section_popup_client_name">Name</p>
                    <p class="section_popup_text section_popup_client_timeslot">Slot</p>
                    <p class="section_popup_text section_popup_client_timedifference">Difference</p>
                    <p class="section_popup_text section_popup_client_event">Event</p>
                    <a class="section_popup_button button_acceptTicket">Einlass</a>
                    <a class="section_popup_button button_deleteTicket">Löschen</a>
                </div>
                <div class="section_loading">
                    <p>Loading...</p>
                </div>
            </div>
        </div>
    <% end_if %>
    <script src="$Mix("/js/main.js")"></script>
</body>

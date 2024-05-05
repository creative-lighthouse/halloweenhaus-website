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
    <div class="section section--EventsAdmin">
        <div class="section_content">
            <h1>Eingecheckt!</h1>
            <div class="section_buttons">
                <a href="$Top.Link('cancel')/$Registration.Hash" class="button button--secondary">Doch Entfernen</a>
            </div>
        </div>
    </div>
    <script src="$Mix("/js/main.js")"></script>
</body>

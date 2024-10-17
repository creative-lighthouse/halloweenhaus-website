<!DOCTYPE html>
<html lang="de">
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
<body class="body--POSBody">
    <header class="section section--POSHeader">
        <div class="section_content">
            <p class="section_title">$Title</p>
            <p class="section_clock" data-behaviour="pos_clock">17.20.2024 20:15</p>
        </div>
    </header>

    <section class="section section--POSBody">
        <div class="section_background">
            <img class="section_background_image" src="$BackgroundImage.Url"/>
        </div>
        <div class="section_content">
            <div class="section_content_left">
                <% loop $Products %>
                    <div class="product_entry" data-behaviour="pos_product" data-productid="$ID" data-name="$Title" data-price="$Price" data-imageurl="$Image.Url">
                        <div class="product_entry_image">
                            $Image.FocusFill(200,200)
                        </div>
                        <h2 class="product_entry_title">$Title</h2>
                        <p class="product_entry_price">$FormattedPrice</p>
                        <div class="product_entry_controls">
                            <button class="product_entry_controls_button" data-behaviour="pos_product_decrease" data-productid="$ID">-</button>
                            <input class="product_entry_controls_input" type="number" value="0" min="0" max="100" data-behaviour="pos_product_change" data-productid="$ID">
                            <button class="product_entry_controls_button" data-behaviour="pos_product_increase" data-productid="$ID">+</button>
                        </div>
                    </div>
                <% end_loop %>
            </div>
            <div class="section_content_right">
                <div class="productlist_header">
                    <h2>Warenkorb</h2>
                </div>
                <div class="product_list" data-behaviour="pos_cart">
                    <div class="product_list_entry">
                        <div class="product_list_entry_image">
                            $Products.First.Image.FocusFill(200,200)
                        </div>
                        <div class="product_list_entry_content">
                            <h3>Produktname</h3>
                            <p>0,00€ * 0</p>
                            <p>= 0,00€</p>
                        </div>
                    </div>
                    <div class="product_list_entry">
                        <div class="product_list_entry_image">
                            $Products.First.Image.FocusFill(200,200)
                        </div>
                        <div class="product_list_entry_content">
                            <h3>Produktname</h3>
                            <p>0,00€ * 0</p>
                            <p>= 0,00€</p>
                        </div>
                    </div>
                    <div class="product_list_entry">
                        <div class="product_list_entry_image">
                            $Products.First.Image.FocusFill(200,200)
                        </div>
                        <div class="product_list_entry_content">
                            <h3>Produktname</h3>
                            <p>0,00€ * 0</p>
                            <p>= 0,00€</p>
                        </div>
                    </div>
                    <div class="product_list_entry">
                        <div class="product_list_entry_image">
                            $Products.First.Image.FocusFill(200,200)
                        </div>
                        <div class="product_list_entry_content">
                            <h3>Produktname</h3>
                            <p>0,00€ * 0</p>
                            <p>= 0,00€</p>
                        </div>
                    </div>
                    <div class="product_list_entry">
                        <div class="product_list_entry_image">
                            $Products.First.Image.FocusFill(200,200)
                        </div>
                        <div class="product_list_entry_content">
                            <h3>Produktname</h3>
                            <p>0,00€ * 0</p>
                            <p>= 0,00€</p>
                        </div>
                    </div>
                    <div class="product_list_entry">
                        <div class="product_list_entry_image">
                            $Products.First.Image.FocusFill(200,200)
                        </div>
                        <div class="product_list_entry_content">
                            <h3>Produktname</h3>
                            <p>0,00€ * 0</p>
                            <p>= 0,00€</p>
                        </div>
                    </div>
                </div>
                <div class="buying_panel">
                    <div class="buying_panel_total">
                        <p data-behaviour="pos_total-price">0,00€</p>
                    </div>
                    <div class="buying_panel_buy">
                        <button data-behaviour="pos_buy">Bezahlen</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="$Mix("/js/main.js")"></script>
</body>

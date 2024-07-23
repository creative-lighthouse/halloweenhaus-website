<?xml version="1.0" encoding="UTF-8"?>
<rss version="2.0" xmlns:itunes="http://www.itunes.com/dtds/podcast-1.0.dtd" xmlns:content="http://purl.org/rss/1.0/modules/content/">
  <channel>
    <title>$Title</title>
    <link>https://halloweenhaus-schmalenbeck.de/</link>
    <language>ger-de</language>
    <copyright>&#169; 2024 Halloweenhaus Schmalenbeck</copyright>
    <itunes:author>Halloweenhaus Schmalenbeck</itunes:author>
    <description>
      $Description
    </description>
    <itunes:type>episodic</itunes:type>
    <itunes:image
      href="$CoverImage.AbsoluteLink"
    />
    <itunes:category text="Arts">
      <itunes:category text="Performing Arts"/>
    </itunes:category>
    <itunes:explicit>false</itunes:explicit>
    <% loop $Episodes %>
    <item>
      <itunes:episodeType>full</itunes:episodeType>
      <itunes:episode>$Episode</itunes:episode>
      <itunes:season>$Season</itunes:season>
      <title>$Title</title>
      <description>
        $Description
      </description>
      <enclosure
        length="10"
        type="audio/$Audio.getExtension"
        url="$Audio.AbsoluteLink"
      />
      <guid>$Hash</guid>
      <pubDate>$PublishDate</pubDate>
      <itunes:explicit>$ExplicitFormatted</itunes:explicit>
    </item>
    <% end_loop %>
  </channel>
</rss>

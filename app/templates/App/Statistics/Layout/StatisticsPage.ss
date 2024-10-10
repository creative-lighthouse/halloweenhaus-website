<div class="section section--StatisticsPage">
    <div class="section_content">
        $Content
        <h1>Statistiken</h1>
        <p>Gesamte Gästezahl dieses Jahr: {$TotalGuestCountThisYear}</p>
        <p>| davon Virtual Queue Nutzer: {$VQGuestCountThisYear}</p>
        <p>| davon Standby Queue Nutzer: {$SQGuestCountThisYear}</p>
        <div class="guestcount_per_day">
            <% loop GroupedEntryLogs.GroupedBy("Day") %>
                <p>{$Day} Gesamt: {$Children.First.TotalGuestCountOnSameDay}</p>
                <p>| davon VQ: {$Children.First.VQGuestCountOnSameDay}</p>
                <p>| davon SQ: {$Children.First.SQGuestCountOnSameDay}</p>
            <% end_loop %>
    </div>
</div>
